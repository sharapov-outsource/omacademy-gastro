<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('uuid')->primary(); // Use UUID as the primary key
            $table->string('name'); // Category name
            $table->text('description')->nullable(); // Optional description
            $table->timestamps(); // Created & Updated timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
