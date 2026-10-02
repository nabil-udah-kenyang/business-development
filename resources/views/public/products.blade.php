@extends('layouts.public')

@section('title', $seoTitle ?? 'Produk UMKM Mahasiswa')

@section('content')
    <div class="page-shell pt-12 sm:pt-16">
        <div class="max-w-2xl">
            <span class="eyebrow">Marketplace mahasiswa</span>
            <h1 class="mt-3 text-4xl font-bold">Produk Katalog Mahasiswa</h1>
            <p class="mt-3 text-slate-500">Temukan produk dan jasa yang ditawarkan oleh mahasiswa POLMED.</p>
        </div>

        <form method="GET" class="catalog-filter-form catalog-filter-products soft-card mt-8 p-3">
            <div class="catalog-filter-search soft-inset flex items-center gap-3 rounded-xl px-4">
                <i data-lucide="search" class="h-4 w-4 shrink-0 text-slate-400"></i>
                <input name="q" value="{{ $search }}"
                    class="w-full border-0 bg-transparent py-2 text-sm outline-none"
                    placeholder="Cari produk, jasa, atau toko...">
            </div>
            <select name="category" class="field">
                <option value="">Semua kategori</option>
                @foreach ($categories as $catalogCategory)
                    <option value="{{ $catalogCategory->name }}" @selected($category === $catalogCategory->name)>{{ $catalogCategory->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="catalog-filter-submit btn-soft">Terapkan</button>
        </form>

        @if ($recommendedProducts->isNotEmpty())
            <section class="recommendation-section mt-9">
                <div class="recommendation-heading">
                    <div>
                        <span class="eyebrow">Rekomendasi BD</span>
                        <h2 class="mt-2 text-2xl font-bold">Produk yang sedang disorot</h2>

                    </div>

                </div>
                <div class="mt-6 grid grid-cols-2 gap-3 lg:grid-cols-4 lg:gap-4">
                    @foreach ($recommendedProducts as $promoted)
                        <div>@include('partials.product-card', ['product' => $promoted, 'preloved' => false, 'promoted' => true])</div>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="{{ $recommendedProducts->isNotEmpty() ? 'mt-14' : 'mt-9' }}">
            <div class="flex items-end justify-between gap-3">
                <div>
                    <span class="eyebrow">Semua katalog</span>
                    <h2 class="mt-2 text-2xl font-bold">Produk mahasiswa</h2>
                </div>
                <span class="text-xs font-semibold text-slate-400">{{ $products->total() }} item</span>
            </div>
            <div class="mt-6 grid grid-cols-2 gap-3 lg:grid-cols-4 lg:gap-4">
                @foreach ($products as $product)
                    @include('partials.product-card', ['preloved' => false, 'promoted' => false])
                @endforeach
            </div>
            @if ($products->hasPages())
                <div class="mt-8">{{ $products->links() }}</div>
            @endif
        </section>
    </div>
@endsection
