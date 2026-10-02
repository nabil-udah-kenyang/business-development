@extends('layouts.public')
@section('title', $seoTitle ?? 'Business Development HMPS MI · Ruang Tumbuh Mahasiswa')
@section('content')
    <div class="page-shell">
        <section
            class="grid items-center gap-10 border-b border-slate-300/70 pb-16 pt-12 sm:pt-20 lg:grid-cols-[1.02fr_.98fr] lg:pb-24">
            <div>
                <span class="eyebrow">Business Development · HMPS MI</span>
                <h1 class="display mt-4 max-w-2xl text-4xl font-bold leading-[1.07] tracking-tight sm:text-6xl">Wadah
                    mahasiswa untuk <span class="hero-accent">berkembang</span> dan berkarya.</h1>
                <p class="mt-6 max-w-xl text-base leading-7 text-slate-500 sm:text-lg">Business Development hadir sebagai
                    divisi yang menghubungkan ide, potensi, dan karya mahasiswa POLMED agar bisa dikenal, didukung, dan
                    tumbuh bersama.</p>
                <div class="mt-8 flex flex-wrap gap-3"><a href="#tentang-bd" class="btn-primary">Kenali divisi BD <i
                            data-lucide="arrow-down" class="h-4 w-4"></i></a><a href="#peran-bd" class="btn-soft">Cara kerja
                        kami</a></div>
                <div class="mt-9 flex flex-wrap gap-x-6 gap-y-3 text-xs font-semibold text-slate-500"><span
                        class="flex items-center gap-2"><i data-lucide="badge-check"
                            class="h-4 w-4 text-violet-600"></i>Ruang tumbuh mahasiswa</span><span
                        class="flex items-center gap-2"><i data-lucide="users-round"
                            class="h-4 w-4 text-violet-600"></i>Berbasis komunitas POLMED</span></div>
            </div>
            <div
                class="relative flex min-h-[340px] -translate-y-8 items-center justify-center sm:min-h-[430px] sm:-translate-y-12">
                <div
                    class="absolute right-4 top-8 h-48 w-48 rounded-full bg-violet-200/45 blur-3xl sm:right-10 sm:top-12 sm:h-64 sm:w-64">
                </div>
                <div class="absolute bottom-10 left-4 h-24 w-24 rounded-full bg-sky-200/50 blur-2xl sm:left-8"></div>
                <div id="bd-growth-animation" class="relative z-10 h-[320px] w-full max-w-[560px]"
                    aria-label="Animasi dashboard pertumbuhan bisnis Business Development">
                    <div id="bd-growth-fallback" class="absolute inset-0 grid place-items-center" aria-hidden="true"><svg
                            class="h-full w-full overflow-visible" viewBox="0 0 640 520" role="img">
                            <defs>
                                <linearGradient id="bd-orb" x1="0" x2="1" y1="0" y2="1">
                                    <stop offset="0" stop-color="#f6f8fa"></stop>
                                    <stop offset="1" stop-color="#dce6eb"></stop>
                                </linearGradient>
                                <filter id="bd-shadow" x="-30%" y="-30%" width="160%" height="160%">
                                    <feDropShadow dx="8" dy="10" stdDeviation="8" flood-color="#aeb2c1"
                                        flood-opacity=".22"></feDropShadow>
                                </filter>
                            </defs>
                            <circle cx="320" cy="260" r="190" fill="url(#bd-orb)" stroke="#ffffff"
                                stroke-opacity=".7" stroke-width="3" filter="url(#bd-shadow)"></circle>
                            <path class="bd-orbit" d="M155 270c35-125 167-185 290-128 77 36 111 112 73 188" fill="none"
                                stroke="#8b5cf6" stroke-linecap="round" stroke-width="6" stroke-opacity=".7"></path>
                            <path d="M205 354c70 53 176 61 259 12" fill="none" stroke="#79c8df" stroke-linecap="round"
                                stroke-width="5" stroke-opacity=".7"></path>
                            <g class="bd-float">
                                <circle cx="207" cy="184" r="31" fill="#7c3aed"></circle>
                                <rect x="161" y="220" width="92" height="91" rx="28" fill="#7c3aed"></rect>
                                <circle cx="207" cy="184" r="11" fill="#ffffff" fill-opacity=".75"></circle>
                            </g>
                            <g class="bd-float bd-float-delay">
                                <circle cx="434" cy="170" r="28" fill="#48b9d9"></circle>
                                <rect x="393" y="203" width="82" height="86" rx="26" fill="#48b9d9"></rect>
                                <circle cx="434" cy="170" r="10" fill="#ffffff" fill-opacity=".75"></circle>
                            </g>
                            <g class="bd-float bd-float-delay-two">
                                <circle cx="338" cy="337" r="30" fill="#f4bf3a"></circle>
                                <rect x="294" y="373" width="88" height="72" rx="25" fill="#f4bf3a"></rect>
                                <circle cx="338" cy="337" r="10" fill="#ffffff" fill-opacity=".75"></circle>
                            </g>
                            <g transform="translate(253 218)">
                                <rect width="136" height="84" rx="22" fill="#ffffff" fill-opacity=".8"
                                    stroke="#ffffff" stroke-width="3"></rect>
                                <path d="M32 43h68M68 23v40M52 43l16 16 16-16" fill="none" stroke="#7c3aed"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="7"></path>
                                <circle cx="25" cy="20" r="5" fill="#48b9d9"></circle>
                                <circle cx="111" cy="64" r="5" fill="#f4bf3a"></circle>
                            </g><text x="320" y="480" fill="#5b21b6" font-family="Manrope, sans-serif" font-size="16"
                                font-weight="700" letter-spacing="3" text-anchor="middle">CONNECT · GROW · CREATE</text>
                        </svg></div>
                </div>
            </div>
        </section>

        <section id="tentang-bd" class="scroll-mt-6 border-b border-slate-300/70 py-16 sm:py-24">
            <div class="grid items-start gap-10 lg:grid-cols-[.82fr_1.18fr]">
                <div><span class="eyebrow">Tentang BD HMPS MI</span>
                    <h2 class="mt-3 text-3xl font-bold leading-tight sm:text-4xl">Bukan sekadar etalase, tapi ruang untuk
                        saling menguatkan.</h2>
                </div>
                <div>
                    <p class="text-base leading-7 text-slate-600">Business Development HMPS MI adalah divisi yang
                        memfasilitasi
                        mahasiswa POLMED untuk mengenalkan usaha, jasa, dan barang personal mereka. Kami berperan sebagai
                        penghubung dan kurator, bukan sebagai penjual.</p>
                    <p class="mt-5 text-base leading-7 text-slate-600">Melalui platform ini, mahasiswa dapat menemukan
                        karya teman satu kampus, mendukung usaha kecil, dan membuka percakapan langsung dengan pemiliknya.
                    </p>
                    <div class="mt-8 grid gap-3 sm:grid-cols-3">
                        <div class="soft-card p-4"><strong
                                class="block text-2xl text-violet-600">{{ $memberCountLabel }}+</strong><span
                                class="mt-1 block text-xs text-slate-500">Mahasiswa bergabung</span></div>
                        <div class="soft-card p-4"><strong
                                class="block text-2xl text-violet-600">{{ $storeCountLabel }}+</strong><span
                                class="mt-1 block text-xs text-slate-500">Toko mahasiswa</span></div>
                        <div class="soft-card p-4"><strong
                                class="block text-2xl text-violet-600">{{ $workCountLabel }}+</strong><span
                                class="mt-1 block text-xs text-slate-500">Karya terdaftar</span></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-b border-slate-300/70 py-16 sm:py-24">
            <div class="max-w-2xl"><span class="eyebrow">Arah gerak kami</span>
                <h2 class="mt-3 text-3xl font-bold sm:text-4xl">Membangun ekosistem yang ramah untuk bertumbuh.</h2>
            </div>
            <div class="mt-8 grid gap-5 lg:grid-cols-2">
                <article class="soft-card p-6 sm:p-8"><span
                        class="grid h-11 w-11 place-items-center rounded-2xl bg-violet-100 text-violet-600"><i
                            data-lucide="telescope" class="h-5 w-5"></i></span>
                    <h3 class="mt-6 text-xl font-bold">Visi</h3>
                    <p class="mt-3 max-w-lg leading-7 text-slate-500">Menjadi wadah pengembangan bisnis mahasiswa Manajemen
                        Informatika untuk menciptakan bisnis inovatif yang menggabungkan kreativitas, teknologi, dan ilmu
                        manajemen.</p>
                </article>
                <article class="soft-card p-6 sm:p-8"><span
                        class="grid h-11 w-11 place-items-center rounded-2xl bg-violet-100 text-violet-600"><i
                            data-lucide="route" class="h-5 w-5"></i></span>
                    <h3 class="mt-6 text-xl font-bold">Misi</h3>
                    <p class="mt-3 max-w-lg leading-7 text-slate-500">Kami fokus meningkatkan skill mahasiswa melalui
                        seminar dan membangun wadah kolaborasi untuk berbagi ide.
                        Tujuannya adalah membantu mahasiswa mewujudkan bisnis digital yang inovatif, dan membentuk mental
                        profesional dan kreatif.</p>
                </article>
            </div>
        </section>


        <section class="border-b border-slate-300/70 py-16 sm:py-24">
            <div class="grid items-end gap-6 lg:grid-cols-[.85fr_1.15fr]">
                <div><span class="eyebrow">Orang-orang di balik BD HMPS MI</span>
                    <h2 class="mt-3 text-3xl font-bold sm:text-4xl">Karya tumbuh ketika orang, ide, dan dukungan bertemu.
                    </h2>
                </div>
                <p class="max-w-xl leading-7 text-slate-500 lg:justify-self-end">Business Development dibangun oleh
                    mahasiswa yang saling menguatkan, membuka ruang kolaborasi, dan membawa karya POLMED lebih dekat dengan
                    banyak orang.</p>
            </div>
            <div class="bd-team-photo-wrap mt-10"><img src="{{ $teamPhotoUrl ?? asset('image/divisi_bd.jpeg') }}"
                    alt="Anggota Business Development HMPS MI" class="bd-team-photo">
                <div class="bd-team-photo-label"><span class="eyebrow">Business Development ·
                        HMPS MI</span><strong>Berproses bersama, bertumbuh bersama.</strong></div>
            </div>
        </section>

        <section id="peran-bd" class="scroll-mt-6 border-b border-slate-300/70 py-16 sm:py-24">
            <div class="max-w-2xl"><span class="eyebrow">Peran Business Development</span>
                <h2 class="mt-3 text-3xl font-bold sm:text-4xl">Tiga cara kami membantu karya mahasiswa.</h2>
                <p class="mt-4 leading-7 text-slate-500">Platform ini dirancang supaya karya mahasiswa lebih mudah
                    ditemukan tanpa mengambil alih proses transaksi dari pemiliknya.</p>
            </div>
            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <article class="soft-card p-5 sm:p-6"><span class="text-3xl font-bold text-violet-600">01</span>
                    <h3 class="mt-8 text-lg font-bold">Menghubungkan</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Mempertemukan mahasiswa pemilik karya dengan
                        lingkungan kampus dan masyarakat.</p>
                </article>
                <article class="soft-card p-5 sm:p-6"><span class="text-3xl font-bold text-violet-600">02</span>
                    <h3 class="mt-8 text-lg font-bold">Mengkurasi</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Menjaga katalog tetap tertata, informatif, dan
                        merepresentasikan karya mahasiswa.</p>
                </article>
                <article class="soft-card p-5 sm:p-6"><span class="text-3xl font-bold text-violet-600">03</span>
                    <h3 class="mt-8 text-lg font-bold">Menggerakkan</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Mendorong budaya saling mendukung dan membuka peluang
                        kolaborasi baru.</p>
                </article>
            </div>
        </section>

        <section class="py-16 sm:py-24">
            <div class="text-center"><span class="eyebrow">Jelajahi karya mahasiswa</span>
                <h2 class="mt-3 text-3xl font-bold sm:text-4xl">Mulai dari ruang yang ingin kamu temukan.</h2>
                <p class="mx-auto mt-4 max-w-xl leading-7 text-slate-500">Lihat etalase karya mahasiswa POLMED dan dukung
                    mereka dengan memulai percakapan langsung.</p>
            </div>
            <div class="mt-9 grid gap-4 sm:grid-cols-3"><a href="{{ route('products.index') }}"
                    class="soft-card group p-5 hover:-translate-y-1 sm:p-6"><span
                        class="grid h-11 w-11 place-items-center rounded-2xl bg-violet-100 text-violet-600"><i
                            data-lucide="package" class="h-5 w-5"></i></span>
                    <h3 class="mt-6 text-xl font-bold">Produk UMKM</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Temukan produk dan jasa yang ditawarkan mahasiswa.</p>
                    <span class="mt-7 inline-flex items-center gap-2 text-sm font-bold text-violet-600">Lihat produk <i
                            data-lucide="arrow-up-right" class="h-4 w-4 transition group-hover:translate-x-1"></i></span>
                </a><a href="{{ route('stores.index') }}" class="soft-card group p-5 hover:-translate-y-1 sm:p-6"><span
                        class="grid h-11 w-11 place-items-center rounded-2xl bg-violet-100 text-violet-600"><i
                            data-lucide="store" class="h-5 w-5"></i></span>
                    <h3 class="mt-6 text-xl font-bold">Toko Mahasiswa</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Kenali mahasiswa dan toko yang tumbuh bersama BD.</p>
                    <span class="mt-7 inline-flex items-center gap-2 text-sm font-bold text-violet-600">Lihat toko <i
                            data-lucide="arrow-up-right" class="h-4 w-4 transition group-hover:translate-x-1"></i></span>
                </a><a href="{{ route('preloved.index') }}" class="soft-card group p-5 hover:-translate-y-1 sm:p-6"><span
                        class="grid h-11 w-11 place-items-center rounded-2xl bg-violet-100 text-violet-600"><i
                            data-lucide="recycle" class="h-5 w-5"></i></span>
                    <h3 class="mt-6 text-xl font-bold">Preloved</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Beri kesempatan kedua untuk barang yang masih layak.
                    </p><span class="mt-7 inline-flex items-center gap-2 text-sm font-bold text-violet-600">Lihat preloved
                        <i data-lucide="arrow-up-right" class="h-4 w-4 transition group-hover:translate-x-1"></i></span>
                </a></div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('bd-growth-animation');

            if (container && window.lottie) {
                const fallback = document.getElementById('bd-growth-fallback');
                const animation = window.lottie.loadAnimation({
                    container,
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: '{{ asset('animations/bd-growth.json') }}',
                    rendererSettings: {
                        preserveAspectRatio: 'xMidYMid meet',
                    },
                });
                animation.addEventListener('DOMLoaded', () => fallback?.remove());
            }

            const teamPhoto = document.querySelector('.bd-team-photo-wrap');
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (teamPhoto && !reducedMotion) {
                teamPhoto.addEventListener('pointerenter', (event) => {
                    if (event.pointerType === 'touch') return;
                    teamPhoto.classList.add('is-hovered');
                });

                teamPhoto.addEventListener('pointermove', (event) => {
                    if (event.pointerType === 'touch') return;
                    const bounds = teamPhoto.getBoundingClientRect();
                    const x = ((event.clientX - bounds.left) / bounds.width) * 100;
                    const y = ((event.clientY - bounds.top) / bounds.height) * 100;
                    const tiltX = ((50 - y) / 50) * 3;
                    const tiltY = ((x - 50) / 50) * 3;
                    teamPhoto.style.setProperty('--photo-x', `${Math.max(0, Math.min(100, x))}%`);
                    teamPhoto.style.setProperty('--photo-y', `${Math.max(0, Math.min(100, y))}%`);
                    teamPhoto.style.setProperty('--tilt-x', `${tiltX.toFixed(2)}deg`);
                    teamPhoto.style.setProperty('--tilt-y', `${tiltY.toFixed(2)}deg`);
                });

                teamPhoto.addEventListener('pointerleave', () => {
                    teamPhoto.classList.remove('is-hovered');
                    teamPhoto.style.setProperty('--photo-x', '50%');
                    teamPhoto.style.setProperty('--photo-y', '50%');
                    teamPhoto.style.setProperty('--tilt-x', '0deg');
                    teamPhoto.style.setProperty('--tilt-y', '0deg');
                });
            }

        });
    </script>
@endpush
