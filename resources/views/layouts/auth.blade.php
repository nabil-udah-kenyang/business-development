<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ !empty($siteSettings?->platform_logo) ? asset($siteSettings->platform_logo) : asset('favicon.ico') }}">
    <title>@yield('title', 'Autentikasi · Business Development HMPS MI')</title>
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
    <main>@yield('content')</main>
    @stack('scripts')
</body>
</html>
