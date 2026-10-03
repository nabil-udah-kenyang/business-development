@extends('layouts.dashboard')

@section('title', 'Produk Saya')

@section('content')
    <div class="flex items-end justify-between gap-4">
        <div><span class="eyebrow">Seller space</span><h1 class="mt-2 text-3xl font-bold">Produk saya</h1><p class="mt-2 text-sm text-slate-500">Kelola produk dan jasa yang kamu tawarkan.</p></div>
        <a href="{{ route('seller.products.create') }}" class="btn-primary"><i data-lucide="plus" class="h-4 w-4"></i><span class="hidden sm:inline">Tambah produk</span></a>
    </div>

    @include('partials.product-publication-note')

    <div class="soft-card mt-5 overflow-hidden">
        <form method="GET" action="{{ route('seller.products') }}" class="flex flex-col gap-3 border-b border-slate-200/70 p-4 sm:flex-row">
            <div class="soft-inset flex flex-1 items-center gap-2 rounded-xl px-3"><i data-lucide="search" class="h-4 w-4 text-slate-400"></i><input type="search" name="q" value="{{ $search }}" class="w-full border-0 bg-transparent py-2 text-sm outline-none" placeholder="Cari produk, kode, atau kategori..." autocomplete="off"></div>
            <select name="status" class="field sm:w-40">
                <option value="">Semua status</option>
                <option value="active" @selected($status === 'active')>Aktif</option>
                <option value="draft" @selected($status === 'draft')>Draft</option>
            </select>
            <button type="submit" class="btn-soft">Cari</button>
        </form>
        <div class="divide-y divide-slate-200/70">
            @forelse ($products as $product)
                <div class="flex flex-wrap items-center gap-3 p-4 sm:flex-nowrap">
                    <img class="h-14 w-14 rounded-xl object-cover" src="{{ $product->image ? asset($product->image) : asset('image/divisi_bd.jpeg') }}" alt="{{ $product->name }}">
                    <div class="min-w-0 flex-1">
                        <strong class="block text-sm">{{ $product->name }}</strong>
                        <span class="text-xs font-bold text-violet-600">ID: {{ $product->code }}</span>
                        <span class="mt-1 block text-xs text-slate-400">{{ $product->category ?? 'Lainnya' }} · Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <span class="chip {{ $product->status === 'active' ? 'chip-purple' : '' }}">{{ ucfirst($product->status ?? 'draft') }}</span>
                    <a class="btn-soft !p-2" href="{{ route('seller.products.edit', $product->slug) }}" aria-label="Edit produk"><i data-lucide="pencil" class="h-4 w-4"></i></a>
                    <form method="POST" action="{{ route('seller.products.destroy', $product->slug) }}" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf @method('DELETE')
                        <button class="btn-soft !p-2 text-red-600" type="submit" aria-label="Hapus produk"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                    </form>
                </div>
            @empty
                <p class="p-6 text-sm text-slate-500">Belum ada produk. Tambahkan produk pertamamu.</p>
            @endforelse
        </div>
    </div>
    @if ($products->hasPages())
        <div class="mt-6">{{ $products->links() }}</div>
    @endif
@endsection
