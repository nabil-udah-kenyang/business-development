<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // MarketplaceSeeder berisi data demo lokal dan sengaja tidak dipublikasikan.
        if (class_exists(MarketplaceSeeder::class)) {
            $this->call(MarketplaceSeeder::class);
        }
    }
}
