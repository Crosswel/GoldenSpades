<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Chamar o seeder do administrador
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}
