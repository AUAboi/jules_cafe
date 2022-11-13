<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'active',
    ];

    protected function price(): Attribute
    {
        //Smallest unit is stored in database, currency being ringgit we are storing sen
        //Setting back to ringgit on retrieval
        return Attribute::make(
            get: fn ($price) => $price / 100 . "rm",
            set: fn ($price) => $price * 100,
        );
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function media()
    {
        return $this->hasOne(DishMedia::class);
    }
}
