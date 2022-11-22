<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DishOrder extends Model
{
    use HasFactory;

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

    public function getFormattedPriceAttribute()
    {
        return money($this->price, 'MYR', true)->formatWithoutZeroes();
    }
}
