<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request)
    {
        $dashboardRoute = match ($request->user()->role ?? 'seller') {
            'preloved' => route('preloved-user.dashboard', absolute: false),
            'superadmin' => route('admin.dashboard', absolute: false),
            default => route('seller.dashboard', absolute: false),
        };

        return $request->user()->hasVerifiedEmail()
                    ? redirect()->to($dashboardRoute)
                    : view('auth.verify-email');
    }
}
