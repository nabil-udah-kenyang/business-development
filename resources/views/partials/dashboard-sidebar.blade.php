<aside class="hidden min-h-screen flex-col border-r border-white/70 bg-[var(--surface)] px-4 py-6 dark:border-white/10 md:flex">
    <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-2">
        @if (!empty($siteSettings?->platform_logo))
            <img src="{{ asset($siteSettings->platform_logo) }}" alt="{{ $siteSettings->platform_short_name ?? 'HMPS MI' }}" class="logo-mark object-contain">
        @else
            <span class="logo-mark">BD</span>
        @endif
        <span class="leading-tight"><strong class="block text-sm">{{ $siteSettings?->platform_short_name ?? $siteSettings?->platform_name ?? 'HMPS MI' }}</strong><small class="text-[.65rem] text-violet-600">{{ $isPreloved ? 'Preloved user' : 'Seller space' }}</small></span>
    </a>
    <button type="button" data-theme-toggle aria-label="Gunakan tema gelap" title="Gunakan tema gelap" class="header-theme-toggle btn-soft mt-6 w-full !rounded-xl !p-2.5"><i data-lucide="moon" class="h-4 w-4"></i><span class="text-xs">Ganti tema</span></button>
    @include('partials.dashboard-nav-links')
</aside>

<div id="dashboard-mobile-menu" class="fixed inset-0 z-50 hidden md:hidden">
    <button type="button" data-menu-toggle="#dashboard-mobile-menu" aria-label="Tutup menu" class="absolute inset-0 bg-slate-900/20"></button>
    <aside class="relative flex h-full w-72 flex-col border-r border-white/70 bg-[var(--surface)] px-4 py-6 shadow-2xl dark:border-white/10">
        <div class="flex items-center justify-between px-2">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                @if (!empty($siteSettings?->platform_logo))
                <img src="{{ asset($siteSettings->platform_logo) }}" alt="{{ $siteSettings->platform_short_name ?? 'HMPS MI' }}" class="logo-mark object-contain">
                @else
                    <span class="logo-mark">BD</span>
                @endif
            <span class="leading-tight"><strong class="block text-sm">{{ $siteSettings?->platform_short_name ?? $siteSettings?->platform_name ?? 'HMPS MI' }}</strong><small class="text-[.65rem] text-violet-600">{{ $isPreloved ? 'Preloved user' : 'Seller space' }}</small></span>
            </a>
            <div class="flex items-center gap-2">
                <button type="button" data-theme-toggle aria-label="Gunakan tema gelap" title="Gunakan tema gelap" class="header-theme-toggle btn-soft !rounded-xl !p-2"><i data-lucide="moon" class="h-4 w-4"></i></button>
                <button type="button" data-menu-toggle="#dashboard-mobile-menu" aria-label="Tutup menu" class="btn-soft !rounded-xl !p-2"><i data-lucide="x" class="h-4 w-4"></i></button>
            </div>
        </div>
        @include('partials.dashboard-nav-links')
    </aside>
</div>
