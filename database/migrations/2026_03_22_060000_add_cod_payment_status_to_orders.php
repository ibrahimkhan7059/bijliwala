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
        Schema::table('orders', function (Blueprint $table) {
            // Change payment_status enum to include COD payment statuses
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded', 'pending_cod', 'paid_cod'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert back to original enum values
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->change();
        });
    }
};
