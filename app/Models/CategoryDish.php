<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryDish extends Model
{
    use HasFactory;

    protected $table = "category_dishes";

    protected $fillable = [
        'dish_id',
        'category_id'
    ];
}
