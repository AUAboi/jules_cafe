<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderPlaced;
use Illuminate\Support\Facades\DB;

class CreateUserOrder
{

  public function handle(User $user, array $data)
  {
    $order = DB::transaction(function () use ($user, $data) {
      $order = $user->orders()->create([
        'table_no' => $data['table_no'],
        'note' => $data['note'],
        'status' => 'pending'
      ]);

      $generateOrderNumber = new GenerateOrderNumber();
      $addUserCartDishesToOrder = new AddUserCartDishesToOrder();

      $order->order_no = $generateOrderNumber->handle($user, $order);
      $order->save();

      $addUserCartDishesToOrder->handle($user, $order);


      \Cart::clear();

      return $order;
    });

    $user->notify(new OrderPlaced($order));
    return $order;
  }
}
