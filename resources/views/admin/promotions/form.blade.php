@extends('layouts.admin')
@section('title', $editing ? 'Edit Slot Rekomendasi' : 'Tambah Slot Rekomendasi')
@section('content')
<div><a href="{{ route('admin.promotions.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-violet-600"><i data-lucide="arrow-left" class="h-4 w-4"></i>Kembali ke slot rekomendasi</a><span class="eyebrow mt-8 block">{{ $editing ? 'Update placement' : 'New placement' }}</span><h1 class="mt-2 text-3xl font-bold">{{ $editing ? 'Edit slot rekomendasi' : 'Tambah slot rekomendasi' }}</h1><p class="mt-2 text-sm text-slate-500">Pilih produk berdasarkan ID unik. Data produk akan terisi otomatis dari katalog.</p></div>

<form method="POST" action="{{ $editing ? route('admin.promotions.update', $listing) : route('admin.promotions.store') }}" class="soft-card mt-8 grid gap-6 p-5 sm:p-7">@csrf @if($editing) @method('PUT') @endif
    <section>
        <div class="rounded-2xl bg-violet-50 p-4 text-sm leading-6 text-slate-600"><strong class="text-slate-800">Pilih produk yang ingin direkomendasikan.</strong><p>Admin tidak perlu mengisi nama, harga, seller, gambar, atau metadata lainnya secara manual. Cukup cari lalu pilih satu produk dari katalog.</p></div>
        <input type="hidden" id="catalog-type" name="catalog_type" value="{{ $selectedType }}">
        <input type="hidden" id="catalog-slug" name="catalog_slug" value="{{ $selectedSlug }}">
        @error('catalog_type')<span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span>@enderror
        @error('catalog_slug')<span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span>@enderror

        <div class="mt-5 grid gap-5 lg:grid-cols-[minmax(0,1fr)_340px]">
            <div>
                <label class="text-sm font-bold" for="catalog-search">Cari nama produk atau ID unik</label>
                <div class="soft-inset mt-2 flex items-center gap-3 rounded-xl px-4"><i data-lucide="search" class="h-4 w-4 shrink-0 text-slate-400"></i><input id="catalog-search" type="search" class="w-full border-0 bg-transparent py-3 text-sm outline-none" placeholder="Contoh: kopi susu atau kopi-susu" autocomplete="off"></div>
                <div id="catalog-options" class="mt-3 grid max-h-96 gap-2 overflow-y-auto pr-1 sm:grid-cols-2">
                    @foreach ($catalogOptions as $product)
                        <button type="button" data-catalog-option data-catalog-type="{{ $product['catalog_type'] }}" data-catalog-slug="{{ $product['catalog_slug'] }}" data-product-code="{{ $product['product_code'] }}" data-name="{{ $product['name'] }}" data-price="{{ $product['price'] }}" data-seller="{{ $product['seller'] }}" data-category="{{ $product['category'] }}" data-location="{{ $product['location'] }}" data-views="{{ $product['views'] }}" data-listing-type="{{ $product['listing_type'] }}" data-condition="{{ $product['condition'] ?? '' }}" data-image="{{ $product['image'] }}" data-search="{{ strtolower($product['product_code'].' '.$product['catalog_slug'].' '.$product['name'].' '.$product['seller'].' '.$product['category']) }}" class="flex items-center gap-3 rounded-2xl border border-transparent bg-[var(--surface)] p-3 text-left shadow-[5px_6px_12px_rgba(171,178,187,.18)] hover:border-white hover:bg-[var(--surface-deep)]">
                            <img src="{{ $product['image'] }}" alt="" class="h-12 w-12 shrink-0 rounded-xl object-cover">
                            <span class="min-w-0 flex-1"><strong class="block truncate text-sm">{{ $product['name'] }}</strong><span class="mt-1 block truncate text-xs text-slate-500">{{ $product['product_code'] }} · {{ $product['catalog_type'] === 'preloved' ? 'Preloved' : 'Produk Mahasiswa' }}</span></span>
                        </button>
                    @endforeach
                </div>
                <p id="catalog-empty" class="mt-4 hidden text-center text-sm text-slate-500">Produk tidak ditemukan.</p>
            </div>

            <div>
                <p class="text-sm font-bold">Produk terpilih</p>
                <div id="selected-product-card" class="{{ $selectedProduct ? '' : 'hidden' }} soft-inset mt-2 rounded-2xl p-4">
                    <img id="selected-product-image" src="{{ $selectedProduct['image'] ?? '' }}" alt="" class="aspect-[1.35] w-full rounded-xl object-cover">
                    <div class="mt-4 flex items-start justify-between gap-3"><div><strong id="selected-product-name" class="block">{{ $selectedProduct['name'] ?? 'Belum ada produk' }}</strong><span id="selected-product-id" class="mt-1 block text-xs font-bold text-slate-500">{{ $selectedProduct['product_code'] ?? 'Pilih dari daftar katalog' }}</span></div><span id="selected-product-type" class="chip chip-purple">{{ $selectedProduct ? ($selectedProduct['catalog_type'] === 'preloved' ? 'Preloved' : 'Produk Mahasiswa') : 'Belum dipilih' }}</span></div>
                    <p id="selected-product-meta" class="mt-3 text-sm leading-6 text-slate-500">{{ $selectedProduct ? $selectedProduct['seller'].' · '.$selectedProduct['price'].' · '.$selectedProduct['category'] : 'Data produk akan tampil otomatis setelah dipilih.' }}</p>
                </div>
            </div>
        </div>
    </section>

    <div class="border-t border-slate-200/70"></div>

    <div class="grid gap-5 sm:grid-cols-2"><label class="text-sm font-bold">Biaya iklan (Rp)<input name="fee" type="number" min="0" class="field mt-2" value="{{ old('fee', $listing->fee ?: 5000) }}" required></label><label class="flex items-center gap-3 pt-7 text-sm font-bold"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded" @checked(old('is_active', $listing->exists ? $listing->is_active : true))> Aktif ditampilkan</label></div>
    <div class="rounded-2xl bg-slate-100/70 p-4 text-sm leading-6 text-slate-500"><strong class="text-slate-700">Penayangan manual</strong><p>Gunakan checkbox Aktif ditampilkan untuk mengatur kapan rekomendasi muncul. Pengaturan mulai dan berakhir tayang tidak digunakan.</p></div>
    <div class="flex flex-wrap items-center gap-3 border-t border-slate-200/70 pt-5"><button class="btn-primary" type="submit">{{ $editing ? 'Simpan perubahan' : 'Tambah slot' }} <i data-lucide="arrow-right" class="h-4 w-4"></i></button><a href="{{ route('admin.promotions.index') }}" class="btn-soft">Batal</a></div>
</form>
@endsection

@push('scripts')
<script>
    const catalogOptions = [...document.querySelectorAll('[data-catalog-option]')];
    const catalogSearch = document.querySelector('#catalog-search');
    const catalogEmpty = document.querySelector('#catalog-empty');
    const catalogType = document.querySelector('#catalog-type');
    const catalogSlug = document.querySelector('#catalog-slug');
    const selectedCard = document.querySelector('#selected-product-card');
    const selectedImage = document.querySelector('#selected-product-image');
    const selectedName = document.querySelector('#selected-product-name');
    const selectedId = document.querySelector('#selected-product-id');
    const selectedType = document.querySelector('#selected-product-type');
    const selectedMeta = document.querySelector('#selected-product-meta');

    const chooseCatalogProduct = (option) => {
        catalogType.value = option.dataset.catalogType;
        catalogSlug.value = option.dataset.catalogSlug;
        selectedImage.src = option.dataset.image;
        selectedName.textContent = option.dataset.name;
        selectedId.textContent = `${option.dataset.productCode} · ${option.dataset.catalogSlug}`;
        selectedType.textContent = option.dataset.catalogType === 'preloved' ? 'Preloved' : 'Produk Mahasiswa';
        selectedMeta.textContent = `${option.dataset.seller} · ${option.dataset.price} · ${option.dataset.category}`;
        selectedCard.classList.remove('hidden');
        catalogOptions.forEach((item) => item.classList.toggle('ring-2', item === option));
        catalogOptions.forEach((item) => item.classList.toggle('ring-violet-500', item === option));
    };

    catalogOptions.forEach((option) => option.addEventListener('click', () => chooseCatalogProduct(option)));
    catalogSearch?.addEventListener('input', () => {
        const query = catalogSearch.value.trim().toLowerCase();
        let visibleCount = 0;
        catalogOptions.forEach((option) => {
            const visible = option.dataset.search.includes(query);
            option.classList.toggle('hidden', !visible);
            if (visible) visibleCount += 1;
        });
        catalogEmpty.classList.toggle('hidden', visibleCount !== 0);
    });

    const initialProduct = catalogOptions.find((option) => option.dataset.catalogType === catalogType.value && option.dataset.catalogSlug === catalogSlug.value);
    if (initialProduct) chooseCatalogProduct(initialProduct);
</script>
@endpush
