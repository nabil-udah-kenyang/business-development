<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $user = $request->user();
        $dashboardRoute = match ($user->role ?? 'seller') {
            'preloved' => route('preloved-user.dashboard', absolute: false),
            'superadmin' => route('admin.dashboard', absolute: false),
            default => route('seller.dashboard', absolute: false),
        };

        if ($request->user()->hasVerifiedEmail()) {
            $request->session()->forget('url.intended');

            return redirect()->to($dashboardRoute.'?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        $request->session()->forget('url.intended');

        return redirect()->to($dashboardRoute.'?verified=1');
    }
}
