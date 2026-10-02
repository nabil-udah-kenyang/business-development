<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\PromotedListing;
use App\Models\Preloved\Product as PrelovedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PrelovedController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) ($request->input('q') ?? ''));
        $category = (string) ($request->input('category') ?? '');
        $condition = (string) ($request->input('condition') ?? '');
        $hasCatalogFilter = $search !== '' || $category !== '' || $condition !== '';

        $productQuery = PrelovedProduct::with('owner')
            ->where('status', 'active');

        if ($search !== '') {
            $productQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhereHas('owner', function ($ownerQuery) use ($search) {
                        $ownerQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($condition !== '') {
            $productQuery->where('condition', $condition);
        }

        if ($category !== '') {
            $productQuery->where('category', $category);
        }

        $productQuery->latest();

        $recommendedProducts = collect();
        $recommendedSlugs = [];

        if (! $hasCatalogFilter) {
            $recommendedProducts = PromotedListing::visible('preloved')
                ->limit(8)
                ->get()
                ->map(function (PromotedListing $listing) {
                    $product = PrelovedProduct::with('owner')
                        ->where(function ($query) use ($listing) {
                            $query->where('slug', $listing->catalog_slug)
                                ->orWhere('code', $listing->catalog_slug);
                        })
                        ->where('status', 'active')
                        ->first();

                    return $product;
                })
                ->filter()
                ->values();

            $recommendedSlugs = $recommendedProducts->pluck('slug')->all();
        }

        if ($recommendedSlugs !== []) {
            $productQuery->whereNotIn('slug', $recommendedSlugs);
        }

        $products = $productQuery->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $seoTitle = 'Preloved Mahasiswa POLMED | Business Development HMPS MI';
        $seoDescription = 'Temukan barang preloved mahasiswa POLMED yang masih layak digunakan melalui Business Development HMPS MI.';
        $seoCanonical = route('preloved.index');

        return view('public.preloved', compact(
            'search',
            'category',
            'condition',
            'categories',
            'recommendedProducts',
            'products',
            'seoTitle',
            'seoDescription',
            'seoCanonical'
        ));
    }

    public function show(string $product)
    {
        $product = PrelovedProduct::with('owner')
            ->where('slug', $product)
            ->where('status', 'active')
            ->firstOrFail();

        $product->increment('views');

        $ownerName = $product->owner?->name ?? 'Pemilik belum diatur';
        $ownerInitial = strtoupper(substr($product->owner?->name ?? 'P', 0, 1));
        $conditionLabel = strtoupper($product->condition ?? 'Belum diatur');
        $priceLabel = 'Rp'.number_format($product->price, 0, ',', '.');
        $categoryLabel = $product->category ?? 'Lainnya';
        $locationLabel = $product->location ?? 'Medan';
        $descriptionLabel = $product->description ?: 'Belum ada deskripsi barang.';
        $phoneNumber = preg_replace('/\D+/', '', $product->owner?->whatsapp ?? '');

        if (str_starts_with($phoneNumber, '0')) {
            $phoneNumber = '62'.substr($phoneNumber, 1);
        }

        $whatsappLink = $phoneNumber !== ''
            ? 'https://wa.me/'.$phoneNumber.'?text='.rawurlencode('Halo, saya tertarik dengan barang '.$product->name.'.')
            : null;

        $gallery = collect([
            $product->image,
            ...($product->images ?? []),
        ])
            ->filter()
            ->unique()
            ->values()
            ->map(fn (string $image, int $index): array => [
                'index' => $index,
                'url' => asset($image),
                'alt' => 'Foto '.($index + 1).' '.$product->name,
            ])
            ->all();

        $productImageUrl = $gallery[0]['url'] ?? asset('image/divisi_bd.jpeg');
        $seoTitle = $product->name.' | Preloved Mahasiswa POLMED | Business Development HMPS MI';
        $seoDescription = Str::limit(strip_tags($descriptionLabel), 155);
        $seoCanonical = route('preloved.show', $product->slug);
        $seoImage = $productImageUrl;
        $seoType = 'product';

        return view('public.preloved-detail', compact(
            'product',
            'ownerName',
            'ownerInitial',
            'conditionLabel',
            'priceLabel',
            'categoryLabel',
            'locationLabel',
            'descriptionLabel',
            'whatsappLink',
            'productImageUrl',
            'gallery',
            'seoTitle',
            'seoDescription',
            'seoCanonical',
            'seoImage',
            'seoType'
        ));
    }

}
