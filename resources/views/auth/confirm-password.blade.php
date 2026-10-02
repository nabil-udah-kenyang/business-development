@extends('layouts.auth')

@section('title', 'Konfirmasi Password · Business Development HMPS MI')

@section('content')
    <div class="page-shell grid min-h-[62vh] place-items-center py-12">
        <div class="soft-card depth-card w-full max-w-md p-7 sm:p-9">
            <div class="text-center">
                @if (!empty($siteSettings?->platform_logo))
                    <img src="{{ asset($siteSettings->platform_logo) }}" alt="{{ $siteSettings->platform_short_name ?? 'HMPS MI' }}" class="logo-mark mx-auto object-contain">
                @else
                    <span class="logo-mark mx-auto">BD</span>
                @endif
                <h1 class="mt-5 text-3xl font-bold">Konfirmasi password</h1>
                <p class="mt-3 text-sm leading-6 text-slate-500">
                    Untuk keamanan, konfirmasi password kamu sebelum melanjutkan.
                </p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="mt-8 grid gap-5">
                @csrf

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" class="field w-full pr-14" required autofocus autocomplete="current-password" placeholder="Masukkan password">
                        <button type="button" data-password-toggle="password" aria-label="Tampilkan password" aria-pressed="false" class="password-toggle"><i data-password-icon data-lucide="eye" class="h-4 w-4"></i></button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full justify-center">
                    <i data-lucide="shield-check" class="h-4 w-4"></i>
                    Konfirmasi
                </button>
            </form>
        </div>
    </div>
@endsection
