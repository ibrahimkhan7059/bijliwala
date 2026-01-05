<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@ajelectric.com',
            'password' => bcrypt('admin123'),
            'phone' => '0333-7449456',
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        \App\Models\User::create([
            'name' => 'Test Customer',
            'email' => 'customer@test.com',
            'password' => bcrypt('customer123'),
            'phone' => '0300-1234567',
            'role' => 'customer',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
