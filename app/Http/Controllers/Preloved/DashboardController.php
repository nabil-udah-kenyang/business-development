<?php

namespace App\Http\Controllers\Preloved;

use App\Http\Controllers\Controller;
use App\Models\Preloved\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $latestProducts = Product::where('user_id', $user->id)
            ->latest()
            ->limit(4)
            ->get();

        $totalProducts = Product::where('user_id', $user->id)
            ->count();

        $activeProducts = Product::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();

        $draftProducts = Product::where('user_id', $user->id)
            ->where('status', 'draft')
            ->count();

        $role = 'preloved';
        $isPreloved = true;

        return view('preloved.dashboard', compact(
            'user',
            'latestProducts',
            'totalProducts',
            'activeProducts',
            'draftProducts',
            'role',
            'isPreloved'
        ));
    }
}
