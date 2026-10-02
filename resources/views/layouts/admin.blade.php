<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ !empty($siteSettings?->platform_logo) ? asset($siteSettings->platform_logo) : asset('favicon.ico') }}">
    <title>@yield('title', 'Superadmin') · {{ $siteSettings?->platform_short_name ?? 'HMPS MI' }}</title>
    <script>
        (() => {
            const savedTheme = localStorage.getItem('theme');
            const useDarkTheme = savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', useDarkTheme);
        })();
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen md:grid md:grid-cols-[250px_minmax(0,1fr)]">
        @include('partials.admin-sidebar')
        <main class="min-w-0 px-4 py-5 sm:px-7 sm:py-7">
            <div class="mx-auto max-w-[88rem]">
                <div class="mb-5 flex items-center justify-between md:hidden">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                        @if (!empty($siteSettings?->platform_logo))
                            <img src="{{ asset($siteSettings->platform_logo) }}" alt="{{ $siteSettings->platform_short_name ?? 'HMPS MI' }}" class="logo-mark object-contain">
                        @else
                            <span class="logo-mark">BD</span>
                        @endif
                        <span class="leading-tight"><strong class="block text-sm">{{ $siteSettings?->platform_short_name ?? 'HMPS MI' }}</strong><small class="text-[.62rem] text-violet-600">Superadmin panel</small></span>
                    </a>
                    <div class="flex items-center gap-2">
                        <button type="button" data-theme-toggle aria-label="Gunakan tema gelap" title="Gunakan tema gelap" class="header-theme-toggle btn-soft !rounded-xl !p-3"><i data-lucide="moon" class="h-5 w-5"></i></button>
                        <button type="button" data-menu-toggle="#admin-mobile-menu" aria-label="Buka menu" class="btn-soft !rounded-xl !p-3"><i data-lucide="menu" class="h-5 w-5"></i></button>
                    </div>
                </div>
                @include('partials.flash-message')
                @yield('content')
            </div>
        </main>
    </div>
    @include('partials.demo-toast')
    @stack('scripts')
</body>
</html>
