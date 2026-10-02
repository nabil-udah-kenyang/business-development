@extends('layouts.auth')

@section('title', 'Reset Password · Business Development HMPS MI')

@section('content')
    <div class="page-shell grid min-h-[62vh] place-items-center py-12">
        <div class="soft-card depth-card w-full max-w-md p-7 sm:p-9">
            <div class="text-center">
                @if (!empty($siteSettings?->platform_logo))
                    <img src="{{ asset($siteSettings->platform_logo) }}" alt="{{ $siteSettings->platform_short_name ?? 'HMPS MI' }}" class="logo-mark mx-auto object-contain">
                @else
                    <span class="logo-mark mx-auto">BD</span>
                @endif
                <h1 class="mt-5 text-3xl font-bold">Buat password baru</h1>
                <p class="mt-3 text-sm leading-6 text-slate-500">
                    Gunakan password baru yang kuat untuk mengamankan akun kamu.
                </p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="mt-8 grid gap-5">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" class="field w-full" required autofocus autocomplete="username" placeholder="nama@contoh.com">
                    @error('email')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password baru</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" class="field w-full pr-14" required autocomplete="new-password" placeholder="Masukkan password baru">
                        <button type="button" data-password-toggle="password" aria-label="Tampilkan password" aria-pressed="false" class="password-toggle"><i data-password-icon data-lucide="eye" class="h-4 w-4"></i></button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi password</label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" class="field w-full pr-14" required autocomplete="new-password" placeholder="Ulangi password baru">
                        <button type="button" data-password-toggle="password_confirmation" aria-label="Tampilkan password" aria-pressed="false" class="password-toggle"><i data-password-icon data-lucide="eye" class="h-4 w-4"></i></button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary mt-1 w-full justify-center">
                    <i data-lucide="key-round" class="h-4 w-4"></i>
                    Simpan password baru
                </button>
            </form>
        </div>
    </div>
@endsection
