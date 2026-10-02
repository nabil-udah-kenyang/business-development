<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('platform_name')->default('Business Development HMPS MI');
            $table->string('platform_short_name')->default('HMPS MI');
            $table->text('platform_description')->nullable();
            $table->string('platform_logo')->nullable();
            $table->string('team_photo')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_tiktok')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('contact_whatsapp')->nullable();
            $table->string('contact_email')->nullable();
            $table->unsignedInteger('umkm_upload_fee')->default(10000);
            $table->unsignedInteger('preloved_upload_fee')->default(5000);
            $table->unsignedInteger('promotion_fee')->default(5000);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
