<?php

namespace App\Http\Controllers;

use App\Actions\AddToCart;
use App\Actions\RemoveFromCart;
use App\Models\Dish;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, AddToCart $addToCart)
    {
        $request->validate([
            'id' => 'required|exists:dishes,id'
        ]);


        $dish = Dish::findOrFail($request->id);

        if (!$dish->active) {
            return redirect()->back()->with('error', 'Not available anymore');
        }

        $addToCart->handle(auth()->user(), $dish);

        return redirect()->back();
    }

    public function remove(Request $request, RemoveFromCart $removeFromCart)
    {
        $request->validate([
            'id' => 'required|exists:dishes,id'
        ]);

        $dish = Dish::findOrFail($request->id);

        $removeFromCart->handle(auth()->user(), $dish);

        return redirect()->back();
    }
}
