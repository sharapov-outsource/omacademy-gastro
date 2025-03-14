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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // User's name
            $table->string('email')->unique(); // User's email (unique)
            $table->timestamp('email_verified_at')->nullable(); // Email verification timestamp (optional)
            $table->string('password'); // Hashed password
            $table->string('role')->default('waiter'); // User role (default is 'Waiter')
            $table->boolean('is_blocked')->default(false); // Indicates if the user is blocked
            $table->integer('login_attempts')->default(0); // Tracks invalid login attempts
            $table->dateTime('last_login')->nullable(); // Timestamp of the user's last successful login
            $table->rememberToken(); // Token for "remember me" sessions
            $table->timestamps(); // Created and updated timestamps
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Unique email for password reset
            $table->string('token'); // Token for password reset
            $table->timestamp('created_at')->nullable(); // Token creation timestamp
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Session ID (primary key)
            $table->foreignId('user_id')->nullable()->index(); // Optional foreign key to 'users' table
            $table->string('ip_address', 45)->nullable(); // User's IP address
            $table->text('user_agent')->nullable(); // Information on the device/browser
            $table->longText('payload'); // Session payload (data)
            $table->integer('last_activity')->index(); // Timestamp of the last activity
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
