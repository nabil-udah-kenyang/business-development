<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Admin\SiteSetting;
use App\Models\Preloved\Product as PrelovedProduct;
use App\Models\Seller\Product as SellerProduct;
use App\Models\Seller\Store;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::first();
        $teamPhotoPath = $settings?->team_photo;

        $teamPhotoUrl = $teamPhotoPath
            ? asset($teamPhotoPath)
            : asset('image/divisi_bd.jpeg');

        $memberCount = User::query()
            ->whereIn('role', ['seller', 'preloved'])
            ->where('status', 'active')
            ->count();

        $storeCount = Store::query()
            ->where('is_active', true)
            ->count();

        $workCount = SellerProduct::query()->where('status', 'active')->count()
            + PrelovedProduct::query()->where('status', 'active')->count();

        $memberCountLabel = number_format($memberCount, 0, ',', '.');
        $storeCountLabel = number_format($storeCount, 0, ',', '.');
        $workCountLabel = number_format($workCount, 0, ',', '.');
        $seoTitle = 'Business Development HMPS MI | Ruang Tumbuh Mahasiswa';
        $seoDescription = 'Temukan produk, jasa, toko, dan barang preloved karya mahasiswa POLMED melalui Business Development HMPS MI.';
        $seoCanonical = route('home');
        $seoImage = $teamPhotoUrl;

        return view('public.home', compact(
            'teamPhotoUrl',
            'memberCountLabel',
            'storeCountLabel',
            'workCountLabel',
            'seoTitle',
            'seoDescription',
            'seoCanonical',
            'seoImage'
        ));
    }
}
