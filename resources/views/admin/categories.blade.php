@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
    <div>
        <span class="eyebrow">Catalog settings</span>
        <h1 class="mt-2 text-3xl font-bold">Kelola kategori</h1>
        <p class="mt-2 text-sm text-slate-500"> daftar kategori untuk produk UMKM dan preloved</p>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-[minmax(0,1fr)_18rem]">
        <div class="soft-card overflow-x-auto">
            <table class="admin-table min-w-[620px] w-full">
                <thead>
                    <tr>
                        <th>Nama kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>
                                <form id="category-update-{{ $category->id }}" method="POST"
                                    action="{{ route('admin.categories.update', $category) }}">
                                    @csrf
                                    @method('PUT')
                                </form>
                                <input form="category-update-{{ $category->id }}" name="name"
                                    value="{{ $category->name }}" class="field min-w-0 flex-1 !py-2 text-sm"
                                    @disabled($category->name === 'Lainnya')>
                                @if ($category->name === 'Lainnya')
                                    <input form="category-update-{{ $category->id }}" type="hidden" name="name"
                                        value="Lainnya">
                                @endif
                            </td>
                            <td>
                                <select form="category-update-{{ $category->id }}" name="is_active"
                                    class="field !w-32 !py-2 text-sm" @disabled($category->name === 'Lainnya')>
                                    <option value="1" @selected($category->is_active)>Aktif</option>
                                    <option value="0" @selected(!$category->is_active)>Nonaktif</option>
                                </select>
                                @if ($category->name === 'Lainnya')
                                    <input form="category-update-{{ $category->id }}" type="hidden" name="is_active"
                                        value="1">
                                @endif
                            </td>
                            <td>
                                <button form="category-update-{{ $category->id }}" type="submit"
                                    class="btn-soft !px-3 !py-2 text-xs">Simpan</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-8 text-center text-sm text-slate-500">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="soft-card h-fit p-5">
            <span class="eyebrow">Kategori baru</span>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="mt-5 grid gap-3">
                @csrf
                <label class="text-sm font-bold">Nama kategori
                    <input name="name" value="{{ old('name') }}" class="field mt-2" placeholder="Contoh: Kesehatan"
                        required>
                </label>
                <button type="submit" class="btn-primary">Tambah kategori</button>
            </form>
        </div>
    </div>

    @if ($categories->hasPages())
        <div class="mt-6">{{ $categories->links() }}</div>
    @endif
@endsection
