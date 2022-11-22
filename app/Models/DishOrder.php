<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DishOrder extends Pivot
{
    use HasFactory;

    protected $table = "dish_orders";
    protected $fillable = [
        'order_id',
        'price',
        'name',
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
