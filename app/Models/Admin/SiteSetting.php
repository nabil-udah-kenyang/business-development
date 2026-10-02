<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'platform_name',
        'platform_short_name',
        'platform_description',
        'platform_logo',
        'team_photo',
        'social_instagram',
        'social_tiktok',
        'social_facebook',
        'social_youtube',
        'contact_whatsapp',
        'contact_email',
        'umkm_upload_fee',
        'preloved_upload_fee',
        'promotion_fee',
    ];

    protected function casts(): array
    {
        return [
            'umkm_upload_fee' => 'integer',
            'preloved_upload_fee' => 'integer',
            'promotion_fee' => 'integer',
        ];
    }
}
