@extends('layouts.dashboard')

@section('title', 'Dashboard Preloved')

@section('content')
    <div class="flex items-start justify-between gap-4">
        <div>
            <span class="eyebrow">Preloved space</span>
            <h1 class="mt-2 text-3xl font-bold">Halo, {{ $user?->name ?? 'Preloved user' }}</h1>
            <p class="mt-2 text-sm text-slate-500">Kelola barang pribadi yang ingin kamu jual.</p>
        </div>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="soft-card p-5"><span class="text-xs font-bold text-slate-400">Total barang</span><strong
                class="mt-3 block text-3xl">{{ $totalProducts }}</strong></div>
        <div class="soft-card p-5"><span class="text-xs font-bold text-slate-400">Aktif</span><strong
                class="mt-3 block text-3xl text-violet-600">{{ $activeProducts }}</strong></div>
        <div class="soft-card p-5"><span class="text-xs font-bold text-slate-400">Draft</span><strong
                class="mt-3 block text-3xl">{{ $draftProducts }}</strong></div>
    </div>

    <div class="soft-card mt-8 p-5 sm:p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold">Barang saya</h2>
            <a href="{{ route('preloved-user.products') }}" class="text-xs font-bold text-violet-600">Lihat semua</a>
        </div>
        <div class="mt-4 divide-y divide-slate-200/70">
            @forelse ($latestProducts as $product)
                <div class="flex items-center gap-3 py-3">
                    <img class="h-12 w-12 rounded-xl object-cover"
                        src="{{ $product->image ? asset($product->image) : asset('image/divisi_bd.jpeg') }}"
                        alt="{{ $product->name }}">
                    <div class="flex-1">
                        <strong class="block text-sm">{{ $product->name }}</strong>
                        <span class="text-xs font-bold text-violet-600">ID: {{ $product->code }}</span>
                        <span
                            class="mt-1 block text-xs text-slate-400">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <span
                        class="chip {{ $product->status === 'active' ? 'chip-purple' : '' }}">{{ ucfirst($product->status ?? 'draft') }}</span>
                </div>
            @empty
                <p class="py-5 text-sm text-slate-500">Belum ada barang preloved.</p>
            @endforelse
        </div>
    </div>
@endsection
