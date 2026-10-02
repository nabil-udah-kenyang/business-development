@extends('layouts.auth')

@section('title', 'Daftar · Business Development HMPS MI')

@section('content')
    <div class="page-shell grid min-h-[62vh] place-items-center py-12">
        <div class="soft-card depth-card w-full max-w-md p-7 sm:p-9">
            <div class="text-center">
                @if (!empty($siteSettings?->platform_logo))
                    <img src="{{ asset($siteSettings->platform_logo) }}" alt="{{ $siteSettings->platform_short_name ?? 'HMPS MI' }}" class="logo-mark mx-auto object-contain">
                @else
                    <span class="logo-mark mx-auto">BD</span>
                @endif
                <h1 class="mt-5 text-3xl font-bold">Register BD HMPS MI</h1>
                <p class="mt-3 text-sm leading-6 text-slate-500">
                    Bergabung untuk mengenalkan karya dan menemukan peluang baru di lingkungan POLMED.
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-8 grid gap-5">
                @csrf

                <div>
                    <label for="name" class="register-form-label mb-2 block text-sm font-semibold text-slate-700">Nama lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" class="field w-full" required autofocus autocomplete="name" placeholder="Nama kamu">
                    @error('name')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="register-form-label mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="field w-full" required autocomplete="username" placeholder="nama@contoh.com">
                    @error('email')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <fieldset>
                    <legend class="register-form-label mb-3 block text-sm font-semibold text-slate-700">Kamu mendaftar sebagai apa?</legend>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <label class="group relative cursor-pointer">
                            <input type="radio" name="account_type" value="seller" class="peer sr-only" {{ old('account_type', 'seller') === 'seller' ? 'checked' : '' }} required>
                            <span class="register-account-option flex h-full items-start gap-3 rounded-2xl border border-slate-200/80 bg-white/35 p-4 transition group-hover:border-violet-300 peer-checked:border-violet-500 peer-checked:bg-violet-50/80 peer-focus-visible:ring-2 peer-focus-visible:ring-violet-400">
                                <span class="register-account-icon register-account-icon-seller grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-violet-100 text-violet-600">
                                    <i data-lucide="store" class="h-4 w-4"></i>
                                </span>
                                <span>
                                    <span class="register-account-title block text-sm font-bold text-slate-800">Punya usaha</span>
                                    <span class="register-account-description mt-1 block text-xs leading-5 text-slate-500">Untuk menjual produk atau jasa usaha.</span>
                                </span>
                            </span>
                        </label>

                        <label class="group relative cursor-pointer">
                            <input type="radio" name="account_type" value="preloved" class="peer sr-only" {{ old('account_type') === 'preloved' ? 'checked' : '' }}>
                            <span class="register-account-option flex h-full items-start gap-3 rounded-2xl border border-slate-200/80 bg-white/35 p-4 transition group-hover:border-violet-300 peer-checked:border-violet-500 peer-checked:bg-violet-50/80 peer-focus-visible:ring-2 peer-focus-visible:ring-violet-400">
                                <span class="register-account-icon register-account-icon-preloved grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-sky-100 text-sky-600">
                                    <i data-lucide="recycle" class="h-4 w-4"></i>
                                </span>
                                <span>
                                    <span class="register-account-title block text-sm font-bold text-slate-800">Jual barang bekas</span>
                                    <span class="register-account-description mt-1 block text-xs leading-5 text-slate-500">Untuk menjual barang second milikmu.</span>
                                </span>
                            </span>
                        </label>
                    </div>
                    @error('account_type')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </fieldset>

                <div>
                    <label for="password" class="register-form-label mb-2 block text-sm font-semibold text-slate-700">Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" class="field w-full pr-14" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                        <button type="button" data-password-toggle="password" aria-label="Tampilkan password" aria-pressed="false" class="password-toggle"><i data-password-icon data-lucide="eye" class="h-4 w-4"></i></button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="register-form-label mb-2 block text-sm font-semibold text-slate-700">Konfirmasi password</label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" class="field w-full pr-14" required autocomplete="new-password" placeholder="Ulangi password">
                        <button type="button" data-password-toggle="password_confirmation" aria-label="Tampilkan password" aria-pressed="false" class="password-toggle"><i data-password-icon data-lucide="eye" class="h-4 w-4"></i></button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary mt-1 w-full justify-center">
                    <i data-lucide="user-plus" class="h-4 w-4"></i>
                    Daftar
                </button>
            </form>

            <div class="mt-7 border-t border-slate-200/70 pt-5 text-center">
                <p class="text-sm text-slate-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-bold text-violet-600 hover:text-violet-700">Masuk</a>
                </p>
                <a href="{{ route('home') }}" class="mt-4 inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-violet-600">
                    <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
                    Kembali ke website
                </a>
            </div>
        </div>
    </div>
@endsection
