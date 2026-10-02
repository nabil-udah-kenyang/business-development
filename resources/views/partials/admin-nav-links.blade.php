<div class="mt-10 px-2 text-[.68rem] font-bold uppercase tracking-widest text-slate-400">Administration</div>
<nav class="mt-3 grid gap-1">
    <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i data-lucide="layout-dashboard" class="h-4 w-4"></i>Dashboard</a>
    <a class="sidebar-link {{ request()->routeIs('admin.products') ? 'active' : '' }}" href="{{ route('admin.products') }}"><i data-lucide="package-check" class="h-4 w-4"></i>Produk UMKM</a>
    <a class="sidebar-link {{ request()->routeIs('admin.preloved') ? 'active' : '' }}" href="{{ route('admin.preloved') }}"><i data-lucide="repeat-2" class="h-4 w-4"></i>Preloved</a>
    <a class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i data-lucide="tags" class="h-4 w-4"></i>Kategori</a>
    <a class="sidebar-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}" href="{{ route('admin.promotions.index') }}"><i data-lucide="megaphone" class="h-4 w-4"></i>Slot rekomendasi</a>
    <a class="sidebar-link {{ request()->routeIs('admin.stores') ? 'active' : '' }}" href="{{ route('admin.stores') }}"><i data-lucide="store" class="h-4 w-4"></i>Toko</a>
    <a class="sidebar-link {{ request()->routeIs('admin.sellers') ? 'active' : '' }}" href="{{ route('admin.sellers') }}"><i data-lucide="users" class="h-4 w-4"></i>Seller & pengguna</a>
    <a class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}"><i data-lucide="sliders-horizontal" class="h-4 w-4"></i>Pengaturan</a>
    <a class="sidebar-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}" href="{{ route('admin.profile') }}"><i data-lucide="shield-check" class="h-4 w-4"></i>Profil admin</a>
</nav>
<form method="POST" action="{{ route('logout') }}" class="mt-auto pt-8">
    @csrf
    <button type="submit" class="sidebar-link w-full border-0 bg-transparent text-left text-slate-400"><i data-lucide="log-out" class="h-4 w-4"></i>Logout</button>
</form>
