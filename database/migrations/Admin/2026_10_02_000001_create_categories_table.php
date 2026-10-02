<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();

        DB::table('categories')->insert([
            ['name' => 'Makanan', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Minuman', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Fashion', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Elektronik', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Buku', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Rumah', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kerajinan', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Jasa', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Lainnya', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
