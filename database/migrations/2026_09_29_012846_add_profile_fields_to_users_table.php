<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('whatsapp')->nullable()->after('email');
            $table->string('location')->nullable()->after('whatsapp');
            $table->text('bio')->nullable()->after('location');
            $table->string('avatar')->nullable()->after('bio');
            $table->string('status')->default('active')->index()->after('avatar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropColumn(['whatsapp', 'location', 'bio', 'avatar', 'status']);
        });
    }
};
