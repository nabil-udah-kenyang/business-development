<footer class="mx-auto mt-16 max-w-6xl px-4 pb-24 sm:px-6 sm:pb-8">
    <div class="soft-card grid gap-8 p-7 sm:grid-cols-[1.5fr_1fr_1fr] sm:p-9">
        <div>
            <div class="flex items-center gap-2.5">
                @if (!empty($siteSettings?->platform_logo))
                    <img src="{{ asset($siteSettings->platform_logo) }}"
                        alt="{{ $siteSettings->platform_short_name ?? 'HMPS MI' }}"
                    class="logo-mark object-contain">@else<span class="logo-mark">BD</span>
                @endif
                <strong>{{ $siteSettings?->platform_name ?? 'Business Development HMPS MI' }}</strong>
            </div>
            <p class="mt-4 max-w-sm text-sm leading-6 text-slate-500">
                {{ $siteSettings?->platform_description ?? 'Ruang tumbuh untuk karya, produk, dan usaha mahasiswa Politeknik Negeri Medan.' }}
            </p>
        </div>
        <div>
            <h3 class="text-sm font-bold">Jelajahi</h3>
            <div class="mt-3 grid gap-2 text-sm text-slate-500"><a href="{{ route('products.index') }}">Produk Mahasiswa</a><a
                    href="{{ route('stores.index') }}">Toko Mahasiswa</a><a
                    href="{{ route('preloved.index') }}">Preloved</a></div>
        </div>
        <div>
            <h3 class="text-sm font-bold">Terhubung</h3>
            <div class="mt-3 flex flex-col items-start gap-2">
                @foreach ($footerData['socialLinks'] as $link)
                    @if ($link['disabled'])
                        <button type="button" class="social-link" aria-label="{{ $link['label'] }} belum tersedia"
                            title="{{ $link['label'] }} belum tersedia" disabled>
                            <span class="social-icon"><i class="{{ $link['icon'] }}" aria-hidden="true"></i></span>
                            <span>{{ $link['label'] }}</span>
                        </button>
                    @else
                        <a href="{{ $link['url'] }}" target="{{ $link['target'] }}" rel="noreferrer"
                            class="social-link" aria-label="{{ $link['label'] }}" title="{{ $link['label'] }}">
                            <span class="social-icon"><i class="{{ $link['icon'] }}" aria-hidden="true"></i></span>
                            <span>{{ $link['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
            <div class="mt-3 grid gap-2 text-sm text-slate-500">
                @foreach ($footerData['contactLinks'] as $link)
                    <a href="{{ $link['url'] }}" target="{{ $link['target'] }}" rel="noreferrer">{{ $link['label'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
    <p class="pt-5 text-center text-xs text-slate-400">© 2026 Business Development HMPS MI</p>
</footer>
