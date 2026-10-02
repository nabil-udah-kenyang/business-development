<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\PromotedListing;
use App\Models\Seller\Product as SellerProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) ($request->input('q') ?? ''));
        $category = (string) ($request->input('category') ?? '');
        $hasCatalogFilter = $search !== '' || $category !== '';

        $productQuery = SellerProduct::with(['owner', 'store'])
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

        if ($category !== '') {
            $productQuery->where('category', $category);
        }

        $productQuery->latest();

        $recommendedProducts = collect();
        $recommendedSlugs = [];

        if (! $hasCatalogFilter) {
            $recommendedProducts = PromotedListing::visible('products')
                ->limit(8)
                ->get()
                ->map(function (PromotedListing $listing) {
                    $product = SellerProduct::with(['owner', 'store'])
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
        $seoTitle = 'Produk UMKM Mahasiswa POLMED | Business Development HMPS MI';
        $seoDescription = 'Jelajahi produk dan jasa UMKM mahasiswa POLMED yang dikurasi Business Development HMPS MI.';
        $seoCanonical = route('products.index');

        return view('public.products', compact(
            'search',
            'category',
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
        $product = SellerProduct::with(['owner', 'store.owner'])
            ->where('slug', $product)
            ->where('status', 'active')
            ->firstOrFail();

        $product->increment('views');

        $store = $product->store;
        $storeOwner = $store?->owner ?? $product->owner;
        $logo = $store?->logo ?: $storeOwner?->avatar;
        $storeLogo = $logo ? asset($logo) : null;
        $sellerName = $store?->name ?? $storeOwner?->name ?? 'Pemilik belum diatur';
        $sellerInitials = strtoupper(substr($sellerName, 0, 2));
        $storeOwnerName = $storeOwner?->name ?? 'Belum diatur';
        $priceLabel = 'Rp'.number_format($product->price, 0, ',', '.');
        $categoryLabel = $product->category ?? 'Lainnya';
        $locationLabel = $product->location ?? 'Medan';
        $typeLabel = $product->type === 'service' ? 'Jasa' : 'Produk';
        $descriptionLabel = $product->description ?: 'Belum ada deskripsi produk.';
        $phoneNumber = preg_replace('/\D+/', '', $store?->whatsapp ?: $storeOwner?->whatsapp ?? '');

        if (str_starts_with($phoneNumber, '0')) {
            $phoneNumber = '62'.substr($phoneNumber, 1);
        }

        $whatsappLink = $phoneNumber !== ''
            ? 'https://wa.me/'.$phoneNumber.'?text='.rawurlencode('Halo, saya tertarik dengan produk '.$product->name.'.')
            : null;

        $relatedQuery = SellerProduct::with(['owner', 'store'])
            ->where('id', '!=', $product->id)
            ->where('status', 'active');

        if ($product->store_id) {
            $relatedQuery->where('store_id', $product->store_id);
        } else {
            $relatedQuery->where('user_id', $product->user_id);
        }

        $relatedProducts = $relatedQuery
            ->latest()
            ->limit(4)
            ->get();

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
        $seoTitle = $product->name.' | Produk UMKM Mahasiswa POLMED | Business Development HMPS MI';
        $seoDescription = Str::limit(strip_tags($descriptionLabel), 155);
        $seoCanonical = route('products.show', $product->slug);
        $seoImage = $productImageUrl;
        $seoType = 'product';

        return view('public.product-detail', compact(
            'product',
            'store',
            'storeOwnerName',
            'storeLogo',
            'sellerName',
            'sellerInitials',
            'whatsappLink',
            'priceLabel',
            'categoryLabel',
            'locationLabel',
            'typeLabel',
            'descriptionLabel',
            'productImageUrl',
            'gallery',
            'relatedProducts',
            'seoTitle',
            'seoDescription',
            'seoCanonical',
            'seoImage',
            'seoType'
        ));
    }

}
