@extends('layouts.auth')

@section('title', 'Masuk · Business Development HMPS MI')

@section('content')
    <div class="page-shell grid min-h-[62vh] place-items-center py-12">
        <div class="soft-card depth-card w-full max-w-md p-7 sm:p-9">
            <div class="text-center">
                @if (!empty($siteSettings?->platform_logo))
                    <img src="{{ asset($siteSettings->platform_logo) }}" alt="{{ $siteSettings->platform_short_name ?? 'HMPS MI' }}" class="logo-mark mx-auto object-contain">
                @else
                    <span class="logo-mark mx-auto">BD</span>
                @endif
                <h1 class="mt-5 text-3xl font-bold">Masuk ke BD HMPS MI</h1>

            </div>

            @if (session('status'))
                <div class="mt-6 rounded-2xl bg-violet-50 px-4 py-3 text-sm text-violet-700">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-8 grid gap-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="field w-full" required autofocus autocomplete="username" placeholder="nama@contoh.com">
                    @error('email')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between gap-4">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-violet-600 hover:text-violet-700">Lupa password?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <input id="password" name="password" type="password" class="field w-full pr-14" required autocomplete="current-password" placeholder="Masukkan password">
                        <button type="button" data-password-toggle="password" aria-label="Tampilkan password" aria-pressed="false" class="password-toggle"><i data-password-icon data-lucide="eye" class="h-4 w-4"></i></button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="inline-flex items-center gap-3 text-sm text-slate-500">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-violet-600 focus:ring-violet-500">
                    Ingat saya
                </label>

                <button type="submit" class="btn-primary mt-1 w-full justify-center">
                    <i data-lucide="log-in" class="h-4 w-4"></i>
                    Masuk
                </button>
            </form>

            <div class="mt-7 border-t border-slate-200/70 pt-5 text-center">
                @if (Route::has('register'))
                    <p class="mt-4 text-sm text-slate-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-bold text-violet-600 hover:text-violet-700">Daftar</a>
                    </p>
                @endif
                <a href="{{ route('home') }}" class="mt-4 inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-violet-600">
                    <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
                    Kembali ke website
                </a>
            </div>
        </div>
    </div>
@endsection
