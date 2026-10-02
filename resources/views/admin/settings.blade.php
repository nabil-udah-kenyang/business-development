@extends('layouts.admin')
@section('title', 'Pengaturan')
@section('content')
<div>
    <span class="eyebrow">Platform settings</span>
    <h1 class="mt-2 text-3xl font-bold">Pengaturan platform</h1>
    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Kelola identitas, kontak, media sosial, dan biaya yang tampil sebagai referensi di platform publik.</p>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="soft-card mt-8 max-w-5xl grid gap-8 p-5 sm:p-7">
    @csrf
    @method('PUT')
    <section>
        <div class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-2xl bg-violet-100 text-violet-700"><i data-lucide="panels-top-left" class="h-5 w-5"></i></span>
            <div>
                <h2 class="text-lg font-bold">Identitas platform</h2>
                <p class="mt-1 text-sm text-slate-500">Informasi ini digunakan pada header dan footer halaman publik.</p>
            </div>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,1fr)_260px]">
            <div class="grid gap-5 sm:grid-cols-2">
                <label class="text-sm font-bold">Nama platform
                    <input name="platform_name" class="field mt-2" value="{{ old('platform_name', $settings->platform_name ?? 'Business Development HMPS MI') }}">
                </label>
                <label class="text-sm font-bold">Nama singkat
                    <input name="platform_short_name" class="field mt-2" value="{{ old('platform_short_name', $settings->platform_short_name ?? 'HMPS MI') }}">
                </label>
                <label class="text-sm font-bold sm:col-span-2">Deskripsi singkat
                    <textarea name="platform_description" class="field mt-2 min-h-24">{{ old('platform_description', $settings->platform_description ?? 'Ruang tumbuh untuk karya, produk, dan usaha mahasiswa POLMED.') }}</textarea>
                </label>
            </div>

            <div class="rounded-2xl border border-dashed border-slate-300/80 p-4">
                <div class="flex items-center gap-3">
                    <div id="platform-logo-preview" class="grid h-16 w-16 shrink-0 place-items-center overflow-hidden rounded-2xl bg-violet-600 text-xl font-bold text-white shadow-lg shadow-violet-200">
                        @if (!empty($platformLogoUrl))
                            <img src="{{ $platformLogoUrl }}" alt="Logo platform" class="h-full w-full object-contain">
                        @else
                            BD
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-bold">Logo platform</p>
                        <p class="mt-1 text-xs leading-5 text-slate-500">Tampil di header dan footer publik.</p>
                    </div>
                </div>
                <label class="btn-soft mt-4 w-full cursor-pointer text-sm">
                    <i data-lucide="upload" class="h-4 w-4"></i>
                    Pilih logo
                    <input id="platform-logo-input" name="platform_logo" type="file" accept="image/png,image/jpeg,image/webp,image/svg+xml" class="hidden">
                </label>
                <p class="mt-2 text-center text-[.68rem] text-slate-400">PNG, JPG, WEBP, atau SVG · maks. 2 MB</p>
            </div>
        </div>
    </section>

    <div class="border-t border-slate-200/70"></div>

    <section>
        <div class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-2xl bg-violet-100 text-violet-700"><i data-lucide="image" class="h-5 w-5"></i></span>
            <div>
                <h2 class="text-lg font-bold">Foto tim di beranda</h2>
                <p class="mt-1 text-sm text-slate-500">Ganti foto anggota Business Development yang tampil di bagian “Orang-orang di balik BD”.</p>
            </div>
        </div>

        <div class="mt-6 grid gap-5 lg:grid-cols-[minmax(0,1fr)_260px] lg:items-start">
            <div class="overflow-hidden rounded-2xl border border-slate-200/70 bg-slate-100">
                <img id="team-photo-preview" src="{{ $teamPhotoUrl ?? asset('image/divisi_bd.jpeg') }}" alt="Preview foto tim Business Development" class="aspect-video w-full object-cover">
            </div>
            <div>
                <label class="btn-soft w-full cursor-pointer text-sm">
                    <i data-lucide="image-up" class="h-4 w-4"></i>
                    Pilih foto tim
                    <input id="team-photo-input" name="team_photo" type="file" accept="image/png,image/jpeg,image/webp" class="hidden">
                </label>
                <p class="mt-2 text-center text-[.68rem] leading-5 text-slate-400">JPG, PNG, atau WEBP · maks. 5 MB · rekomendasi rasio 16:9</p>
            </div>
        </div>
    </section>

    <div class="border-t border-slate-200/70"></div>

    <section>
        <div class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-2xl bg-violet-100 text-violet-700"><i data-lucide="share-2" class="h-5 w-5"></i></span>
            <div>
                <h2 class="text-lg font-bold">Media sosial</h2>
                <p class="mt-1 text-sm text-slate-500">Tambahkan link yang ingin ditampilkan pada halaman publik.</p>
            </div>
        </div>

        <div class="mt-6 grid gap-5 sm:grid-cols-2">
            <label class="text-sm font-bold"><span class="flex items-center gap-2"><i data-lucide="instagram" class="h-4 w-4 text-slate-500"></i>Instagram</span>
                <input name="social_instagram" type="url" class="field mt-2" value="{{ old('social_instagram', $settings->social_instagram) }}" placeholder="https://instagram.com/username">
            </label>
            <label class="text-sm font-bold"><span class="flex items-center gap-2"><i data-lucide="music-2" class="h-4 w-4 text-slate-500"></i>TikTok</span>
                <input name="social_tiktok" type="url" class="field mt-2" value="{{ old('social_tiktok', $settings->social_tiktok) }}" placeholder="https://tiktok.com/@username">
            </label>
            <label class="text-sm font-bold"><span class="flex items-center gap-2"><i data-lucide="facebook" class="h-4 w-4 text-slate-500"></i>Facebook</span>
                <input name="social_facebook" type="url" class="field mt-2" value="{{ old('social_facebook', $settings->social_facebook) }}" placeholder="https://facebook.com/halaman">
            </label>
            <label class="text-sm font-bold"><span class="flex items-center gap-2"><i data-lucide="youtube" class="h-4 w-4 text-slate-500"></i>YouTube</span>
                <input name="social_youtube" type="url" class="field mt-2" value="{{ old('social_youtube', $settings->social_youtube) }}" placeholder="https://youtube.com/@channel">
            </label>
        </div>
    </section>

    <div class="border-t border-slate-200/70"></div>

    <section>
        <div class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-2xl bg-violet-100 text-violet-700"><i data-lucide="contact" class="h-5 w-5"></i></span>
            <div>
                <h2 class="text-lg font-bold">Kontak dan biaya</h2>
                <p class="mt-1 text-sm text-slate-500">Kontak yang dapat dihubungi mahasiswa dan biaya publikasi saat ini.</p>
            </div>
        </div>

        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <label class="text-sm font-bold">WhatsApp Business Development
                <input name="contact_whatsapp" class="field mt-2" value="{{ old('contact_whatsapp', $settings->contact_whatsapp) }}" placeholder="08xx-xxxx-xxxx">
            </label>
            <label class="text-sm font-bold">Email platform
                <input name="contact_email" type="email" class="field mt-2" value="{{ old('contact_email', $settings->contact_email) }}" placeholder="nama@domain.ac.id">
            </label>
            <label class="text-sm font-bold">Biaya upload UMKM
                <input name="umkm_upload_fee" type="number" min="0" class="field mt-2" value="{{ old('umkm_upload_fee', $settings->umkm_upload_fee ?? 10000) }}">
            </label>
            <label class="text-sm font-bold">Biaya upload preloved
                <input name="preloved_upload_fee" type="number" min="0" class="field mt-2" value="{{ old('preloved_upload_fee', $settings->preloved_upload_fee ?? 5000) }}">
            </label>
            <label class="text-sm font-bold">Biaya slot rekomendasi
                <input name="promotion_fee" type="number" min="0" class="field mt-2" value="{{ old('promotion_fee', $settings->promotion_fee ?? 5000) }}">
            </label>
        </div>
    </section>

    <div class="flex flex-wrap items-center gap-3 border-t border-slate-200/70 pt-6">
        <button type="submit" class="btn-primary">Simpan pengaturan</button>
        <span class="text-xs text-slate-400">Perubahan akan diterapkan pada tampilan publik setelah disimpan.</span>
    </div>
</form>
@endsection

@push('scripts')
<script>
    const logoInput = document.querySelector('#platform-logo-input');
    const logoPreview = document.querySelector('#platform-logo-preview');
    const teamPhotoInput = document.querySelector('#team-photo-input');
    const teamPhotoPreview = document.querySelector('#team-photo-preview');

    logoInput?.addEventListener('change', (event) => {
        const [file] = event.target.files;
        if (!file || !file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.addEventListener('load', () => {
            logoPreview.innerHTML = `<img src="${reader.result}" alt="Preview logo platform" class="h-full w-full object-contain">`;
        });
        reader.readAsDataURL(file);
    });

    teamPhotoInput?.addEventListener('change', (event) => {
        const [file] = event.target.files;
        if (!file || !file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.addEventListener('load', () => {
            teamPhotoPreview.src = reader.result;
        });
        reader.readAsDataURL(file);
    });
</script>
@endpush
