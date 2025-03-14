<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid('uuid')->primary(); // Use UUID as primary key
            $table->string('name'); // Dish name
            $table->uuid('category_id'); // Foreign key referring to categories.uuid
            $table->decimal('price', 10, 2); // Price in rubles
            $table->text('description')->nullable(); // Optional description
            $table->timestamps(); // Created & Updated timestamps

            // Define the foreign key constraint for category_id
            $table->foreign('category_id')
                ->references('uuid') // Reference the categories.uuid column
                ->on('categories')
                ->onDelete('cascade'); // Automatically delete menus if the category is deleted
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus'); // Rollback for the table
    }
};
