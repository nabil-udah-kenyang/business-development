<?php

namespace App\Http\Controllers\Preloved;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $profileInitial = strtoupper(substr($user->name, 0, 1));

        return view('preloved.profile', compact('user', 'profileInitial'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();
        $emailChanged = strcasecmp((string) $validated['email'], (string) $user->email) !== 0;
        unset($validated['current_password']);

        $user->fill($validated);

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($emailChanged) {
            $user->sendEmailVerificationNotification();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('status', 'Email berhasil diubah. Buka email baru untuk verifikasi, lalu masuk kembali dengan email dan password terbaru.');
        }

        return back()->with('status', 'Profil berhasil diperbarui.');
    }
}
