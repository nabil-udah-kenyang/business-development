<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Preloved\Product as PrelovedProduct;
use App\Models\Seller\Product as SellerProduct;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(15);

        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->merge(['name' => trim($request->input('name', ''))]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:categories,name',
                function ($attribute, $value, $fail) {
                    if (Category::whereRaw('LOWER(name) = ?', [strtolower($value)])->exists()) {
                        $fail('Nama kategori sudah digunakan. Gunakan kategori yang sudah tersedia atau nama lain.');
                    }
                },
            ],
        ]);

        Category::create([
            'name' => $validated['name'],
            'is_active' => true,
        ]);

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $request->merge(['name' => trim($request->input('name', ''))]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')->ignore($category->id),
                function ($attribute, $value, $fail) use ($category) {
                    if (Category::whereRaw('LOWER(name) = ?', [strtolower($value)])
                        ->where('id', '!=', $category->id)
                        ->exists()) {
                        $fail('Nama kategori sudah digunakan. Gunakan kategori yang sudah tersedia atau nama lain.');
                    }
                },
            ],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($category->name === 'Lainnya') {
            $validated['name'] = 'Lainnya';
            $validated['is_active'] = true;
        }

        $categoryName = trim($validated['name']);

        if ($category->name !== $categoryName) {
            SellerProduct::where('category', $category->name)->update(['category' => $categoryName]);
            PrelovedProduct::where('category', $category->name)->update(['category' => $categoryName]);
        }

        $category->update([
            'name' => $categoryName,
            'is_active' => (bool) $validated['is_active'],
        ]);

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berhasil diperbarui.');
    }
}
