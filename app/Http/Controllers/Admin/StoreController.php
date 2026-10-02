<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller\Store;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::with('owner')
            ->withCount('products')
            ->latest()
            ->paginate(12);

        return view('admin.stores', compact('stores'));
    }
}
