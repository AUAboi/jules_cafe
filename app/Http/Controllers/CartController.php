<?php

namespace App\Http\Controllers;

use App\Actions\AddToCart;
use App\Actions\RemoveFromCart;
use App\Models\Dish;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        \Cart::session(auth()->id());

        $row = \Cart::getContent();


        // remove from cart if item doesnt exist anymore
        foreach ($row as $key => $item) {
            $dish = Dish::find($item->id);
            if (!$dish) {
                \Cart::remove($item->id);
                unset($row[$key]);
            }
        }


        $cartContent = $row->transform(fn ($item) => [
            'id' => $item->id,
            'name' => $item->associatedModel->name,
            'price' => $item->associatedModel->formatted_price,
            'quantity' => $item->quantity,
            'total_price' => config('constants.currency') . ' ' . $item->associatedModel->price * $item->quantity,
            'image' => $item->associatedModel->media ? $item->associatedModel->media->baseMedia->getUrl() : null,
        ]);




        return Inertia::render('Public/Cart', [
            'cart' => [
                'content' => $cartContent,
                'total' => \Cart::getTotal(),
            ]
        ]);
    }

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
            'id' => 'required|exists:dishes,id',
        ]);

        $dish = Dish::findOrFail($request->id);

        $removeFromCart->handle(auth()->user(), $dish);

        return redirect()->back();
    }

    public function removeItem(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:dishes,id',
        ]);

        \Cart::session(auth()->id())->remove($request->id);

        return redirect()->back();
    }
}
