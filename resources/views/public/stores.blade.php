@extends('layouts.public')

@section('title', $seoTitle ?? 'Toko Mahasiswa')

@section('content')
    <div class="page-shell pt-12 sm:pt-16">
        <div class="max-w-2xl">
            <span class="eyebrow">Mitra Setia Kami</span>
            <h1 class="mt-3 text-4xl font-bold">Toko Mahasiswa</h1>
            <p class="mt-3 text-slate-500">Temukan toko mahasiswa yang bergabung bersama Business Development HMPS MI.</p>
        </div>

        <form method="GET" action="{{ route('stores.index') }}" class="store-filter-form soft-card mt-8 p-3">
            <div class="catalog-filter-search soft-inset flex items-center gap-3 rounded-xl px-4">
                <i data-lucide="search" class="h-4 w-4 shrink-0 text-slate-400"></i>
                <input type="search" name="q" value="{{ $search }}"
                    class="w-full border-0 bg-transparent py-2 text-sm outline-none"
                    placeholder="Cari nama toko, kategori, deskripsi, atau pemilik...">
            </div>
            <button type="submit" class="catalog-filter-submit btn-soft">Cari</button>
        </form>

        <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($stores as $store)
                    <a href="{{ route('stores.show', $store->slug) }}" class="soft-card group overflow-hidden">
                        <img class="h-40 w-full object-cover transition duration-500 group-hover:scale-105"
                        src="{{ $store->cover_image ? asset($store->cover_image) : asset('image/divisi_bd.jpeg') }}"
                        alt="{{ $store->name }}">
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h2 class="text-xl font-bold">{{ $store->name }}</h2>
                                <p class="mt-1 text-xs font-semibold text-violet-600">
                                    {{ $store->category ?? 'Toko mahasiswa' }}</p>
                            </div>
                            <i data-lucide="arrow-up-right" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <p class="mt-4 text-sm leading-6 text-slate-500">
                            {{ $store->description ?? 'Belum ada deskripsi toko.' }}</p>
                        <div
                            class="mt-5 flex items-center justify-between border-t border-slate-200/70 pt-4 text-xs text-slate-500">
                            <span>Pemilik: {{ $store->owner?->name ?? 'Pemilik belum diatur' }}</span>
                            <strong>{{ number_format($store->products_count, 0, ',', '.') }} Produk</strong>
                        </div>
                    </div>
                </a>
            @empty
                <div class="soft-card col-span-full p-8 text-center text-sm text-slate-500">
                    Tidak ada toko yang cocok dengan pencarian tersebut.
                </div>
            @endforelse
        </div>
        @if ($stores->hasPages())
            <div class="mt-8">{{ $stores->links() }}</div>
        @endif
    </div>
@endsection
