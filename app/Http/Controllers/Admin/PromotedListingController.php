<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PromotedListing;
use App\Models\Preloved\Product as PrelovedProduct;
use App\Models\Seller\Product as SellerProduct;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PromotedListingController extends Controller
{
    public function index()
    {
        $totalListingCount = PromotedListing::count();
        $activeListingCount = PromotedListing::where('is_active', true)->count();
        $activeListingRevenue = PromotedListing::where('is_active', true)->sum('fee');

        $prelovedListings = PromotedListing::where('catalog_type', 'preloved')
            ->orderBy('position')
            ->paginate(10, ['*'], 'preloved_page')
            ->withQueryString();
        $productListings = PromotedListing::where('catalog_type', 'products')
            ->orderBy('position')
            ->paginate(10, ['*'], 'products_page')
            ->withQueryString();

        $activeListingRevenueLabel = 'Rp'.number_format($activeListingRevenue, 0, ',', '.');

        return view('admin.promotions.index', compact(
            'totalListingCount',
            'prelovedListings',
            'productListings',
            'activeListingCount',
            'activeListingRevenue',
            'activeListingRevenueLabel'
        ));
    }

    public function create(Request $request)
    {
        $listing = new PromotedListing;

        $products = SellerProduct::with('owner')
            ->where('status', 'active')
            ->get()
            ->map(function (SellerProduct $product) {
                return [
                    'catalog_type' => 'products',
                    'catalog_slug' => $product->slug,
                    'product_code' => $product->code,
                    'name' => $product->name,
                    'price' => 'Rp'.number_format($product->price, 0, ',', '.'),
                    'seller' => $product->owner?->name ?? 'Pemilik belum diatur',
                    'category' => $product->category ?? 'Lainnya',
                    'location' => $product->location ?? 'Medan',
                    'views' => $product->views,
                    'listing_type' => $product->type === 'service' ? 'Jasa' : 'Produk',
                    'condition' => null,
                    'image' => $product->image ? asset($product->image) : asset('image/divisi_bd.jpeg'),
                ];
            });

        $preloved = PrelovedProduct::with('owner')
            ->where('status', 'active')
            ->get()
            ->map(function (PrelovedProduct $product) {
                return [
                    'catalog_type' => 'preloved',
                    'catalog_slug' => $product->slug,
                    'product_code' => $product->code,
                    'name' => $product->name,
                    'price' => 'Rp'.number_format($product->price, 0, ',', '.'),
                    'seller' => $product->owner?->name ?? 'Pemilik belum diatur',
                    'category' => $product->category ?? 'Lainnya',
                    'location' => $product->location ?? 'Medan',
                    'views' => $product->views,
                    'listing_type' => 'Preloved',
                    'condition' => $product->condition,
                    'image' => $product->image ? asset($product->image) : asset('image/divisi_bd.jpeg'),
                ];
            });

        $catalogOptions = $products->concat($preloved)->values()->all();
        $editing = false;
        $selectedType = old('catalog_type', $listing->catalog_type);
        $selectedSlug = old('catalog_slug', $listing->catalog_slug);
        $selectedProduct = collect($catalogOptions)->first(function (array $product) use ($selectedType, $selectedSlug) {
            return $product['catalog_type'] === $selectedType
                && $product['catalog_slug'] === $selectedSlug;
        });

        return view('admin.promotions.form', compact(
            'listing',
            'catalogOptions',
            'editing',
            'selectedType',
            'selectedSlug',
            'selectedProduct'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'catalog_type' => ['required', Rule::in(['products', 'preloved'])],
            'catalog_slug' => [
                'required',
                'string',
                'max:120',
                Rule::unique('promoted_listings', 'catalog_slug')
                    ->where(function ($query) use ($request) {
                        $query->where('catalog_type', $request->input('catalog_type'));
                    }),
            ],
            'fee' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validated['catalog_type'] === 'products') {
            $product = SellerProduct::with('owner')
                ->where('status', 'active')
                ->where(function ($query) use ($validated) {
                    $query->where('slug', $validated['catalog_slug'])
                        ->orWhere('code', $validated['catalog_slug']);
                })
                ->first();
        } else {
            $product = PrelovedProduct::with('owner')
                ->where('status', 'active')
                ->where(function ($query) use ($validated) {
                    $query->where('slug', $validated['catalog_slug'])
                        ->orWhere('code', $validated['catalog_slug']);
                })
                ->first();
        }

        if (! $product) {
            throw ValidationException::withMessages([
                'catalog_slug' => 'Pilih produk yang tersedia dari daftar katalog.',
            ]);
        }

        $lastPosition = PromotedListing::where('catalog_type', $validated['catalog_type'])->max('position');
        $position = ($lastPosition ?: 0) + 1;
        $isPreloved = $validated['catalog_type'] === 'preloved';

        PromotedListing::create(array_merge($validated, [
            'name' => $product->name,
            'price' => 'Rp'.number_format($product->price, 0, ',', '.'),
            'seller' => $product->owner?->name ?? 'Pemilik belum diatur',
            'category' => $product->category ?? 'Lainnya',
            'location' => $product->location ?? 'Medan',
            'views' => $product->views,
            'listing_type' => $isPreloved ? 'Preloved' : ($product->type === 'service' ? 'Jasa' : 'Produk'),
            'condition' => $isPreloved ? $product->condition : null,
            'image' => $product->image ? asset($product->image) : asset('image/divisi_bd.jpeg'),
            'position' => $position,
        ]));

        return redirect()->route('admin.promotions.index')->with('status', 'Slot rekomendasi berhasil ditambahkan.');
    }

    public function edit(Request $request, PromotedListing $promotion)
    {
        $listing = $promotion;

        $products = SellerProduct::with('owner')
            ->where('status', 'active')
            ->get()
            ->map(function (SellerProduct $product) {
                return [
                    'catalog_type' => 'products',
                    'catalog_slug' => $product->slug,
                    'product_code' => $product->code,
                    'name' => $product->name,
                    'price' => 'Rp'.number_format($product->price, 0, ',', '.'),
                    'seller' => $product->owner?->name ?? 'Pemilik belum diatur',
                    'category' => $product->category ?? 'Lainnya',
                    'location' => $product->location ?? 'Medan',
                    'views' => $product->views,
                    'listing_type' => $product->type === 'service' ? 'Jasa' : 'Produk',
                    'condition' => null,
                    'image' => $product->image ? asset($product->image) : asset('image/divisi_bd.jpeg'),
                ];
            });

        $preloved = PrelovedProduct::with('owner')
            ->where('status', 'active')
            ->get()
            ->map(function (PrelovedProduct $product) {
                return [
                    'catalog_type' => 'preloved',
                    'catalog_slug' => $product->slug,
                    'product_code' => $product->code,
                    'name' => $product->name,
                    'price' => 'Rp'.number_format($product->price, 0, ',', '.'),
                    'seller' => $product->owner?->name ?? 'Pemilik belum diatur',
                    'category' => $product->category ?? 'Lainnya',
                    'location' => $product->location ?? 'Medan',
                    'views' => $product->views,
                    'listing_type' => 'Preloved',
                    'condition' => $product->condition,
                    'image' => $product->image ? asset($product->image) : asset('image/divisi_bd.jpeg'),
                ];
            });

        $catalogOptions = $products->concat($preloved)->values()->all();
        $editing = true;
        $selectedType = old('catalog_type', $listing->catalog_type);
        $selectedSlug = old('catalog_slug', $listing->catalog_slug);
        $selectedProduct = collect($catalogOptions)->first(function (array $product) use ($selectedType, $selectedSlug) {
            return $product['catalog_type'] === $selectedType
                && $product['catalog_slug'] === $selectedSlug;
        });

        return view('admin.promotions.form', compact(
            'listing',
            'catalogOptions',
            'editing',
            'selectedType',
            'selectedSlug',
            'selectedProduct'
        ));
    }

    public function update(Request $request, PromotedListing $promotion)
    {
        $validated = $request->validate([
            'catalog_type' => ['required', Rule::in(['products', 'preloved'])],
            'catalog_slug' => [
                'required',
                'string',
                'max:120',
                Rule::unique('promoted_listings', 'catalog_slug')
                    ->where(function ($query) use ($request) {
                        $query->where('catalog_type', $request->input('catalog_type'));
                    })
                    ->ignore($promotion->id),
            ],
            'fee' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validated['catalog_type'] === 'products') {
            $product = SellerProduct::with('owner')
                ->where('status', 'active')
                ->where(function ($query) use ($validated) {
                    $query->where('slug', $validated['catalog_slug'])
                        ->orWhere('code', $validated['catalog_slug']);
                })
                ->first();
        } else {
            $product = PrelovedProduct::with('owner')
                ->where('status', 'active')
                ->where(function ($query) use ($validated) {
                    $query->where('slug', $validated['catalog_slug'])
                        ->orWhere('code', $validated['catalog_slug']);
                })
                ->first();
        }

        if (! $product) {
            throw ValidationException::withMessages([
                'catalog_slug' => 'Pilih produk yang tersedia dari daftar katalog.',
            ]);
        }

        $position = $promotion->catalog_type === $validated['catalog_type']
            ? $promotion->position
            : ((PromotedListing::where('catalog_type', $validated['catalog_type'])->max('position') ?: 0) + 1);
        $isPreloved = $validated['catalog_type'] === 'preloved';

        $promotion->update(array_merge($validated, [
            'name' => $product->name,
            'price' => 'Rp'.number_format($product->price, 0, ',', '.'),
            'seller' => $product->owner?->name ?? 'Pemilik belum diatur',
            'category' => $product->category ?? 'Lainnya',
            'location' => $product->location ?? 'Medan',
            'views' => $product->views,
            'listing_type' => $isPreloved ? 'Preloved' : ($product->type === 'service' ? 'Jasa' : 'Produk'),
            'condition' => $isPreloved ? $product->condition : null,
            'image' => $product->image ? asset($product->image) : asset('image/divisi_bd.jpeg'),
            'position' => $position,
        ]));

        return redirect()->route('admin.promotions.index')->with('status', 'Slot rekomendasi berhasil diperbarui.');
    }

    public function destroy(PromotedListing $promotion)
    {
        $promotion->delete();

        return redirect()->route('admin.promotions.index')->with('status', 'Slot rekomendasi berhasil dihapus.');
    }
}
