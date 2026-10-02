@extends('layouts.admin')

@section('title', 'Kelola Seller')

@section('content')
    <div>
        <span class="eyebrow">People control</span>
        <h1 class="mt-2 text-3xl font-bold">Seller & pengguna</h1>
        <p class="mt-2 text-sm text-slate-500">Daftar pengguna terdaftar di platform.</p>
    </div>

    <div class="soft-card mt-8 overflow-x-auto">
        <table class="admin-table min-w-[650px] w-full">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Peran</th>
                    <th>Produk</th>
                    <th>Gabung</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->product_count }}</td>
                        <td>{{ $user->created_at?->format('d M Y') }}</td>
                        <td><span class="chip chip-purple">Aktif</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-sm text-slate-500">Belum ada seller atau pengguna
                            preloved.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($users->hasPages())
        <div class="mt-6">{{ $users->links() }}</div>
    @endif
@endsection
