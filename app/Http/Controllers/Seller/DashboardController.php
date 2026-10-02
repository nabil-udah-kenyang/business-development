<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $userProducts = Product::where('user_id', $user->id);
        $latestProducts = (clone $userProducts)
            ->latest()
            ->limit(4)
            ->get();
        $totalProducts = (clone $userProducts)->count();
        $activeProducts = (clone $userProducts)->where('status', 'active')->count();
        $draftProducts = (clone $userProducts)->where('status', 'draft')->count();
        $store = $user->stores()->latest()->first();
        $role = 'seller';
        $isPreloved = false;
        $storeNameLabel = $store?->name ?? 'Toko belum dibuat';
        $storeDescriptionLabel = $store
            ? (($store->category ?? 'Toko mahasiswa').' · '.($store->location ?? 'Medan'))
            : 'Lengkapi identitas toko agar produkmu lebih mudah ditemukan.';

        return view('seller.dashboard', compact(
            'user',
            'latestProducts',
            'totalProducts',
            'activeProducts',
            'draftProducts',
            'store',
            'storeNameLabel',
            'storeDescriptionLabel',
            'role',
            'isPreloved'
        ));
    }
}
