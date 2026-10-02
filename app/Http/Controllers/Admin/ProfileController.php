<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('admin.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $emailChanged = strcasecmp((string) $request->input('email'), (string) $user->email) !== 0;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($request->user()->id),
            ],
            'current_password' => [
                'nullable',
                Rule::requiredIf(function () use ($request) {
                    return strcasecmp((string) $request->input('email'), (string) $request->user()->email) !== 0
                        || $request->filled('password');
                }),
                'current_password',
            ],
            'password' => ['nullable', Password::defaults(), 'confirmed'],
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if ($emailChanged) {
            $user->sendEmailVerificationNotification();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('status', 'Email berhasil diubah. Buka email baru untuk verifikasi, lalu masuk kembali dengan email dan password terbaru.');
        }

        return back()->with('status', 'Profil admin berhasil diperbarui.');
    }
}
