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
            // Drop foreign key constraint first
            $table->dropForeign(['user_id']);
            
            // Make user_id nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Re-add foreign key with nullable support (no cascade delete for guest orders)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the modified foreign key
            $table->dropForeign(['user_id']);
            
            // Make user_id not nullable again
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            
            // Re-add original foreign key with cascade delete
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
