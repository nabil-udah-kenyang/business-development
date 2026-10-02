@extends('layouts.public')

@section('title', $seoTitle ?? 'Detail Toko')

@section('content')
    <div class="page-shell pt-10 sm:pt-14">
        <a href="{{ route('stores.index') }}" class="flex items-center gap-2 text-sm font-bold text-slate-500">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>Kembali ke toko
        </a>

        <div class="soft-card mt-7 overflow-hidden">
            <img class="h-40 w-full object-cover sm:h-56" src="{{ $storeCoverUrl }}" alt="Cover {{ $store->name }}">
            <div class="p-5 sm:p-8">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div class="flex items-end gap-4">
                        @if ($storeLogo)
                            <img src="{{ $storeLogo }}" alt="Logo {{ $store->name }}" class="h-16 w-16 rounded-2xl object-cover">
                        @else
                            <span class="grid h-16 w-16 place-items-center rounded-2xl bg-violet-600 text-xl font-bold text-white">
                                {{ $storeInitials }}
                            </span>
                        @endif
                        <div>
                            <h1 class="text-3xl font-bold">{{ $store->name }}</h1>
                            <p class="mt-1 text-sm text-slate-500">Pemilik: {{ $ownerName }} · {{ $categoryLabel }} · {{ $locationLabel }}</p>
                        </div>
                    </div>
                    @if ($whatsappLink)
                        <a href="{{ $whatsappLink }}" target="_blank" rel="noreferrer" class="btn-primary">
                            <i data-lucide="message-circle" class="h-4 w-4"></i>Hubungi toko
                        </a>
                    @else
                        <button data-demo-toast="Nomor WhatsApp toko belum diatur." class="btn-primary">
                            <i data-lucide="message-circle" class="h-4 w-4"></i>Hubungi toko
                        </button>
                    @endif
                </div>
                <p class="mt-6 max-w-2xl leading-7 text-slate-500">{{ $storeDescription }}</p>
            </div>
        </div>

        <div class="mt-12 flex items-end justify-between">
            <div>
                <span class="eyebrow">Etalase toko</span>
                <h2 class="mt-2 text-2xl font-bold">Produk dari toko ini</h2>
            </div>
            <span class="text-sm text-slate-400">{{ $productCountLabel }} Produk</span>
        </div>

        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($products as $product)
                @include('partials.product-card', ['preloved' => false, 'promoted' => false])
            @empty
                <p class="text-sm text-slate-500">Belum ada produk yang ditampilkan dari toko ini.</p>
            @endforelse
        </div>
        @if ($products->hasPages())
            <div class="mt-8">{{ $products->links() }}</div>
        @endif
    </div>
@endsection
