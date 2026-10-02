@extends('layouts.admin')

@section('title', 'Kelola Toko')

@section('content')
    <div>
        <span class="eyebrow">Directory control</span>
        <h1 class="mt-2 text-3xl font-bold">Kelola toko</h1>
        <p class="mt-2 text-sm text-slate-500">Tinjau profil toko yang bergabung dalam platform.</p>
    </div>

    <div class="mt-8 grid gap-4 lg:grid-cols-2">
        @forelse ($stores as $store)
            <div class="soft-card flex items-center gap-4 p-5">
                @if ($store->logo)
                    <img src="{{ asset($store->logo) }}" alt="{{ $store->name }}" class="h-14 w-14 rounded-2xl object-cover">
                @else
                    <span class="grid h-14 w-14 place-items-center rounded-2xl bg-violet-600 font-bold text-white">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
                @endif
                <div class="flex-1">
                    <h2 class="font-bold">{{ $store->name }}</h2>
                    <p class="mt-1 text-xs text-slate-500">{{ $store->owner?->name ?? 'Pemilik belum diatur' }} · {{ $store->category ?? 'Toko mahasiswa' }} · {{ number_format($store->products_count, 0, ',', '.') }} produk</p>
                </div>
                <a href="{{ route('stores.show', $store->slug) }}" class="btn-soft !p-2" aria-label="Lihat detail {{ $store->name }}">
                    <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                </a>
            </div>
        @empty
            <p class="text-sm text-slate-500">Belum ada toko terdaftar.</p>
        @endforelse
    </div>
    @if ($stores->hasPages())
        <div class="mt-6">{{ $stores->links() }}</div>
    @endif
@endsection
