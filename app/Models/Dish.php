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

    protected $casts = [
        'active' => 'boolean',
    ];

    protected function price(): Attribute
    {
        //Smallest unit is stored in database, currency being ringgit we are storing sen
        //Setting back to ringgit on retrieval
        return Attribute::make(
            get: fn ($price) =>  $price / 100,
            set: fn ($price) => $price * 100,
        );
    }

    public function getFormattedPriceAttribute()
    {
        return 'RM ' . $this->price;
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->when($filters['category'] ?? null, function ($query, $category) {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->where('category_id', $category);
            });
        });
    }

    public function scopeActive($query)
    {
        $query->where('active', 1);
    }

    public function media()
    {
        return $this->hasOne(DishMedia::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_dishes');
    }
}
