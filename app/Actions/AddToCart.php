<?php

namespace App\Actions;

use App\Models\Dish;
use App\Models\User;
use Darryldecode\Cart\Cart;

class AddToCart
{
  public function handle(User $user, Dish $dish)
  {
    \Cart::session($user->id)->add(array(
      'id' => $dish->id, // unique row ID
      'name' => $dish->name,
      'price' => $dish->price,
      'quantity' => 1,
      'attributes' => array(),
      'associatedModel' => $dish
    ));
  }
}
