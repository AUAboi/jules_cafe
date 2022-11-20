<?php

namespace App\Actions;

use App\Models\Dish;
use App\Models\Order;
use App\Models\User;

class AddUserCartDishesToOrder
{

  public function handle(User $user, Order $order)
  {

    \Cart::session($user->id);

    $cart = \Cart::getContent();
    foreach ($cart as $key => $item) {
      $dish = Dish::find($item->id);
      if (!$dish) {
        \Cart::remove($item->id);
        unset($row[$key]);
      }
      $order->dishes()->attach($item->id, ['quantity' => $item->quantity, 'price' => $item->price, 'name' => $item->name,]);
    }
  }
}
