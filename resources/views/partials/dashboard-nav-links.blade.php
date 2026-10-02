<div class="mt-10 px-2 text-[.68rem] font-bold uppercase tracking-widest text-slate-400">Workspace</div>
<nav class="mt-3 grid gap-1">
    <a class="sidebar-link {{ request()->routeIs('seller.dashboard','preloved-user.dashboard') ? 'active' : '' }}" href="{{ $isPreloved ? route('preloved-user.dashboard') : route('seller.dashboard') }}"><i data-lucide="layout-dashboard" class="h-4 w-4"></i>Dashboard</a>
    <a class="sidebar-link {{ request()->routeIs('seller.products','preloved-user.products') ? 'active' : '' }}" href="{{ $isPreloved ? route('preloved-user.products') : route('seller.products') }}"><i data-lucide="package" class="h-4 w-4"></i>Produk Saya</a>
    <a class="sidebar-link {{ request()->routeIs('seller.products.create','preloved-user.products.create') ? 'active' : '' }}" href="{{ $isPreloved ? route('preloved-user.products.create') : route('seller.products.create') }}"><i data-lucide="plus-square" class="h-4 w-4"></i>Tambah Produk</a>
    @if (!$isPreloved)<a class="sidebar-link {{ request()->routeIs('seller.store') ? 'active' : '' }}" href="{{ route('seller.store') }}"><i data-lucide="store" class="h-4 w-4"></i>Toko Saya</a>@endif
    <a class="sidebar-link {{ request()->routeIs('seller.profile','preloved-user.profile') ? 'active' : '' }}" href="{{ $isPreloved ? route('preloved-user.profile') : route('seller.profile') }}"><i data-lucide="user-round" class="h-4 w-4"></i>Profil</a>
</nav>
<form method="POST" action="{{ route('logout') }}" class="mt-auto pt-8">
    @csrf
    <button type="submit" class="sidebar-link w-full border-0 bg-transparent text-left text-slate-400"><i data-lucide="log-out" class="h-4 w-4"></i>Logout</button>
</form>
