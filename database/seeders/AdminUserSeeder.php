<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Remove se já existir
        DB::table('users')->where('email', 'admin@goldspades.com')->delete();

        // Cria novo admin
        User::create([
             'name' => 'Admin',
            'email' => 'admin@goldspades.com',
            'password' => Hash::make('admin'),
            'usertype' => 0,
            'address' => '',
            'phone' => '',
            'email_verified_at' => now(),
        ]);


    }
}
