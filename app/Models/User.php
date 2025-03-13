<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',         // User's name
        'username',     // Unique login/username
        'password',     // User's hashed password
        'role',         // Role: "Администратор" or "Официант"
        'is_blocked',   // Determines if the user is blocked
        'login_attempts', // Tracks invalid login attempts
        'last_login',   // Timestamp of the user's last login
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',        // The password is hidden in serialized output
        'remember_token',  // Hidden "remember me" token
    ];

    /**
     * Attribute type casting.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'last_login' => 'datetime',    // Cast last_login to a date/time object
            'is_blocked' => 'boolean',    // Cast is_blocked to boolean
            'login_attempts' => 'integer', // Cast login_attempts to integer
        ];
    }

    /** User role methods **/

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'Администратор';
    }

    /**
     * Check if the user is a waiter.
     *
     * @return bool
     */
    public function isWaiter(): bool
    {
        return $this->role === 'Официант';
    }

    /** Account-related methods **/

    /**
     * Block the user by setting 'is_blocked' to true.
     */
    public function block(): void
    {
        $this->update(['is_blocked' => true]);
    }

    /**
     * Increment the login attempts counter.
     */
    public function incrementLoginAttempts(): void
    {
        $this->increment('login_attempts');
    }

    /**
     * Reset the login attempts counter back to 0.
     */
    public function resetLoginAttempts(): void
    {
        $this->update(['login_attempts' => 0]);
    }
}
