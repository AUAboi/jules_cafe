<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->all('search', 'status');
        $orders = Order::with(['user'])->orderBy('created_at', 'DESC')
            ->filter($filters)
            ->with(['dishes'])
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($order) => [
                'order_no' => $order->order_no,
                'total' => $order->total_price,
                'type' => $order->order_type,
                'user_name' => $order->user->name,
                'phone' => $order->user->phone,
                'created_at' => $order->created_at->diffForHumans(),
                'slug' => $order->order_no,
                'status' => $order->status
            ]);

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders,
            'filters' => $filters
        ]);
    }

    public function show(Order $order)
    {

        $dishes = $order->dishes()->get()->transform(fn ($dish) => [
            'name' => $dish->name,
            'price' => $dish->formatted_price,
            'quantity' => $dish->quantity,
        ]);
        return Inertia::render('Admin/Orders/Show', [
            'order' => [
                'order_no' => $order->order_no,
                'status' => $order->status,
                'total' => $order->total_price,
                'created_at' => $order->created_at->format('Y/m/d H:i'),
                'time' => $order->created_at->diffForHumans(),
            ],
            'user' => $order->user,
            'dishes' => $dishes
        ]);
    }



    public function update(Order $order, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,completed,cancelled'
        ]);
        $order->update(['status' => $request->status]);

        return redirect()->back();
    }
}
