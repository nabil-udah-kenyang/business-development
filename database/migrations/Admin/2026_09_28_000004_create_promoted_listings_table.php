<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promoted_listings', function (Blueprint $table) {
            $table->id();
            $table->string('catalog_type');
            $table->string('catalog_slug');
            $table->string('name');
            $table->string('price');
            $table->string('seller');
            $table->string('category');
            $table->string('location')->default('Medan');
            $table->string('views')->default('0');
            $table->string('listing_type')->nullable();
            $table->string('condition')->nullable();
            $table->text('image');
            $table->unsignedInteger('fee')->default(5000);
            $table->unsignedInteger('position')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['catalog_type', 'catalog_slug']);
            $table->index(['catalog_type', 'is_active', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promoted_listings');
    }
};
