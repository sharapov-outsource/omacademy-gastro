<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',        // The UUID
        'name',        // Dish name
        'category_id', // Foreign key for Category model
        'price',       // Price in rubles
        'description', // Dish description
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
                $model->uuid = (string) Str::uuid(); // Automatically assign UUID
            }
        });
    }

    /**
     * Define the relationship with the Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'uuid'); // Match the foreign key with the new primary key (uuid)
    }
}
