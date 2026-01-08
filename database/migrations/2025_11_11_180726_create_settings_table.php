<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, boolean, integer, json
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'site_name',
                'value' => 'AJ Electric',
                'type' => 'string',
                'description' => 'Website name displayed in header and emails',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'site_email',
                'value' => 'admin@ajelectric.com',
                'type' => 'string',
                'description' => 'Primary contact email address',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'site_phone',
                'value' => '+92-300-1234567',
                'type' => 'string',
                'description' => 'Primary contact phone number',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'currency',
                'value' => 'PKR',
                'type' => 'string',
                'description' => 'Default currency code',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'currency_symbol',
                'value' => 'Rs.',
                'type' => 'string',
                'description' => 'Currency symbol for display',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'items_per_page',
                'value' => '25',
                'type' => 'integer',
                'description' => 'Number of items to display per page',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'require_email_verification',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Require email verification for new accounts',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
