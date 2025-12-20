<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $categories = \App\Models\Category::all()->keyBy('slug');

        $products = [
            [
                'name' => 'TOMZN DC Fuse Holder With Lamp 1000V PV safety',
                'slug' => 'tomzn-dc-fuse-holder-with-lamp-1000v-pv-safety',
                'short_description' => 'Professional DC fuse holder with safety lamp for solar applications',
                'description' => 'High quality DC fuse holder designed for solar PV systems with built-in safety indicator lamp. Rated for 1000V DC applications.',
                'sku' => 'TOMZN-FUSE-1000V',
                'price' => 900.00,
                'sale_price' => 850.00,
                'stock_quantity' => 50,
                'category_id' => $categories['solar-equipment']->id,
                'is_featured' => true,
                'is_active' => true,
                'status' => 'published',
            ],
            [
                'name' => '6KW Hybrid Solar Inverter with 8000W Solar',
                'slug' => '6kw-hybrid-solar-inverter-with-8000w-solar',
                'short_description' => 'High capacity hybrid solar inverter with MPPT charge controller',
                'description' => 'Professional grade 6KW hybrid solar inverter capable of handling 8000W solar input with advanced MPPT technology.',
                'sku' => 'SOLAR-INV-6KW',
                'price' => 110000.00,
                'stock_quantity' => 10,
                'category_id' => $categories['solar-equipment']->id,
                'is_featured' => true,
                'is_active' => true,
                'status' => 'published',
            ],
            [
                'name' => 'TOMZN 30A NO/NC Weekly 7 Days Programmable Digital TIME SWITCH',
                'slug' => 'tomzn-30a-no-nc-weekly-7-days-programmable-digital-time-switch',
                'short_description' => '30A programmable timer switch with weekly scheduling',
                'description' => 'Advanced digital timer switch with 30A capacity, supports both NO/NC configuration with 7-day weekly programming.',
                'sku' => 'TOMZN-TIMER-30A',
                'price' => 1950.00,
                'sale_price' => 1750.00,
                'stock_quantity' => 25,
                'category_id' => $categories['smart-switches']->id,
                'is_featured' => true,
                'is_active' => true,
                'status' => 'published',
            ],
            [
                'name' => 'Tomzn AC circuit breaker MCB C type',
                'slug' => 'tomzn-ac-circuit-breaker-mcb-c-type',
                'short_description' => 'Single pole AC circuit breaker MCB C-type',
                'description' => 'Professional grade AC circuit breaker with C-type trip characteristic for commercial and residential applications.',
                'sku' => 'TOMZN-MCB-C',
                'price' => 580.00,
                'sale_price' => 550.00,
                'stock_quantity' => 100,
                'category_id' => $categories['circuit-breakers']->id,
                'is_active' => true,
                'status' => 'published',
            ],
            [
                'name' => 'Voltage Protector Socket for LED and Refrigerator',
                'slug' => 'voltage-protector-socket-for-led-and-refrigerator',
                'short_description' => 'Smart voltage protector socket for appliance protection',
                'description' => 'Intelligent voltage protector socket designed to protect LED lights and refrigerators from voltage fluctuations.',
                'sku' => 'VP-SOCKET-LED',
                'price' => 1700.00,
                'sale_price' => 1400.00,
                'stock_quantity' => 30,
                'category_id' => $categories['voltage-protectors']->id,
                'is_active' => true,
                'status' => 'published',
            ],
            [
                'name' => 'WiFi Smart Switch 10A Mini DIY Smart Life APP',
                'slug' => 'wifi-smart-switch-10a-mini-diy-smart-life-app',
                'short_description' => 'Compact WiFi smart switch with app control',
                'description' => 'Compact 10A WiFi smart switch compatible with Smart Life app for remote control and automation.',
                'sku' => 'WIFI-SW-10A',
                'price' => 1500.00,
                'stock_quantity' => 40,
                'category_id' => $categories['smart-switches']->id,
                'is_featured' => true,
                'is_active' => true,
                'status' => 'published',
            ],
            [
                'name' => 'DB Distribution Boxes 4Way to 12 Way',
                'slug' => 'db-distribution-boxes-4way-to-12-way',
                'short_description' => 'Professional distribution boxes in various configurations',
                'description' => 'High quality distribution boxes available in 4-way to 12-way configurations for residential and commercial use.',
                'sku' => 'DB-BOX-VAR',
                'price' => 1500.00,
                'stock_quantity' => 60,
                'category_id' => $categories['distribution-boxes']->id,
                'is_active' => true,
                'status' => 'published',
            ],
            [
                'name' => 'Crimping Plier HSC8-4 Self-adjustable Crimping Tools',
                'slug' => 'crimping-plier-hsc8-4-self-adjustable-crimping-tools',
                'short_description' => 'Professional self-adjustable crimping pliers',
                'description' => 'High quality self-adjustable crimping pliers HSC8-4 for 0.25-10 mm² wire terminals.',
                'sku' => 'CRIMP-HSC8-4',
                'price' => 2400.00,
                'stock_quantity' => 20,
                'category_id' => $categories['electrical-tools']->id,
                'is_active' => true,
                'status' => 'published',
            ]
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
