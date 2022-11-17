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

    protected $casts = [
        'active' => 'boolean',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->active($filters['active']);
    }



    public function scopeActive($query, $active)
    {
        if (!is_null($active)) {
            $query->where('active', $active);
        }
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
