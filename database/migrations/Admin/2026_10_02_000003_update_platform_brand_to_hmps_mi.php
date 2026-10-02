<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_settings')
            ->where('platform_name', 'Business Development POLMED')
            ->update(['platform_name' => 'Business Development HMPS MI']);

        DB::table('site_settings')
            ->where('platform_short_name', 'BD POLMED')
            ->update(['platform_short_name' => 'HMPS MI']);
    }

    public function down(): void
    {
        DB::table('site_settings')
            ->where('platform_name', 'Business Development HMPS MI')
            ->update(['platform_name' => 'Business Development POLMED']);

        DB::table('site_settings')
            ->where('platform_short_name', 'HMPS MI')
            ->update(['platform_short_name' => 'BD POLMED']);
    }
};
