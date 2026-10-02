@extends('layouts.public')

@section('title', $seoTitle ?? 'Detail Preloved')

@section('content')
    <div class="page-shell pt-10 sm:pt-14">
        <a href="{{ route('preloved.index') }}" class="flex items-center gap-2 text-sm font-bold text-slate-500">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>Kembali ke preloved
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
                <span class="chip bg-amber-100 text-amber-700">PRELOVED · {{ $conditionLabel }}</span>
                <h1 class="mt-4 text-3xl font-bold sm:text-4xl">{{ $product->name }}</h1>
                <p class="mt-3 text-2xl font-bold text-violet-700">{{ $priceLabel }}</p>

                <div class="mt-5 flex flex-wrap gap-2">
                    <span class="chip">{{ $categoryLabel }}</span>
                    <span class="chip"><i data-lucide="map-pin" class="h-3.5 w-3.5"></i>{{ $locationLabel }}</span>
                </div>

                <div class="soft-card mt-7 flex items-center gap-3 p-4">
                    <span class="grid h-11 w-11 place-items-center rounded-full bg-violet-100 font-bold text-violet-700">{{ $ownerInitial }}</span>
                    <div>
                        <strong class="block">{{ $ownerName }}</strong>
                        <span class="text-xs text-slate-500">Mahasiswa POLMED</span>
                    </div>
                </div>

                <div class="soft-card mt-5 p-5">
                    <span class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Informasi barang</span>
                    <div class="mt-4 grid gap-3 text-sm sm:grid-cols-3">
                        <div>
                            <span class="block text-xs text-slate-400">Kategori</span>
                            <strong class="mt-1 block">{{ $categoryLabel }}</strong>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-400">Tipe</span>
                            <strong class="mt-1 block">Preloved</strong>
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
                    <div class="mt-4 border-t border-slate-200/70 pt-4">
                        <span class="block text-xs text-slate-400">Kondisi</span>
                        <p class="mt-2 font-semibold">{{ $product->condition ?? 'Belum diatur' }}</p>
                    </div>
                    @if ($product->specifications)
                        <div class="mt-4 border-t border-slate-200/70 pt-4">
                            <span class="block text-xs text-slate-400">Spesifikasi</span>
                            <p class="mt-2 whitespace-pre-line leading-6 text-slate-600">{{ $product->specifications }}</p>
                        </div>
                    @endif
                </div>

                @if ($whatsappLink)
                    <a href="{{ $whatsappLink }}" target="_blank" rel="noreferrer" class="btn-primary mt-7 w-full">
                        <i data-lucide="message-circle" class="h-4 w-4"></i>Hubungi penjual via WhatsApp
                    </a>
                @else
                    <button data-demo-toast="Nomor WhatsApp pemilik preloved belum diatur." class="btn-primary mt-7 w-full">
                        <i data-lucide="message-circle" class="h-4 w-4"></i>Hubungi penjual via WhatsApp
                    </button>
                @endif

                <div class="soft-card mt-5 p-5 sm:p-6">
                    <div class="flex items-center gap-3">
                        <i data-lucide="shield-check" class="h-5 w-5 shrink-0 text-amber-500"></i>
                        <h2 class="text-lg font-bold">Transaksi aman di POLMED</h2>
                    </div>
                    <div class="mt-4 space-y-3 text-sm leading-6 text-slate-600">
                        <p>Gunakan WhatsApp dari halaman ini untuk berkomunikasi langsung dengan penjual.</p>
                        <p>Jika memungkinkan, pilih COD di area kampus yang ramai seperti kantin, lobi, atau area publik lainnya.</p>
                        <p>Periksa kondisi dan kelengkapan barang sebelum membayar.</p>
                        <p>Jika menemukan hal yang mencurigakan, hubungi Business Development HMPS MI.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
