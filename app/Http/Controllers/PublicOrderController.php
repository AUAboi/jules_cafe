<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Actions\CreateUserOrder;
use App\Events\OrderCreated;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PublicOrderController extends Controller
{
    public function store(Request $request, CreateUserOrder $createUserOrder)
    {
        $request->validate([
            'is_dine' => 'boolean|required',
            'table_no' => 'required_if:is_dine,true',
            'note' => 'nullable|string'
        ]);

        if (!$request->is_dine) {
            $request->merge(['table_no' => null]);
        }

        try {
            $order = $createUserOrder->handle(auth()->user(), $request->all('table_no', 'note'));
        } catch (ModelNotFoundException $th) {
            return redirect()->back();
        }


        OrderCreated::dispatch($order);
        return redirect()->route('orders.placed', $order->order_no);
    }

    public function placed(Order $order)
    {
        $dishes = $order->dishes()->get()->transform(fn ($dish) => [
            'name' => $dish->name,
            'price' => $dish->formatted_price,
            'quantity' => $dish->quantity,
        ]);

        return Inertia::render('Public/OrderPlaced', [
            'order' => [
                'order_no' => $order->order_no,
                'status' => $order->status,
                'table_no' => $order->table_no,
                'total' =>  $order->total_price
            ],
            'dishes' => $dishes
        ]);
    }
    public function showOrder(Order $order)
    {
        $dishes =  $order->dishes()->get()->transform(fn ($dish) => [
            'name' => $dish->name,
            'price' => $dish->formatted_price,
            'quantity' => $dish->quantity,
        ]);
        return Inertia::render('Public/Order', [
            'order' => [
                'order_no' => $order->order_no,
                'status' => $order->status,
                'table_no' => $order->table_no,
                'total' => $order->total_price
            ],
            'dishes' => $dishes
        ]);
    }

    public function publicView()
    {
        $orders = auth()->user()->orders()->with(['dishes'])->orderBy('created_at', 'DESC')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($order) => [
                'order_no' => $order->order_no,
                'slug' => $order->order_no,
                'total' => $order->total_price,
                'type' => $order->order_type,
                'created_at' => $order->created_at->diffForHumans(),
                'slug' => $order->order_no,
                'status' => $order->status
            ]);;

        return Inertia::render('Public/Orders', [
            'orders' => $orders
        ]);
    }
}
