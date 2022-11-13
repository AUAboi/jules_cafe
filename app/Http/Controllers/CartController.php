<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:dishes,id'
        ]);

        $dish = Dish::find($request->id);
        \Cart::session($request->user()->id)->add(array(
            'id' => $dish->id, // unique row ID
            'name' => $dish->name,
            'price' => $dish->price,
            'quantity' => 1,
            'attributes' => array(),
            'associatedModel' => $dish
        ));

        return redirect()->back();
    }

    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:dishes,id'
        ]);
        $dish = Dish::find($request->id);

        \Cart::session($request->user()->id)->remove($dish->id);
        return redirect()->back();
    }
}
