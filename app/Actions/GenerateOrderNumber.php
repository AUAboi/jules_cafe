<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\User;
use DateTime;

class GenerateOrderNumber
{

  public function handle(User $user, Order $order)
  {
    $dt = new DateTime;
    return $dt->format('Ymd') . $user->id . $order->id;
  }
}
