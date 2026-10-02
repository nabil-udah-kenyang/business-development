<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = collect(['starts_at', 'ends_at'])
            ->filter(fn (string $column) => Schema::hasColumn('promoted_listings', $column))
            ->values()
            ->all();

        if ($columns !== []) {
            Schema::table('promoted_listings', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }

    public function down(): void
    {
        $columns = collect(['starts_at', 'ends_at'])
            ->reject(fn (string $column) => Schema::hasColumn('promoted_listings', $column))
            ->values()
            ->all();

        if ($columns !== []) {
            Schema::table('promoted_listings', function (Blueprint $table) use ($columns) {
                foreach ($columns as $column) {
                    $table->timestamp($column)->nullable();
                }
            });
        }
    }
};
