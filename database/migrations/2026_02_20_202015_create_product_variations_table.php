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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('type', 50)->comment('Size, Length, Wattage, etc.'); // Variation type
            $table->string('name')->comment('e.g., 1 Meter, 100W, Large'); // Variation name/value
            $table->string('sku')->nullable()->unique(); // Optional unique SKU for variation
            $table->decimal('price', 10, 2); // Price for this variation
            $table->integer('stock_quantity')->default(0); // Stock for this variation
            $table->boolean('is_active')->default(true); // Enable/disable variation
            $table->integer('sort_order')->default(0); // Display order
            $table->timestamps();
            
            // Index for faster queries
            $table->index(['product_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
