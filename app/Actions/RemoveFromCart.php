<?php

namespace App\Actions;

use App\Models\Dish;
use App\Models\User;
use Darryldecode\Cart\Cart;

class RemoveFromCart
{
  public function handle(User $user, Dish $dish)
  {
    \Cart::session($user->id);

    $cartItem = \Cart::get($dish->id);

    if ($cartItem->quantity > 1) {
      \Cart::update($dish->id, array(
        'quantity' => -1,
      ));
    } else {
      \Cart::remove($dish->id);
    }
  }
}
