@extends('layouts.dashboard')

@section('title', 'Dashboard Seller')

@section('content')
    <div class="flex items-start justify-between gap-4">
        <div>
            <span class="eyebrow">Seller space</span>
            <h1 class="mt-2 text-3xl font-bold">Selamat datang, {{ $user?->name ?? 'Seller' }}</h1>
            <p class="mt-2 text-sm text-slate-500">Pantau etalase dan produk kamu di satu tempat.</p>
        </div>
        <a href="{{ route('seller.products.create') }}" class="btn-primary hidden sm:inline-flex">
            <i data-lucide="plus" class="h-4 w-4"></i>Tambah produk
        </a>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="soft-card p-5"><span class="text-xs font-bold text-slate-400">Total produk</span><strong class="mt-3 block text-3xl">{{ $totalProducts }}</strong><span class="mt-2 block text-xs text-slate-400">Produk kamu</span></div>
        <div class="soft-card p-5"><span class="text-xs font-bold text-slate-400">Produk aktif</span><strong class="mt-3 block text-3xl text-violet-600">{{ $activeProducts }}</strong><span class="mt-2 block text-xs text-slate-400">Tampil di marketplace</span></div>
        <div class="soft-card p-5"><span class="text-xs font-bold text-slate-400">Produk draft</span><strong class="mt-3 block text-3xl">{{ $draftProducts }}</strong><span class="mt-2 block text-xs text-slate-400">Siap dipublikasikan</span></div>
    </div>

    <div class="mt-8 grid gap-5 lg:grid-cols-[1.3fr_.7fr]">
        <div class="soft-card p-5 sm:p-6">
            <div class="flex items-center justify-between">
                <div><h2 class="text-lg font-bold">Produk terbaru</h2><p class="mt-1 text-sm text-slate-500">Perbarui produk yang ingin ditampilkan.</p></div>
                <a href="{{ route('seller.products') }}" class="text-xs font-bold text-violet-600">Lihat semua</a>
            </div>
            <div class="mt-5 divide-y divide-slate-200/70">
                @forelse ($latestProducts as $product)
                    <div class="flex items-center gap-3 py-3 first:pt-0">
                        <img class="h-12 w-12 rounded-xl object-cover" src="{{ $product->image ? asset($product->image) : asset('image/divisi_bd.jpeg') }}" alt="{{ $product->name }}">
                        <div class="min-w-0 flex-1">
                            <strong class="block truncate text-sm">{{ $product->name }}</strong>
                            <span class="text-xs font-bold text-violet-600">ID: {{ $product->code }}</span>
                            <span class="mt-1 block text-xs text-slate-400">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <span class="chip {{ $product->status === 'active' ? 'chip-purple' : '' }}">{{ ucfirst($product->status ?? 'draft') }}</span>
                    </div>
                @empty
                    <p class="py-5 text-sm text-slate-500">Belum ada produk. Tambahkan produk pertamamu.</p>
                @endforelse
            </div>
        </div>

        <div class="soft-card p-5 sm:p-6">
            <span class="eyebrow">Toko kamu</span>
            <h2 class="mt-2 text-xl font-bold">{{ $storeNameLabel }}</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                {{ $storeDescriptionLabel }}
            </p>
            <a href="{{ route('seller.store') }}" class="btn-soft mt-6 w-full text-sm">Kelola toko <i data-lucide="arrow-right" class="h-4 w-4"></i></a>
        </div>
    </div>
@endsection
