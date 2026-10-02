<nav class="bottom-nav mobile-only flex items-end px-2" aria-label="Navigasi mobile">
    @if (isset($dashboard) && $dashboard)
        <a class="{{ request()->routeIs('seller.dashboard', 'preloved-user.dashboard') ? 'active' : '' }}" href="{{ $isPrelovedDashboard ? route('preloved-user.dashboard') : route('seller.dashboard') }}"><i data-lucide="layout-dashboard" class="h-4 w-4"></i><span>Dashboard</span></a>
        <a class="{{ request()->routeIs('seller.products', 'preloved-user.products') ? 'active' : '' }}" href="{{ $isPrelovedDashboard ? route('preloved-user.products') : route('seller.products') }}"><i data-lucide="package" class="h-4 w-4"></i><span>Produk</span></a>
        @if ($isPrelovedDashboard)
            <a class="{{ request()->routeIs('preloved.*') ? 'active' : '' }}" href="{{ route('preloved.index') }}"><i data-lucide="recycle" class="h-4 w-4"></i><span>Preloved</span></a>
        @else
            <a class="store-nav-link {{ request()->routeIs('seller.store') ? 'active' : '' }}" href="{{ route('seller.store') }}"><i data-lucide="store" class="h-4 w-4"></i><span>Toko</span></a>
        @endif
        <a class="{{ request()->routeIs('seller.profile', 'preloved-user.profile') ? 'active' : '' }}" href="{{ $isPrelovedDashboard ? route('preloved-user.profile') : route('seller.profile') }}"><i data-lucide="user-round" class="h-4 w-4"></i><span>Profil</span></a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"><i data-lucide="log-out" class="h-4 w-4"></i><span>Logout</span></button>
        </form>
    @else
        <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"><i data-lucide="house" class="h-4 w-4"></i><span>Beranda</span></a>
        <a class="{{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}"><i data-lucide="layout-grid" class="h-4 w-4"></i><span>Produk</span></a>
        <a class="store-nav-link {{ request()->routeIs('stores.*') ? 'active' : '' }}" href="{{ route('stores.index') }}"><i data-lucide="store" class="h-4 w-4"></i><span>Toko</span></a>
        <a class="{{ request()->routeIs('preloved.*') ? 'active' : '' }}" href="{{ route('preloved.index') }}"><i data-lucide="recycle" class="h-4 w-4"></i><span>Preloved</span></a>
        @auth
            <a href="{{ route($mobileDashboardRoute) }}"><i data-lucide="layout-dashboard" class="h-4 w-4"></i><span>Dashboard</span></a>
        @else
            <a class="{{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}"><i data-lucide="log-in" class="h-4 w-4"></i><span>Masuk</span></a>
        @endauth
    @endif
</nav>
