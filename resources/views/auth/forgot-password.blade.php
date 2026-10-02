@extends('layouts.auth')

@section('title', 'Lupa Password · Business Development HMPS MI')

@section('content')
    <div class="page-shell grid min-h-[62vh] place-items-center py-12">
        <div class="soft-card depth-card w-full max-w-md p-7 sm:p-9">
            <div class="text-center">
                @if (!empty($siteSettings?->platform_logo))
                    <img src="{{ asset($siteSettings->platform_logo) }}" alt="{{ $siteSettings->platform_short_name ?? 'HMPS MI' }}" class="logo-mark mx-auto object-contain">
                @else
                    <span class="logo-mark mx-auto">BD</span>
                @endif
                <h1 class="mt-5 text-3xl font-bold">Lupa password?</h1>
                <p class="mt-3 text-sm leading-6 text-slate-500">
                    Masukkan email akun kamu. Kami akan mengirimkan tautan untuk membuat password baru.
                </p>
            </div>

            @if (session('status'))
                <div class="mt-6 rounded-2xl border border-emerald-200/70 bg-emerald-50/70 px-4 py-3 text-sm font-semibold text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="mt-8 grid gap-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="field w-full" required autofocus autocomplete="email" placeholder="nama@contoh.com">
                    @error('email')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full justify-center">
                    <i data-lucide="mail" class="h-4 w-4"></i>
                    Kirim tautan reset
                </button>
            </form>

            <a href="{{ route('login') }}" class="mt-7 inline-flex w-full items-center justify-center gap-2 text-sm font-bold text-violet-600 hover:text-violet-700">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Kembali ke halaman masuk
            </a>
        </div>
    </div>
@endsection
