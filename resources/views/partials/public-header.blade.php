<header class="public-header sticky top-0 z-30 px-3 pt-3 sm:px-6 sm:pt-5">
    <div class="soft-surface mx-auto flex max-w-7xl items-center justify-between rounded-2xl px-4 py-3 sm:px-5">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            @if (!empty($siteSettings?->platform_logo))
                <img src="{{ asset($siteSettings->platform_logo) }}" alt="{{ $siteSettings->platform_short_name ?? 'HMPS MI' }}" class="logo-mark object-contain">
            @else
                <span class="logo-mark">BD</span>
            @endif
            <span class="leading-tight"><strong class="block text-xs sm:text-sm">{{ $siteSettings?->platform_name ?? 'Business Development HMPS MI' }}</strong><small class="text-[.62rem] font-semibold text-violet-600 sm:text-[.68rem]">{{ $siteSettings?->platform_short_name ?? 'HMPS MI' }}</small></span>
        </a>
        <nav class="desktop-only flex items-center gap-6">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Produk</a>
            <a class="nav-link {{ request()->routeIs('stores.*') ? 'active' : '' }}" href="{{ route('stores.index') }}">Toko</a>
            <a class="nav-link {{ request()->routeIs('preloved.*') ? 'active' : '' }}" href="{{ route('preloved.index') }}">Preloved</a>
        </nav>
        <div class="flex items-center gap-2">
            <button type="button" data-theme-toggle aria-label="Gunakan tema gelap" title="Gunakan tema gelap" class="header-theme-toggle btn-soft !rounded-xl !p-2.5"><i data-lucide="moon" class="h-4 w-4"></i></button>
            @auth
                <a href="{{ route($headerDashboardRoute) }}" class="desktop-only btn-primary !rounded-xl !px-3.5 !py-2.5 text-xs sm:text-sm"><i data-lucide="layout-dashboard" class="h-4 w-4"></i><span class="hidden sm:inline">Dashboard</span></a>
            @else
                <a href="{{ route('login') }}" class="desktop-only btn-primary !rounded-xl !px-3.5 !py-2.5 text-xs sm:text-sm"><i data-lucide="log-in" class="h-4 w-4"></i><span class="hidden sm:inline">Masuk</span></a>
            @endauth
        </div>
    </div>
</header>
