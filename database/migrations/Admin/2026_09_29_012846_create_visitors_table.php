<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_key', 64);
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 512)->nullable();
            $table->date('visit_date')->index();
            $table->unsignedInteger('hits')->default(1);
            $table->timestamps();

            $table->unique(['visitor_key', 'visit_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
