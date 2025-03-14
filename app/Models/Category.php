<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',      // The UUID
        'name',      // The name of the category
        'description' // An optional description of the category
    ];

    // Specify the primary key as 'uuid'
    protected $primaryKey = 'uuid';

    // Disable auto-incrementing
    public $incrementing = false;

    // Set the primary key type to string (to accept a UUID)
    protected $keyType = 'string';

    /**
     * Automatically generate a UUID for the uuid attribute.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = (string) Str::uuid(); // Use the Laravel helper to generate a UUID
            }
        });
    }

    /**
     * Optional: Add any relationships if needed in the future.
     */
}
