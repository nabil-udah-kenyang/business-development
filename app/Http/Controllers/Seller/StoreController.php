<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller\Store;
use App\Services\ImageWebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $store = Store::where('user_id', $request->user()->id)
            ->withCount('products')
            ->latest()
            ->first();

        return view('seller.store', compact('store'));
    }

    public function update(Request $request, ImageWebpService $imageWebp)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $store = Store::firstOrNew(['user_id' => $request->user()->id]);

        if (! $store->slug) {
            $slug = Str::slug($validated['name']);
            $candidate = $slug;
            $suffix = 2;

            while (Store::where('slug', $candidate)->exists()) {
                $candidate = $slug.'-'.$suffix++;
            }

            $store->slug = $candidate;
        }

        $store->fill([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'category' => $validated['category'] ?? null,
            'location' => $validated['location'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => true,
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $store->logo = $imageWebp->store($file, 'store-logo');
        }

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $store->cover_image = $imageWebp->store($file, 'store-cover');
        }

        $store->save();

        return back()->with('status', 'Profil toko berhasil disimpan.');
    }

}
