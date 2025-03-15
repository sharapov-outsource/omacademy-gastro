<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('uuid')->primary(); // Primary key
            $table->uuid('order_id'); // Order reference
            $table->uuid('menu_id'); // Menu item reference
            $table->integer('quantity')->default(1); // Quantity
            $table->foreign('order_id')->references('uuid')->on('orders')->onDelete('cascade');
            $table->foreign('menu_id')->references('uuid')->on('menus')->onDelete('cascade'); // Corrected table name to `menus`
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
