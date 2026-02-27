<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add new contact fields for solar installations and product orders
        $settings = [
            [
                'key' => 'solar_contact_whatsapp',
                'value' => '+92 311 6745016',
                'description' => 'WhatsApp number for solar installations and brand sponsorships',
                'type' => 'string'
            ],
            [
                'key' => 'solar_contact_email',
                'value' => 'aj.electricwah@gmail.com',
                'description' => 'Email address for solar installations and brand sponsorships',
                'type' => 'string'
            ],
            [
                'key' => 'orders_contact_whatsapp',
                'value' => '+92 331 5346889',
                'description' => 'WhatsApp number for product orders only',
                'type' => 'string'
            ],
            [
                'key' => 'orders_contact_email',
                'value' => 'sales@ajelectric.es',
                'description' => 'Email address for product orders only',
                'type' => 'string'
            ],
            [
                'key' => 'business_location',
                'value' => 'Wah Cantt, Pakistan',
                'description' => 'Business location address',
                'type' => 'string'
            ]
        ];

        foreach ($settings as $setting) {
            $setting['created_at'] = now();
            $setting['updated_at'] = now();
            DB::table('settings')->insertOrIgnore($setting);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $keys = [
            'solar_contact_whatsapp',
            'solar_contact_email',
            'orders_contact_whatsapp',
            'orders_contact_email',
            'business_location'
        ];

        DB::table('settings')->whereIn('key', $keys)->delete();
    }
};
