@extends('layouts.dashboard')

@section('title', 'Profil Preloved')

@section('content')
    <div><span class="eyebrow">Preloved space</span><h1 class="mt-2 text-3xl font-bold">Profil saya</h1></div>
    <div class="mt-8 grid max-w-5xl gap-5 lg:grid-cols-2">
        <form method="POST" action="{{ route('preloved-user.profile.update') }}" class="soft-card grid gap-5 p-5 sm:p-7">
            @csrf
            @method('PATCH')
            <div class="flex items-center gap-4"><span class="grid h-16 w-16 place-items-center rounded-2xl bg-violet-100 text-xl font-bold text-violet-700">{{ $profileInitial }}</span><div><strong class="block">{{ $user->name }}</strong><span class="text-sm text-slate-500">{{ $user->email }}</span></div></div>
            <div class="grid gap-5 sm:grid-cols-2">
                <label class="text-sm font-bold">Nama lengkap<input name="name" class="field mt-2" value="{{ old('name', $user->name) }}" required></label>
                <label class="text-sm font-bold">Email<input name="email" type="email" class="field mt-2" value="{{ old('email', $user->email) }}" required></label>
                <label class="text-sm font-bold sm:col-span-2">Password saat ini <span class="font-normal text-slate-400">(wajib jika mengganti email)</span><input name="current_password" type="password" class="field mt-2" autocomplete="current-password">@error('current_password')<span class="mt-1 block text-xs font-medium text-red-600">{{ $message }}</span>@enderror</label>
                <label class="text-sm font-bold">WhatsApp<input name="whatsapp" class="field mt-2" value="{{ old('whatsapp', $user->whatsapp) }}" placeholder="08xx-xxxx-xxxx"></label>
                <label class="text-sm font-bold">Lokasi<input name="location" class="field mt-2" value="{{ old('location', $user->location) }}" placeholder="Medan"></label>
            </div>
            <label class="text-sm font-bold">Bio<textarea name="bio" class="field mt-2 min-h-24" placeholder="Ceritakan tentang kamu">{{ old('bio', $user->bio) }}</textarea></label>
            <button type="submit" class="btn-primary h-fit w-fit self-start !rounded-xl !px-4 !py-2.5 text-sm">Simpan profil</button>
        </form>

        <form method="POST" action="{{ route('password.update') }}" class="soft-card grid gap-5 p-5 sm:p-7">
            @csrf
            @method('PUT')
            <div class="flex items-center gap-4"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-slate-800 text-white"><i data-lucide="key-round" class="h-6 w-6"></i></span><div><h2 class="text-lg font-bold">Kelola akun</h2><p class="mt-1 text-sm text-slate-500">Ubah password akun preloved.</p></div></div>
            <label class="text-sm font-bold">Password saat ini<input name="current_password" type="password" class="field mt-2" required autocomplete="current-password">@error('current_password', 'updatePassword')<span class="mt-1 block text-xs font-medium text-red-600">{{ $message }}</span>@enderror</label>
            <label class="text-sm font-bold">Password baru<input name="password" type="password" class="field mt-2" required autocomplete="new-password"></label>
            <label class="text-sm font-bold">Konfirmasi password baru<input name="password_confirmation" type="password" class="field mt-2" required autocomplete="new-password"></label>
            <button type="submit" class="btn-primary w-fit">Simpan password</button>
        </form>
    </div>
@endsection
