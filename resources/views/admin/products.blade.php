@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
    <div>
        <span class="eyebrow">Catalog control</span>
        <h1 class="mt-2 text-3xl font-bold">Kelola produk mahasiswa</h1>
        <p class="mt-2 text-sm text-slate-500">Aktifkan, sembunyikan, atau tinjau produk dan jasa mahasiswa.</p>
    </div>

    <div class="soft-card mt-8 overflow-x-auto">
        <form method="GET" action="{{ route('admin.products') }}" class="flex min-w-[680px] items-center gap-3 border-b border-slate-200/70 p-4">
            <div class="soft-inset flex min-w-0 flex-1 items-center gap-2 rounded-xl px-3">
                <i data-lucide="search" class="h-4 w-4 shrink-0 text-slate-400"></i>
                <input type="search" name="q" value="{{ $search }}" class="w-full min-w-0 border-0 bg-transparent py-2 text-sm outline-none" placeholder="Cari produk atau pemilik...">
            </div>
            <select name="status" class="field !w-36 shrink-0">
                <option value="">Semua status</option>
                <option value="active" @selected($status === 'active')>Aktif</option>
                <option value="draft" @selected($status === 'draft')>Draft</option>
            </select>
            <button type="submit" class="btn-soft">Filter</button>
        </form>

        <table class="admin-table min-w-[680px] w-full">
            <thead>
                <tr><th>Produk</th><th>Pemilik</th><th>Tipe</th><th>Harga</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            <span class="mt-1 block text-xs text-violet-600">ID: {{ $product->code }}</span>
                            <span class="mt-1 block text-xs text-slate-400">{{ $product->category ?? 'Lainnya' }}</span>
                        </td>
                        <td>{{ $product->owner?->name ?? 'Pemilik belum diatur' }}</td>
                        <td>{{ $product->type === 'service' ? 'Jasa' : 'Produk' }}</td>
                        <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td><span class="chip {{ $product->status === 'active' ? 'chip-purple' : '' }}">{{ ucfirst($product->status ?? 'draft') }}</span></td>
                        <td>
                            <form method="POST" action="{{ route('admin.products.update', $product) }}">
                                @csrf @method('PATCH')
                                <select name="status" class="field !w-28 !px-2 !py-1 text-xs" onchange="this.form.submit()">
                                    <option value="active" @selected($product->status === 'active')>Aktif</option>
                                    <option value="draft" @selected($product->status === 'draft')>Draft</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-8 text-center text-sm text-slate-500">Belum ada produk terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($products->hasPages())
        <div class="mt-6">{{ $products->links() }}</div>
    @endif
@endsection
