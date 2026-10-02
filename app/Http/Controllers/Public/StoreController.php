<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Seller\Product;
use App\Models\Seller\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) ($request->input('q') ?? ''));

        $storeQuery = Store::with('owner')
            ->withCount('products')
            ->where('is_active', true);

        if ($search !== '') {
            $storeQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('owner', function ($ownerQuery) use ($search) {
                        $ownerQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $stores = $storeQuery
            ->latest()
            ->paginate(12)
            ->withQueryString();
        $seoTitle = 'Toko Mahasiswa POLMED | Business Development HMPS MI';
        $seoDescription = 'Temukan toko mahasiswa POLMED dan dukung produk karya komunitas kampus melalui Business Development HMPS MI.';
        $seoCanonical = route('stores.index');

        return view('public.stores', compact('stores', 'search', 'seoTitle', 'seoDescription', 'seoCanonical'));
    }

    public function show(string $store)
    {
        $store = Store::with('owner')
            ->withCount('products')
            ->where('slug', $store)
            ->where('is_active', true)
            ->firstOrFail();

        $logo = $store->logo ?: $store->owner?->avatar;
        $storeLogo = $logo ? asset($logo) : null;
        $storeCoverUrl = $store->cover_image
            ? asset($store->cover_image)
            : asset('image/divisi_bd.jpeg');
        $storeInitials = strtoupper(substr($store->name, 0, 2));
        $ownerName = $store->owner?->name ?? 'Pemilik belum diatur';
        $categoryLabel = $store->category ?? 'Toko mahasiswa';
        $locationLabel = $store->location ?? 'Medan';
        $storeDescription = $store->description ?? 'Belum ada deskripsi toko.';
        $productCountLabel = number_format($store->products_count, 0, ',', '.');
        $phoneNumber = preg_replace('/\D+/', '', $store->whatsapp ?: $store->owner?->whatsapp ?? '');

        if (str_starts_with($phoneNumber, '0')) {
            $phoneNumber = '62'.substr($phoneNumber, 1);
        }

        $whatsappLink = $phoneNumber !== ''
            ? 'https://wa.me/'.$phoneNumber.'?text='.rawurlencode('Halo, saya ingin menghubungi toko '.$store->name.'.')
            : null;

        $products = Product::with(['owner', 'store'])
            ->where('store_id', $store->id)
            ->where('status', 'active')
            ->latest()
            ->paginate(8)
            ->withQueryString();
        $seoTitle = $store->name.' | Toko Mahasiswa POLMED | Business Development HMPS MI';
        $seoDescription = Str::limit(strip_tags($storeDescription), 155);
        $seoCanonical = route('stores.show', $store->slug);
        $seoImage = $storeCoverUrl;

        return view('public.store-detail', compact(
            'store',
            'products',
            'storeLogo',
            'storeCoverUrl',
            'storeInitials',
            'ownerName',
            'categoryLabel',
            'locationLabel',
            'storeDescription',
            'productCountLabel',
            'whatsappLink',
            'seoTitle',
            'seoDescription',
            'seoCanonical',
            'seoImage'
        ));
    }

}
