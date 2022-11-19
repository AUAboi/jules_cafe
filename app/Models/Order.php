<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Intervention\Image\Exception\NotFoundException;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_no',
        'table_no',
        'note',
        'status'
    ];


    public function getRouteKeyName()
    {
        return 'order_no';
    }


    public function getOrderTypeAttribute()
    {
        return $this->table_no ? "Dine-in, Table " . $this->table_no : "Take away";
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('order_no', 'like', '%' . $search . '%');
        })->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        });
    }

    public function getTotalPriceAttribute()
    {
        $dishes = $this->dishes;
        $total = 0;
        foreach ($dishes as $dish) {
            $total += $dish->pivot->price * $dish->pivot->quantity;
        }
        return $total;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dishes()
    {

        return $this->belongsToMany(Dish::class, 'dish_orders')->using(DishOrder::class)->withPivot('price', 'quantity');
    }
}
