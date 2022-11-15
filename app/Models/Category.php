<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active'
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('active');
    }

    public function media()
    {
        return $this->hasOne(CategoryMedia::class);
    }


    public function dishes()
    {
        return $this->belongsToMany(Dish::class);
    }
}
