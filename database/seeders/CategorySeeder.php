<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Circuit Breakers', 'slug' => 'circuit-breakers', 'description' => 'MCB, DC breakers and other circuit protection devices'],
            ['name' => 'Solar Equipment', 'slug' => 'solar-equipment', 'description' => 'Solar panels, inverters, and accessories'],
            ['name' => 'Smart Switches', 'slug' => 'smart-switches', 'description' => 'WiFi enabled smart home automation devices'],
            ['name' => 'Distribution Boxes', 'slug' => 'distribution-boxes', 'description' => 'DB boxes and electrical distribution equipment'],
            ['name' => 'Changeover Switches', 'slug' => 'changeover-switches', 'description' => 'Manual and automatic changeover switches'],
            ['name' => 'Voltage Protectors', 'slug' => 'voltage-protectors', 'description' => 'Over/under voltage protection devices'],
            ['name' => 'Electrical Tools', 'slug' => 'electrical-tools', 'description' => 'Professional electrical tools and equipment'],
            ['name' => 'Cables & Accessories', 'slug' => 'cables-accessories', 'description' => 'Electrical cables, tape, and accessories'],
        ];

        foreach ($categories as $index => $category) {
            \App\Models\Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['description'],
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
