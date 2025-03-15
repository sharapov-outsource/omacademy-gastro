<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'order_id', 'menu_id', 'quantity'];

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = $model->uuid ?? Str::uuid();
        });
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'uuid');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'uuid');
    }
}
