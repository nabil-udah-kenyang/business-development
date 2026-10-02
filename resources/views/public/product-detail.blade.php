@extends('layouts.public')

@section('title', $seoTitle ?? 'Detail Produk')

@section('content')
    <div class="page-shell pt-10 sm:pt-14">
        <a href="{{ route('products.index') }}" class="flex items-center gap-2 text-sm font-bold text-slate-500">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>Kembali ke produk
        </a>

        <div class="mt-7 grid gap-8 lg:grid-cols-[1.05fr_.95fr]">
            <div data-product-gallery class="product-gallery soft-card p-3 sm:p-5">
                <div data-gallery-viewport class="gallery-viewport relative overflow-hidden rounded-[1.35rem]">
                    <div class="gallery-image-stage">
                        <img data-main-product-image class="gallery-main-image" src="{{ $productImageUrl }}" alt="{{ $product->name }}">
                    </div>
                    @if (count($gallery) > 1)
                        <button type="button" data-gallery-prev class="gallery-control gallery-control-prev" aria-label="Foto sebelumnya">
                            <i data-lucide="chevron-left" class="h-5 w-5"></i>
                        </button>
                        <button type="button" data-gallery-next class="gallery-control gallery-control-next" aria-label="Foto berikutnya">
                            <i data-lucide="chevron-right" class="h-5 w-5"></i>
                        </button>
                        <span data-gallery-counter class="gallery-counter">1/{{ count($gallery) }}</span>
                    @endif
                </div>
                <div class="gallery-thumbnails mt-4 flex gap-2 overflow-x-auto pb-1">
                    @foreach ($gallery as $image)
                        <button type="button" data-gallery-image="{{ $image['url'] }}" data-gallery-index="{{ $image['index'] }}" class="gallery-thumbnail {{ $image['index'] === 0 ? 'is-active' : '' }}" aria-label="Lihat foto {{ $image['index'] + 1 }}">
                            <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}">
                        </button>
                    @endforeach
                </div>
            </div>

            <div>
                <span class="chip chip-purple">Produk Mahasiswa</span>
                <h1 class="mt-4 text-3xl font-bold sm:text-4xl">{{ $product->name }}</h1>
                <p class="mt-3 text-2xl font-bold text-violet-700">{{ $priceLabel }}</p>

                <div class="mt-5 flex flex-wrap gap-2 text-sm text-slate-500">
                    <span class="chip">{{ $categoryLabel }}</span>
                    <span class="chip"><i data-lucide="map-pin" class="h-3.5 w-3.5"></i>{{ $locationLabel }}</span>
                </div>

                <div class="soft-card mt-7 flex items-center justify-between p-4">
                    <div class="flex items-center gap-3">
                        @if ($storeLogo)
                            <img src="{{ $storeLogo }}" alt="Logo {{ $sellerName }}" class="h-11 w-11 rounded-full object-cover">
                        @else
                            <span class="grid h-11 w-11 place-items-center rounded-full bg-violet-100 font-bold text-violet-700">{{ $sellerInitials }}</span>
                        @endif
                        <div>
                            <strong class="block">{{ $sellerName }}</strong>
                            <span class="text-xs text-slate-500">Pemilik: {{ $storeOwnerName }}</span>
                        </div>
                    </div>
                    @if ($store)
                        <a href="{{ route('stores.show', $store->slug) }}" class="text-xs font-bold text-violet-600">Lihat toko</a>
                    @endif
                </div>

                <div class="soft-card mt-4 p-5">
                    <span class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Informasi produk</span>
                    <div class="mt-4 grid gap-3 text-sm sm:grid-cols-3">
                        <div>
                            <span class="block text-xs text-slate-400">Kategori</span>
                            <strong class="mt-1 block">{{ $categoryLabel }}</strong>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-400">Tipe</span>
                            <strong class="mt-1 block">{{ $typeLabel }}</strong>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-400">Lokasi</span>
                            <strong class="mt-1 block">{{ $locationLabel }}</strong>
                        </div>
                    </div>
                    <div class="mt-5 border-t border-slate-200/70 pt-4">
                        <span class="block text-xs text-slate-400">Deskripsi</span>
                        <p class="mt-2 leading-6 text-slate-600">{{ $descriptionLabel }}</p>
                    </div>
                    @if ($product->specifications)
                        <div class="mt-4 border-t border-slate-200/70 pt-4">
                            <span class="block text-xs text-slate-400">Spesifikasi</span>
                            <p class="mt-2 whitespace-pre-line leading-6 text-slate-600">{{ $product->specifications }}</p>
                        </div>
                    @endif
                </div>

                @if ($whatsappLink)
                    <a href="{{ $whatsappLink }}" target="_blank" rel="noreferrer" class="btn-primary mt-7 w-full sm:w-auto">
                        <i data-lucide="message-circle" class="h-4 w-4"></i>Hubungi via WhatsApp
                    </a>
                @else
                    <button data-demo-toast="Nomor WhatsApp penjual belum diatur." class="btn-primary mt-7 w-full sm:w-auto">
                        <i data-lucide="message-circle" class="h-4 w-4"></i>Hubungi via WhatsApp
                    </button>
                @endif
            </div>
        </div>

        <section class="mt-14">
            <h2 class="text-xl font-bold sm:text-2xl">Produk lain dari {{ $sellerName }}</h2>
            <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-4">
                @forelse ($relatedProducts as $product)
                    @include('partials.product-card', ['preloved' => false, 'promoted' => false])
                @empty
                    <p class="text-sm text-slate-500">Belum ada produk lain dari toko ini.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
