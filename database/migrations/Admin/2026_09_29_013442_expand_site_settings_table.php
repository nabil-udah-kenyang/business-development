<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $addColumn = function (string $name, \Closure $definition): void {
            if (! Schema::hasColumn('site_settings', $name)) {
                Schema::table('site_settings', $definition);
            }
        };

        $addColumn('platform_name', fn (Blueprint $table) => $table->string('platform_name')->nullable());
        $addColumn('platform_short_name', fn (Blueprint $table) => $table->string('platform_short_name')->nullable());
        $addColumn('platform_description', fn (Blueprint $table) => $table->text('platform_description')->nullable());
        $addColumn('platform_logo', fn (Blueprint $table) => $table->string('platform_logo')->nullable());
        $addColumn('team_photo', fn (Blueprint $table) => $table->string('team_photo')->nullable());
        $addColumn('social_instagram', fn (Blueprint $table) => $table->string('social_instagram')->nullable());
        $addColumn('social_tiktok', fn (Blueprint $table) => $table->string('social_tiktok')->nullable());
        $addColumn('social_facebook', fn (Blueprint $table) => $table->string('social_facebook')->nullable());
        $addColumn('social_youtube', fn (Blueprint $table) => $table->string('social_youtube')->nullable());
        $addColumn('contact_whatsapp', fn (Blueprint $table) => $table->string('contact_whatsapp')->nullable());
        $addColumn('contact_email', fn (Blueprint $table) => $table->string('contact_email')->nullable());
        $addColumn('umkm_upload_fee', fn (Blueprint $table) => $table->unsignedInteger('umkm_upload_fee')->nullable());
        $addColumn('preloved_upload_fee', fn (Blueprint $table) => $table->unsignedInteger('preloved_upload_fee')->nullable());
        $addColumn('promotion_fee', fn (Blueprint $table) => $table->unsignedInteger('promotion_fee')->nullable());

        $legacyTable = Schema::hasColumn('site_settings', 'key')
            && Schema::hasColumn('site_settings', 'value');

        if (! $legacyTable) {
            return;
        }

        $legacyValues = DB::table('site_settings')->pluck('value', 'key')->all();
        $record = DB::table('site_settings')->orderBy('id')->first();
        $recordId = $record?->id ?? DB::table('site_settings')->insertGetId([
            // The old key/value schema requires these fields before they are
            // removed at the end of this compatibility migration.
            'key' => '__migrated_site_settings__',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mapping = [
            'platform_name' => 'platform_name',
            'platform_short_name' => 'platform_short_name',
            'platform_description' => 'platform_description',
            'platform_logo' => 'platform_logo',
            'team_photo' => 'team_photo',
            'social_instagram' => 'social_instagram',
            'social_tiktok' => 'social_tiktok',
            'social_facebook' => 'social_facebook',
            'social_youtube' => 'social_youtube',
            'contact_whatsapp' => 'contact_whatsapp',
            'contact_email' => 'contact_email',
            'umkm_upload_fee' => 'umkm_upload_fee',
            'preloved_upload_fee' => 'preloved_upload_fee',
            'promotion_fee' => 'promotion_fee',
        ];

        $updates = [
            'platform_name' => 'Business Development HMPS MI',
            'platform_short_name' => 'HMPS MI',
            'platform_description' => 'Ruang tumbuh untuk karya, produk, dan usaha mahasiswa POLMED.',
            'umkm_upload_fee' => 10000,
            'preloved_upload_fee' => 5000,
            'promotion_fee' => 5000,
        ];
        foreach ($mapping as $legacyKey => $column) {
            if (array_key_exists($legacyKey, $legacyValues)) {
                $updates[$column] = $legacyValues[$legacyKey];
            }
        }

        if ($updates !== []) {
            DB::table('site_settings')->where('id', $recordId)->update([
                ...$updates,
                'updated_at' => now(),
            ]);
        }

        DB::table('site_settings')->where('id', '!=', $recordId)->delete();

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['key', 'value']);
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('site_settings') || Schema::hasColumn('site_settings', 'key')) {
            return;
        }

        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('key')->nullable()->unique();
            $table->text('value')->nullable();
        });
    }
};
