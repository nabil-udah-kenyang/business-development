@extends('layouts.admin')
@section('title', 'Profil Admin')
@section('content')
<div><span class="eyebrow">Account</span><h1 class="mt-2 text-3xl font-bold">Profil superadmin</h1><p class="mt-2 text-sm text-slate-500">Kelola identitas dan keamanan akun administrator.</p></div>

<div class="soft-card mt-8 max-w-5xl p-5 sm:p-7">
    <div class="flex items-center gap-4"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-violet-600 text-white"><i data-lucide="shield-check" class="h-6 w-6"></i></span><div><h2 class="text-lg font-bold">Pengaturan akun</h2><p class="mt-1 text-sm text-slate-500">Kelola identitas dan keamanan akun administrator.</p></div></div>
    <form method="POST" action="{{ route('admin.profile.update') }}" class="mt-7 grid gap-8">
        @csrf
        @method('PATCH')
        <div class="grid gap-8 lg:grid-cols-2">
            <div class="grid gap-5">
                <label class="text-sm font-bold">Nama
                    <input name="name" class="field mt-2" value="{{ old('name', $user->name) }}" required autocomplete="name">
                    @error('name')<span class="mt-1 block text-xs font-medium text-red-600">{{ $message }}</span>@enderror
                </label>
                <label class="text-sm font-bold">Email
                    <input name="email" type="email" class="field mt-2" value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @error('email')<span class="mt-1 block text-xs font-medium text-red-600">{{ $message }}</span>@enderror
                </label>
            </div>
            <div class="grid gap-5 border-t border-slate-200/70 pt-8 lg:border-l lg:border-t-0 lg:pl-8 lg:pt-0">
                <label class="text-sm font-bold">Password saat ini <span class="font-normal text-slate-400">(wajib jika ganti email atau password)</span>
                    <input name="current_password" type="password" class="field mt-2" autocomplete="current-password">
                    @error('current_password')<span class="mt-1 block text-xs font-medium text-red-600">{{ $message }}</span>@enderror
                </label>
                <label class="text-sm font-bold">Password baru <span class="font-normal text-slate-400">(opsional)</span>
                    <input name="password" type="password" class="field mt-2" autocomplete="new-password">
                    @error('password')<span class="mt-1 block text-xs font-medium text-red-600">{{ $message }}</span>@enderror
                </label>
                <label class="text-sm font-bold">Konfirmasi password baru
                    <input name="password_confirmation" type="password" class="field mt-2" autocomplete="new-password">
                    @error('password_confirmation')<span class="mt-1 block text-xs font-medium text-red-600">{{ $message }}</span>@enderror
                </label>
            </div>
        </div>
        <div class="flex items-center gap-3 border-t border-slate-200/70 pt-6"><button type="submit" class="btn-primary">Simpan perubahan</button><span class="text-xs text-slate-400">Password lama wajib benar jika email atau password diubah.</span></div>
    </form>
</div>
@endsection
