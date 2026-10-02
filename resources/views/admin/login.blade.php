<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ !empty($siteSettings?->platform_logo) ? asset($siteSettings->platform_logo) : asset('favicon.ico') }}">
    <title>Portal Internal · {{ $siteSettings?->platform_short_name ?? 'HMPS MI' }}</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="grid min-h-screen place-items-center p-5">
    <main class="soft-card depth-card w-full max-w-md p-7 sm:p-9">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            @if (!empty($siteSettings?->platform_logo))
                <img src="{{ asset($siteSettings->platform_logo) }}" alt="{{ $siteSettings->platform_short_name ?? 'HMPS MI' }}" class="logo-mark object-contain">
            @else
                <span class="logo-mark">BD</span>
            @endif
            <span><strong class="block text-sm">{{ $siteSettings?->platform_name ?? 'Business Development HMPS MI' }}</strong><small class="text-xs text-violet-600">{{ $siteSettings?->platform_short_name ?? 'HMPS MI' }} · internal portal</small></span>
        </a>
        <div class="mt-10"><span class="eyebrow">Private access</span><h1 class="mt-2 text-3xl font-bold">Masuk sebagai superadmin</h1><p class="mt-3 text-sm leading-6 text-slate-500">Kelola katalog, toko, pengguna, dan publikasi dari satu panel.</p></div>
        <form method="POST" action="{{ route('login') }}" class="mt-7 grid gap-5">
            @csrf
            <div>
                <label for="email" class="text-sm font-bold">Email</label>
                <input id="email" name="email" class="field mt-2" type="email" value="{{ old('email') }}" placeholder="superadmin@demo.com" required autofocus autocomplete="username">
                @error('email')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password" class="text-sm font-bold">Password</label>
                <div class="relative mt-2">
                    <input id="password" name="password" class="field pr-14" type="password" placeholder="Masukkan password" required autocomplete="current-password">
                    <button type="button" data-password-toggle="password" aria-label="Tampilkan password" aria-pressed="false" class="password-toggle"><i data-password-icon data-lucide="eye" class="h-4 w-4"></i></button>
                </div>
                @error('password')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="btn-primary mt-1 w-full justify-center">Masuk ke panel <i data-lucide="arrow-right" class="h-4 w-4"></i></button>
        </form>
        <a href="{{ route('home') }}" class="mt-6 flex items-center justify-center gap-2 text-xs font-bold text-slate-400"><i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>Kembali ke website publik</a>
    </main>
</body>
</html>
