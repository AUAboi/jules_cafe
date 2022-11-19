<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DishOrder extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_id',
        'price',
        'quantity'
    ];
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($price) =>  $price / 100,
            set: fn ($price) => $price * 100,
        );
    }
}
