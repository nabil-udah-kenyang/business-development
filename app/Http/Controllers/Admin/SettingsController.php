<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SiteSetting;
use App\Services\ImageWebpService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::first() ?? new SiteSetting([
            'platform_name' => 'Business Development HMPS MI',
            'platform_short_name' => 'HMPS MI',
            'platform_description' => 'Ruang tumbuh untuk karya, produk, dan usaha mahasiswa POLMED.',
            'umkm_upload_fee' => 10000,
            'preloved_upload_fee' => 5000,
            'promotion_fee' => 5000,
        ]);

        $teamPhotoUrl = $settings->team_photo
            ? asset($settings->team_photo)
            : asset('image/divisi_bd.jpeg');
        $platformLogoUrl = $settings->platform_logo
            ? asset($settings->platform_logo)
            : null;

        return view('admin.settings', compact(
            'settings',
            'teamPhotoUrl',
            'platformLogoUrl'
        ));
    }

    public function update(Request $request, ImageWebpService $imageWebp)
    {
        $validated = $request->validate([
            'platform_name' => ['required', 'string', 'max:255'],
            'platform_short_name' => ['required', 'string', 'max:100'],
            'platform_description' => ['nullable', 'string'],
            'platform_logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'team_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_tiktok' => ['nullable', 'url', 'max:255'],
            'social_facebook' => ['nullable', 'url', 'max:255'],
            'social_youtube' => ['nullable', 'url', 'max:255'],
            'contact_whatsapp' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'umkm_upload_fee' => ['required', 'integer', 'min:0'],
            'preloved_upload_fee' => ['required', 'integer', 'min:0'],
            'promotion_fee' => ['required', 'integer', 'min:0'],
        ]);

        $settings = SiteSetting::firstOrNew();
        $settings->fill([
            'platform_name' => $validated['platform_name'],
            'platform_short_name' => $validated['platform_short_name'],
            'platform_description' => $validated['platform_description'] ?? null,
            'social_instagram' => $validated['social_instagram'] ?? null,
            'social_tiktok' => $validated['social_tiktok'] ?? null,
            'social_facebook' => $validated['social_facebook'] ?? null,
            'social_youtube' => $validated['social_youtube'] ?? null,
            'contact_whatsapp' => $validated['contact_whatsapp'] ?? null,
            'contact_email' => $validated['contact_email'] ?? null,
            'umkm_upload_fee' => $validated['umkm_upload_fee'],
            'preloved_upload_fee' => $validated['preloved_upload_fee'],
            'promotion_fee' => $validated['promotion_fee'],
        ]);

        $oldLogo = $settings->platform_logo;
        $oldTeamPhoto = $settings->team_photo;

        if ($request->hasFile('platform_logo')) {
            $file = $request->file('platform_logo');
            $settings->platform_logo = $imageWebp->store($file, 'platform-logo');
        }

        if ($request->hasFile('team_photo')) {
            $file = $request->file('team_photo');
            $settings->team_photo = $imageWebp->store($file, 'team-bd');
        }

        $settings->save();

        if ($oldLogo
            && $oldLogo !== $settings->platform_logo
            && str_starts_with($oldLogo, 'image/platform-logo-')) {
            $absolutePath = public_path($oldLogo);

            if (is_file($absolutePath)) {
                unlink($absolutePath);
            }
        }

        if ($oldTeamPhoto
            && $oldTeamPhoto !== $settings->team_photo
            && str_starts_with($oldTeamPhoto, 'image/team-bd-')) {
            $absolutePath = public_path($oldTeamPhoto);

            if (is_file($absolutePath)) {
                unlink($absolutePath);
            }
        }

        return back()->with('status', 'Pengaturan platform berhasil diperbarui.');
    }

}
