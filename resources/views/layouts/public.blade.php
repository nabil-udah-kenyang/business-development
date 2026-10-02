<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ !empty($siteSettings?->platform_logo) ? asset($siteSettings->platform_logo) : asset('favicon.ico') }}">
    <title>@yield('title', $seoTitle ?? 'Business Development HMPS MI')</title>
    <meta name="description" content="@yield('meta_description', $seoDescription ?? 'Platform Business Development HMPS MI untuk menemukan produk, jasa, toko, dan preloved mahasiswa POLMED.')">
    <link rel="canonical" href="@yield('canonical_url', $seoCanonical ?? url()->current())">
    <link rel="sitemap" type="application/xml" href="{{ url('/sitemap.xml') }}">
    <meta property="og:type" content="{{ $seoType ?? 'website' }}">
    <meta property="og:title" content="@yield('title', $seoTitle ?? 'Business Development HMPS MI')">
    <meta property="og:description" content="@yield('meta_description', $seoDescription ?? 'Platform Business Development HMPS MI untuk menemukan produk, jasa, toko, dan preloved mahasiswa POLMED.')">
    <meta property="og:url" content="@yield('canonical_url', $seoCanonical ?? url()->current())">
    @if (!empty($seoImage))
        <meta property="og:image" content="{{ $seoImage }}">
    @elseif (!empty($siteSettings?->platform_logo))
        <meta property="og:image" content="{{ asset($siteSettings->platform_logo) }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $seoTitle ?? 'Business Development HMPS MI')">
    <meta name="twitter:description" content="@yield('meta_description', $seoDescription ?? 'Platform Business Development HMPS MI untuk menemukan produk, jasa, toko, dan preloved mahasiswa POLMED.')">
    <script>
        (() => {
            const savedTheme = localStorage.getItem('theme');
            const useDarkTheme = savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', useDarkTheme);
        })();
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased page-bottom">
    @include('partials.public-header')
    <main>@yield('content')</main>
    @include('partials.public-footer')
    @include('partials.mobile-bottom-nav')
    @include('partials.demo-toast')
    @stack('scripts')
</body>
</html>
