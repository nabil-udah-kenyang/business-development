<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (! $request->user()->hasVerifiedEmail()) {
            $intendedUrl = $request->session()->pull('url.intended');
            $intendedPath = $intendedUrl ? parse_url($intendedUrl, PHP_URL_PATH) : null;

            if ($intendedPath && str_starts_with($intendedPath, '/verify-email/')) {
                return redirect()->to($intendedUrl);
            }

            return redirect()->route('verification.notice');
        }

        return match ($request->user()->role ?? 'seller') {
            'preloved' => redirect()->route('preloved-user.dashboard'),
            'superadmin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('seller.dashboard'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
