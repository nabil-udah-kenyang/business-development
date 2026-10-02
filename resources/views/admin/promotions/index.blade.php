@extends('layouts.admin')
@section('title', 'Slot Rekomendasi')
@section('content')
<div class="flex flex-wrap items-end justify-between gap-4">
    <div>
        <span class="eyebrow">Promoted placement</span>
        <h1 class="mt-2 text-3xl font-bold">Slot rekomendasi</h1>
        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Kelola posisi rekomendasi secara terpisah untuk preloved dan produk mahasiswa.</p>
    </div>
    <a href="{{ route('admin.promotions.create') }}" class="btn-primary"><i data-lucide="plus" class="h-4 w-4"></i>Tambah slot</a>
</div>

<div class="mt-8 grid gap-4 sm:grid-cols-3">
    <div class="soft-card p-5"><span class="text-xs font-bold text-slate-400">Total slot</span><strong class="mt-3 block text-3xl">{{ $totalListingCount }}</strong><span class="mt-2 block text-xs text-slate-400">Produk & preloved</span></div>
    <div class="soft-card p-5"><span class="text-xs font-bold text-slate-400">Slot aktif</span><strong class="mt-3 block text-3xl text-violet-600">{{ $activeListingCount }}</strong><span class="mt-2 block text-xs text-slate-400">Tampil di katalog publik</span></div>
    <div class="soft-card p-5"><span class="text-xs font-bold text-slate-400">Potensi pemasukan</span><strong class="mt-3 block text-3xl">{{ $activeListingRevenueLabel }}</strong><span class="mt-2 block text-xs text-slate-400">Dari slot aktif</span></div>
</div>

<section class="mt-8">
    <div class="mb-4 flex items-end justify-between gap-3">
        <div><span class="eyebrow">Preloved</span><h2 class="mt-2 text-2xl font-bold">Rekomendasi preloved</h2></div>
        <span class="text-xs font-semibold text-slate-400">{{ $prelovedListings->count() }} slot</span>
    </div>
    <div class="soft-card overflow-x-auto">
        <table class="admin-table min-w-[820px] w-full">
            <thead><tr><th>Konten</th><th>Biaya</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse ($prelovedListings as $listing)
                    <tr>
                        <td><div class="flex items-center gap-3"><img src="{{ $listing->image }}" alt="" class="h-12 w-12 rounded-xl object-cover"><div><strong class="block">{{ $listing->name }}</strong><span class="mt-1 block text-xs text-slate-400">{{ $listing->seller }} · ID: {{ $listing->catalog_slug }}</span></div></div></td>
                        <td>Rp{{ number_format($listing->fee, 0, ',', '.') }}</td>
                        <td><span class="chip {{ $listing->is_active ? 'chip-purple' : '' }}">{{ $listing->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td><div class="flex items-center gap-2"><a href="{{ route('admin.promotions.edit', $listing) }}" class="btn-soft !rounded-xl !px-3 !py-2 text-xs">Edit</a><form method="POST" action="{{ route('admin.promotions.destroy', $listing) }}" onsubmit="return confirm('Hapus slot rekomendasi ini?')">@csrf @method('DELETE')<button class="text-xs font-bold text-slate-500 hover:text-red-600" type="submit">Hapus</button></form></div></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-8 text-center text-sm text-slate-500">Belum ada slot rekomendasi preloved.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($prelovedListings->hasPages())
        <div class="mt-6">{{ $prelovedListings->links() }}</div>
    @endif
</section>

<section class="mt-10">
    <div class="mb-4 flex items-end justify-between gap-3">
        <div><span class="eyebrow">Produk mahasiswa</span><h2 class="mt-2 text-2xl font-bold">Rekomendasi produk mahasiswa</h2></div>
        <span class="text-xs font-semibold text-slate-400">{{ $productListings->count() }} slot</span>
    </div>
    <div class="soft-card overflow-x-auto">
        <table class="admin-table min-w-[820px] w-full">
            <thead><tr><th>Konten</th><th>Biaya</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse ($productListings as $listing)
                    <tr>
                        <td><div class="flex items-center gap-3"><img src="{{ $listing->image }}" alt="" class="h-12 w-12 rounded-xl object-cover"><div><strong class="block">{{ $listing->name }}</strong><span class="mt-1 block text-xs text-slate-400">{{ $listing->seller }} · ID: {{ $listing->catalog_slug }}</span></div></div></td>
                        <td>Rp{{ number_format($listing->fee, 0, ',', '.') }}</td>
                        <td><span class="chip {{ $listing->is_active ? 'chip-purple' : '' }}">{{ $listing->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td><div class="flex items-center gap-2"><a href="{{ route('admin.promotions.edit', $listing) }}" class="btn-soft !rounded-xl !px-3 !py-2 text-xs">Edit</a><form method="POST" action="{{ route('admin.promotions.destroy', $listing) }}" onsubmit="return confirm('Hapus slot rekomendasi ini?')">@csrf @method('DELETE')<button class="text-xs font-bold text-slate-500 hover:text-red-600" type="submit">Hapus</button></form></div></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-8 text-center text-sm text-slate-500">Belum ada slot rekomendasi produk mahasiswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($productListings->hasPages())
        <div class="mt-6">{{ $productListings->links() }}</div>
    @endif
</section>
@endsection
