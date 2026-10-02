<?php

namespace App\Providers;

use App\Models\Admin\SiteSetting;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom([
            database_path('migrations/Admin'),
            database_path('migrations/Seller'),
            database_path('migrations/Preloved'),
        ]);

        View::composer(['layouts.admin', 'layouts.dashboard', 'admin.login', 'auth.*'], function ($view) {
            $view->with([
                'siteSettings' => SiteSetting::first(),
                'isPreloved' => request()->routeIs('preloved-user.*'),
            ]);
        });

        View::composer('layouts.public', function ($view) {
            $settings = SiteSetting::first();
            $dashboardRoute = auth()->check()
                ? match (auth()->user()->role ?? 'seller') {
                    'preloved' => 'preloved-user.dashboard',
                    'superadmin' => 'admin.dashboard',
                    default => 'seller.dashboard',
                }
                : null;
            $whatsappNumber = preg_replace('/\D+/', '', $settings?->contact_whatsapp ?? '');

            if (str_starts_with($whatsappNumber, '0')) {
                $whatsappNumber = '62'.substr($whatsappNumber, 1);
            }

            $footerData = [
                'socialLinks' => [
                    [
                        'label' => 'WhatsApp',
                        'icon' => 'fa-brands fa-whatsapp',
                        'url' => $whatsappNumber !== '' ? 'https://wa.me/'.$whatsappNumber : '#',
                        'target' => $whatsappNumber !== '' ? '_blank' : '_self',
                        'disabled' => false,
                    ],
                    [
                        'label' => 'Instagram',
                        'icon' => 'fa-brands fa-instagram',
                        'url' => $settings?->social_instagram ?: '#',
                        'target' => $settings?->social_instagram ? '_blank' : '_self',
                        'disabled' => false,
                    ],
                    [
                        'label' => 'TikTok',
                        'icon' => 'fa-brands fa-tiktok',
                        'url' => '#',
                        'target' => '_self',
                        'disabled' => true,
                    ],
                ],
                'contactLinks' => array_values(array_filter([
                    $settings?->social_facebook ? [
                        'label' => 'Facebook',
                        'url' => $settings->social_facebook,
                        'target' => '_blank',
                    ] : null,
                    $settings?->social_youtube ? [
                        'label' => 'YouTube',
                        'url' => $settings->social_youtube,
                        'target' => '_blank',
                    ] : null,
                    $settings?->contact_email ? [
                        'label' => $settings->contact_email,
                        'url' => 'mailto:'.$settings->contact_email,
                        'target' => '_self',
                    ] : null,
                ])),
            ];

            $view->with([
                'siteSettings' => $settings,
                'footerData' => $footerData,
                'headerDashboardRoute' => $dashboardRoute,
                'mobileDashboardRoute' => $dashboardRoute,
                'isPrelovedDashboard' => request()->routeIs('preloved-user.*'),
            ]);
        });

        View::composer('partials.flash-message', function ($view) {
            $errors = view()->shared('errors');
            $hasValidationErrors = $errors && $errors->any();
            $isFlashError = session()->has('error') || $hasValidationErrors;
            $flashMessage = session('error') ?? session('status');

            if ($hasValidationErrors) {
                $flashMessage = $errors->first();
            }

            $view->with(compact('hasValidationErrors', 'isFlashError', 'flashMessage'));
        });

        $branding = function (): array {
            $settings = SiteSetting::first();

            return [
                'settings' => $settings,
                'platformName' => $settings?->platform_name ?? 'Business Development HMPS MI',
                'platformShortName' => $settings?->platform_short_name ?? 'HMPS MI',
                'platformInitials' => strtoupper(substr($settings?->platform_short_name ?? 'HMPS MI', 0, 2)),
                'logoUrl' => $settings?->platform_logo ? asset($settings->platform_logo) : null,
            ];
        };

        VerifyEmail::toMailUsing(function ($notifiable, string $url) use ($branding): MailMessage {
            return (new MailMessage)
                ->subject('Verifikasi email · '.($branding()['platformShortName']))
                ->view('emails.verify-email', [
                    ...$branding(),
                    'actionUrl' => $url,
                    'notifiable' => $notifiable,
                ]);
        });

        ResetPassword::toMailUsing(function ($notifiable, string $token) use ($branding): MailMessage {
            $resetUrl = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Reset password · '.($branding()['platformShortName']))
                ->view('emails.reset-password', [
                    ...$branding(),
                    'actionUrl' => $resetUrl,
                    'notifiable' => $notifiable,
                    'expiresIn' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire'),
                ]);
        });
    }
}
