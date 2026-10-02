@extends('layouts.auth')

@section('title', 'Verifikasi Email · Business Development HMPS MI')

@section('content')
    <div class="page-shell grid min-h-[62vh] place-items-center py-12">
        <div class="soft-card depth-card w-full max-w-lg p-7 sm:p-9">
            <div class="text-center">
                @if (!empty($siteSettings?->platform_logo))
                    <img src="{{ asset($siteSettings->platform_logo) }}" alt="{{ $siteSettings->platform_short_name ?? 'HMPS MI' }}" class="logo-mark mx-auto object-contain">
                @else
                    <span class="logo-mark mx-auto">BD</span>
                @endif
                <h1 class="mt-5 text-3xl font-bold">Verifikasi email kamu</h1>
                <p class="mt-3 text-sm leading-6 text-slate-500">
                    Satu langkah lagi sebelum kamu mulai menggunakan ruang kerja Business Development.
                </p>
            </div>

            <div class="soft-inset mt-7 rounded-2xl border border-slate-200/70 p-5">
                <div class="flex items-start gap-3">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-2xl bg-sky-100 text-sky-600">
                        <i data-lucide="mail-check" class="h-5 w-5"></i>
                    </span>
                    <p class="text-sm leading-6 text-slate-500">
                        Tautan verifikasi sudah kami kirim ke email kamu. Buka email tersebut dan klik tautannya untuk mengaktifkan akun.
                    </p>
                </div>
            </div>

            @if (session('status') === 'verification-link-sent')
                <div class="mt-4 rounded-2xl border border-emerald-200/70 bg-emerald-50/70 px-4 py-3 text-sm font-semibold text-emerald-700">
                    Tautan verifikasi baru berhasil dikirim ke alamat email kamu.
                </div>
            @endif

            <div class="mt-7 flex flex-wrap items-center justify-between gap-3">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn-primary">
                        <i data-lucide="send" class="h-4 w-4"></i>
                        Kirim ulang email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-soft text-sm">Keluar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
