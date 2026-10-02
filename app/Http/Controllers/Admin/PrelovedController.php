<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Preloved\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PrelovedController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) ($request->input('q') ?? ''));
        $status = (string) ($request->input('status') ?? '');

        $query = Product::with('owner');

        if ($search !== '') {
            $searchPattern = '%'.strtolower($search).'%';

            $query->where(function ($productQuery) use ($searchPattern) {
                $productQuery->whereRaw('LOWER(name) LIKE ?', [$searchPattern])
                    ->orWhereRaw('LOWER(code) LIKE ?', [$searchPattern])
                    ->orWhereHas('owner', function ($ownerQuery) use ($searchPattern) {
                        $ownerQuery->whereRaw('LOWER(name) LIKE ?', [$searchPattern]);
                    });
            });
        }

        if ($status !== '') {
            $query->where('status', $status);
        }

        $products = $query->latest()->paginate(15)->withQueryString();

        return view('admin.preloved', compact('products', 'search', 'status'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['active', 'draft'])],
        ]);

        $product->update([
            'status' => $validated['status'],
            'approved_at' => $validated['status'] === 'active' ? now() : null,
        ]);

        return back()->with('status', 'Status barang preloved berhasil diperbarui.');
    }
}
