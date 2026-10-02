<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) ($request->input('q') ?? ''));
        $query = User::whereIn('role', ['seller', 'preloved'])
            ->withCount(['sellerProducts', 'prelovedProducts'])
            ->when($search !== '', function ($userQuery) use ($search) {
                $searchPattern = '%'.strtolower($search).'%';

                $userQuery->where(function ($query) use ($searchPattern) {
                    $query->whereRaw('LOWER(name) LIKE ?', [$searchPattern])
                        ->orWhereRaw('LOWER(email) LIKE ?', [$searchPattern])
                        ->orWhereRaw('LOWER(role) LIKE ?', [$searchPattern]);
                });
            });

        $users = $query->latest()->paginate(15)->withQueryString();

        $users->getCollection()->each(function (User $user) {
            $user->product_count = $user->seller_products_count + $user->preloved_products_count;
        });

        return view('admin.sellers', compact('users', 'search'));
    }
}
