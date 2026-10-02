<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Seller\Product;
use App\Models\Seller\Store;
use App\Services\ImageWebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('q', ''));
        $status = (string) $request->input('status', '');

        $query = Product::with('store')
            ->where('user_id', $request->user()->id);

        if ($search !== '') {
            $searchPattern = '%'.strtolower($search).'%';

            $query->where(function ($productQuery) use ($searchPattern) {
                $productQuery->whereRaw('LOWER(name) LIKE ?', [$searchPattern])
                    ->orWhereRaw('LOWER(code) LIKE ?', [$searchPattern])
                    ->orWhereRaw('LOWER(category) LIKE ?', [$searchPattern]);
            });
        }

        if ($status !== '') {
            $query->where('status', $status);
        }

        $products = $query->latest()->paginate(10);

        return view('seller.products', compact('products', 'search', 'status'));
    }

    public function create(Request $request)
    {
        $store = Store::where('user_id', $request->user()->id)
            ->where('is_active', true)
            ->latest()
            ->first();
        $product = new Product([
            'type' => 'product',
            'status' => 'draft',
            'location' => $request->user()->location,
            'store_id' => $store?->id,
        ]);
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $editing = false;
        $images = array_values(array_unique(array_filter([
            $product->image,
            ...($product->images ?? []),
        ])));
        $imageSlots = collect(range(0, 4))->map(function (int $index) use ($images): array {
            $image = $images[$index] ?? null;

            return [
                'index' => $index,
                'url' => $image ? asset($image) : null,
                'exists' => $image !== null,
            ];
        })->all();

        return view('seller.product-form', compact('product', 'store', 'categories', 'editing', 'imageSlots'));
    }

    public function store(Request $request, ImageWebpService $imageWebp)
    {
        $store = Store::where('user_id', $request->user()->id)
            ->where('is_active', true)
            ->latest()
            ->first();

        if (! $store) {
            return redirect()->route('seller.store')->with('error', 'Buat dan aktifkan toko terlebih dahulu sebelum menambahkan produk.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:product,service'],
            'category' => [
                'required',
                'string',
                Rule::exists('categories', 'name')->where(function ($query) {
                    $query->where('is_active', true);
                }),
            ],
            'price' => ['required', 'integer', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'specifications' => ['nullable', 'string'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
        $validated['user_id'] = $request->user()->id;
        $validated['store_id'] = $store->id;

        do {
            $code = '#PD-'.Str::upper(Str::random(6));
        } while (Product::where('code', $code)->exists());

        $validated['code'] = $code;

        $slug = Str::slug($validated['name']);
        $candidate = $slug;
        $suffix = 2;

        while (Product::where('slug', $candidate)->exists()) {
            $candidate = $slug.'-'.$suffix++;
        }

        $validated['slug'] = $candidate;
        $validated['status'] = 'draft';

        $images = [];

        foreach ($request->file('images', []) as $file) {
            if (! $file) {
                continue;
            }

            $images[] = $imageWebp->store($file, 'product');
        }

        if ($images !== []) {
            $validated['image'] = $images[0];
            $validated['images'] = $images;
        }

        Product::create($validated);

        return redirect()->route('seller.products')->with('status', 'Produk berhasil disimpan sebagai draft.');
    }

    public function edit(Request $request, string $product)
    {
        $store = Store::where('user_id', $request->user()->id)
            ->where('is_active', true)
            ->latest()
            ->first();
        $productModel = Product::with('store')
            ->where('user_id', $request->user()->id)
            ->where('slug', $product)
            ->firstOrFail();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $editing = true;
        $images = array_values(array_unique(array_filter([
            $productModel->image,
            ...($productModel->images ?? []),
        ])));
        $imageSlots = collect(range(0, 4))->map(function (int $index) use ($images): array {
            $image = $images[$index] ?? null;

            return [
                'index' => $index,
                'url' => $image ? asset($image) : null,
                'exists' => $image !== null,
            ];
        })->all();

        return view('seller.product-form', [
            'product' => $productModel,
            'store' => $store,
            'categories' => $categories,
            'editing' => $editing,
            'imageSlots' => $imageSlots,
        ]);
    }

    public function update(Request $request, string $product, ImageWebpService $imageWebp)
    {
        $store = Store::where('user_id', $request->user()->id)
            ->where('is_active', true)
            ->latest()
            ->first();

        if (! $store) {
            return redirect()->route('seller.store')->with('error', 'Buat dan aktifkan toko terlebih dahulu sebelum mengubah produk.');
        }

        $productModel = Product::where('user_id', $request->user()->id)
            ->where('slug', $product)
            ->firstOrFail();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:product,service'],
            'category' => [
                'required',
                'string',
                Rule::exists('categories', 'name')->where(function ($query) {
                    $query->where('is_active', true);
                }),
            ],
            'price' => ['required', 'integer', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'specifications' => ['nullable', 'string'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $hasImageChanges = $request->hasFile('images') || $request->input('remove_images', []) !== [];

        if ($hasImageChanges) {
            $existingImages = array_values(array_unique(array_filter([
                $productModel->image,
                ...($productModel->images ?? []),
            ])));
            $uploadedImages = $request->file('images', []);
            $removedImages = $request->input('remove_images', []);
            $images = [];

            for ($index = 0; $index < 5; $index++) {
                if (! empty($removedImages[$index])) {
                    continue;
                }

                if (isset($uploadedImages[$index])) {
                    $file = $uploadedImages[$index];
                    $images[] = $imageWebp->store($file, 'product');

                    continue;
                }

                if (isset($existingImages[$index])) {
                    $images[] = $existingImages[$index];
                }
            }

            $validated['image'] = $images[0] ?? null;
            $validated['images'] = $images;
        }

        $validated['store_id'] = $store->id;
        $productModel->update($validated);

        return redirect()->route('seller.products')->with('status', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, string $product)
    {
        $productModel = Product::where('user_id', $request->user()->id)
            ->where('slug', $product)
            ->firstOrFail();
        $productModel->delete();

        return redirect()->route('seller.products')->with('status', 'Produk berhasil dihapus.');
    }

}
