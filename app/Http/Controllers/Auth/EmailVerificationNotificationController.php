<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            $dashboardRoute = match ($request->user()->role ?? 'seller') {
                'preloved' => route('preloved-user.dashboard', absolute: false),
                'superadmin' => route('admin.dashboard', absolute: false),
                default => route('seller.dashboard', absolute: false),
            };

            return redirect()->to($dashboardRoute);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
