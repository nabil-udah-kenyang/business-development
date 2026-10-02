@extends('layouts.dashboard')

@section('title', 'Toko Saya')

@section('content')
    <div><span class="eyebrow">Seller space</span><h1 class="mt-2 text-3xl font-bold">Toko saya</h1><p class="mt-2 text-sm text-slate-500">Kelola identitas toko yang tampil di katalog publik.</p></div>

    <form method="POST" action="{{ route('seller.store.update') }}" enctype="multipart/form-data" class="soft-card mt-8 max-w-5xl grid gap-6 p-5 sm:p-7">
        @csrf
        @method('PUT')
        <div class="grid gap-5 lg:grid-cols-[220px_minmax(0,1fr)]">
            <div class="rounded-2xl border border-slate-200/70 p-4">
                <p class="text-sm font-bold">Logo toko</p>
                <div id="store-logo-preview" class="mt-3 grid h-28 w-28 place-items-center overflow-hidden rounded-2xl bg-violet-600 text-2xl font-bold text-white">
                    @if ($store?->logo)
                        <img src="{{ asset($store->logo) }}" alt="{{ $store->name }}" class="h-full w-full object-contain">
                    @else
                        {{ $store ? strtoupper(substr($store->name, 0, 2)) : 'Toko' }}
                    @endif
                </div>
                <label class="btn-soft mt-4 w-full cursor-pointer text-xs"><i data-lucide="upload" class="h-4 w-4"></i>Pilih logo toko<input id="store-logo-input" name="logo" type="file" accept="image/png,image/jpeg,image/webp,image/svg+xml" class="hidden"></label>
                <p class="mt-2 text-[.68rem] text-slate-400">PNG, JPG, WEBP, SVG</p>
            </div>
            <div class="rounded-2xl border border-slate-200/70 p-4">
                <p class="text-sm font-bold">Foto sampul toko</p>
                <div class="mt-3 overflow-hidden rounded-2xl bg-slate-200">
                    <img id="store-cover-preview" src="{{ $store?->cover_image ? asset($store->cover_image) : asset('image/divisi_bd.jpeg') }}" alt="Preview sampul toko" class="aspect-[16/6] w-full object-cover">
                </div>
                <div class="mt-4 flex flex-wrap items-center gap-3"><label class="btn-soft w-fit cursor-pointer text-xs"><i data-lucide="image-up" class="h-4 w-4"></i>Pilih foto sampul<input id="store-cover-input" name="cover_image" type="file" accept="image/png,image/jpeg,image/webp" class="hidden"></label><p class="text-[.68rem] text-slate-400">Rasio 16:9 · JPG, PNG, WEBP</p></div>
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <label class="text-sm font-bold">Nama toko<input name="name" class="field mt-2" value="{{ old('name', $store?->name) }}" placeholder="Nama toko" required></label>
            <label class="text-sm font-bold">Kategori<select name="category" class="field mt-2"><option value="">Pilih kategori</option><option @selected(old('category', $store?->category) === 'Food & Beverage')>Food & Beverage</option><option @selected(old('category', $store?->category) === 'Fashion')>Fashion</option><option @selected(old('category', $store?->category) === 'Jasa')>Jasa</option></select></label>
            <label class="text-sm font-bold">Lokasi<input name="location" class="field mt-2" value="{{ old('location', $store?->location) }}" placeholder="Medan"></label>
            <label class="text-sm font-bold">WhatsApp<input name="whatsapp" class="field mt-2" value="{{ old('whatsapp', $store?->whatsapp) }}" placeholder="08xx-xxxx-xxxx"></label>
        </div>
        <label class="text-sm font-bold">Deskripsi<textarea name="description" class="field mt-2 min-h-28" placeholder="Ceritakan toko kamu...">{{ old('description', $store?->description) }}</textarea></label>
        <button type="submit" class="btn-primary w-fit">Simpan perubahan</button>
    </form>
@endsection

@push('scripts')
<script>
    const previewUpload = (inputId, previewId) => {
        const input = document.querySelector(`#${inputId}`);
        const preview = document.querySelector(`#${previewId}`);
        input?.addEventListener('change', (event) => {
            const [file] = event.target.files;
            if (!file || !file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.addEventListener('load', () => {
                if (preview.tagName === 'IMG') preview.src = reader.result;
                else preview.innerHTML = `<img src="${reader.result}" alt="Preview logo toko" class="h-full w-full object-contain">`;
            });
            reader.readAsDataURL(file);
        });
    };
    previewUpload('store-logo-input', 'store-logo-preview');
    previewUpload('store-cover-input', 'store-cover-preview');
</script>
@endpush
