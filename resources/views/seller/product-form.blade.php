@extends('layouts.dashboard')

@section('title', $editing ? 'Edit Produk' : 'Tambah Produk')

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('seller.products') }}" class="flex items-center gap-2 text-sm font-bold text-slate-500">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>Kembali ke produk
        </a>
        <div class="mt-6">
            <span class="eyebrow">Seller space</span>
            <h1 class="mt-2 text-3xl font-bold">{{ $editing ? 'Edit produk' : 'Tambah produk' }}</h1>
            <p class="mt-2 text-sm text-slate-500">Isi informasi yang akan tampil di katalog publik.</p>
        </div>

        <form method="POST" action="{{ $editing ? route('seller.products.update', $product->slug) : route('seller.products.store') }}" enctype="multipart/form-data" class="soft-card mt-8 grid gap-5 p-5 sm:p-7">
            @csrf
            @if ($editing) @method('PUT') @endif

            <label class="text-sm font-bold">Nama produk
                <input name="name" class="field mt-2" placeholder="Contoh: Kopi Susu Gula Aren" value="{{ old('name', $product->name) }}" required>
            </label>

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-200/70 bg-white/30 p-4 text-sm sm:col-span-2">
                    <span class="block font-bold">Toko</span>
                    @if ($store)
                        <span class="mt-2 block text-base font-bold text-violet-700">{{ $store->name }}</span>
                        <span class="mt-1 block text-xs text-slate-500">Produk ini otomatis terhubung ke toko aktif kamu.</span>
                    @else
                        <span class="mt-2 block text-sm font-semibold text-red-600">Belum ada toko aktif.</span>
                        <a href="{{ route('seller.store') }}" class="mt-2 inline-flex text-xs font-bold text-violet-600">Kelola toko terlebih dahulu →</a>
                    @endif
                </div>
                <label class="text-sm font-bold">Tipe
                    <select name="type" class="field mt-2">
                        <option value="product" @selected(old('type', $product->type) === 'product')>Produk</option>
                        <option value="service" @selected(old('type', $product->type) === 'service')>Jasa</option>
                    </select>
                </label>
                <label class="text-sm font-bold">Kategori
                    <select name="category" class="field mt-2" required>
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}" @selected(old('category', $product->category) === $category->name)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="text-sm font-bold">Harga
                    <input name="price" type="number" min="0" class="field mt-2" value="{{ old('price', $product->price ?? 0) }}" required>
                </label>
                <label class="text-sm font-bold">Lokasi
                    <input name="location" class="field mt-2" value="{{ old('location', $product->location) }}" placeholder="Medan">
                </label>
            </div>

            <label class="text-sm font-bold">Deskripsi
                <textarea name="description" class="field mt-2 min-h-28" placeholder="Ceritakan produk atau jasa kamu...">{{ old('description', $product->description) }}</textarea>
            </label>
            <label class="text-sm font-bold">Spesifikasi
                <textarea name="specifications" class="field mt-2 min-h-24" placeholder="Bahan, ukuran, jam layanan, dan informasi lainnya">{{ old('specifications', $product->specifications) }}</textarea>
            </label>
            <div>
                <div class="flex items-center justify-between gap-3">
                    <label class="text-sm font-bold">Foto produk</label>
                    <span class="text-xs font-medium text-slate-400">Maksimal 5 foto</span>
                </div>
                <div data-image-uploader class="product-image-grid mt-2">
                    @foreach ($imageSlots as $slot)
                        <div data-image-slot class="product-image-slot">
                            <label class="product-image-slot-label">
                                <input name="images[{{ $slot['index'] }}]" type="file" accept="image/png,image/jpeg,image/webp" class="product-image-input">
                                <span data-image-preview class="product-image-preview">
                                    @if ($slot['exists'])
                                        <img src="{{ $slot['url'] }}" data-existing-image="true" alt="Foto {{ $slot['index'] + 1 }}">
                                    @else
                                        <span data-image-placeholder class="product-image-placeholder"><span class="product-image-plus">+</span><span>Tambah foto</span></span>
                                    @endif
                                </span>
                            </label>
                            <button type="button" data-image-remove class="product-image-remove {{ $slot['exists'] ? '' : 'hidden' }}" aria-label="Hapus foto">
                                <i data-lucide="x" class="h-4 w-4"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
                <p class="mt-2 text-xs text-slate-400">Foto pertama menjadi foto utama. Kamu boleh mengunggah 1 sampai 5 foto.</p>
                @error('images') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                @error('images.*') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            @if ($errors->any())
                <div class="rounded-2xl bg-red-50 p-4 text-sm text-red-700">{{ $errors->first() }}</div>
            @endif

            <div class="product-draft-note rounded-2xl bg-violet-50 p-4 text-sm leading-6 text-violet-800">
                <strong class="product-draft-note-title">Status awal: Draft</strong>
                <p class="product-draft-note-description">Produk akan tampil setelah disetujui oleh Business Development HMPS MI.</p>
                <p class="product-draft-note-description mt-1">Biaya upload produk: <strong>Rp{{ number_format($umkmUploadFee, 0, ',', '.') }}</strong></p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button type="submit" class="btn-primary">{{ $editing ? 'Simpan perubahan' : 'Simpan sebagai draft' }}</button>
                <a href="{{ route('seller.products') }}" class="btn-soft">Batal</a>
            </div>
        </form>
    </div>
@endsection
