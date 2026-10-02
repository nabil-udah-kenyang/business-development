<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('store_id')->nullable()->constrained('stores')->nullOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default('product');
            $table->string('category')->nullable();
            $table->unsignedBigInteger('price')->default(0);
            $table->text('description')->nullable();
            $table->text('specifications')->nullable();
            $table->string('location')->nullable();
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->string('status')->default('draft');
            $table->unsignedInteger('views')->default(0);
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
