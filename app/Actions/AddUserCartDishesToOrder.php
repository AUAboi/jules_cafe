<?php

namespace App\Actions;

use App\Models\Dish;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddUserCartDishesToOrder
{

  public function handle(User $user, Order $order)
  {

    \Cart::session($user->id);

    $cart = \Cart::getContent();

    foreach ($cart as $key => $item) {
      $dish = Dish::find($item->id);

      if (!$dish) throw new ModelNotFoundException;
      $order->dishes()->create(['quantity' => $item->quantity, 'price' => $dish->price, 'name' => $dish->name,]);
    }
  }
}
