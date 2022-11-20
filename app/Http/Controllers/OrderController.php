<?php

namespace App\Http\Controllers;

use App\Actions\CreateUserOrder;
use App\Models\Dish;
use App\Models\DishOrder;
use App\Models\Order;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $dishes = DishOrder::where('order_id', $order->id)->get()->transform(fn ($dish) => [
            'name' => $dish->name,
            'price' => config('constants.currency') . ' ' . $dish->price,
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

        $order = $createUserOrder->handle(auth()->user(), $request->all('table_no', 'note'));

        return redirect()->route('orders.placed', $order->order_no);
    }

    public function update(Order $order, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,completed,cancelled'
        ]);
        $order->update(['status' => $request->status]);

        return redirect()->back();
    }

    public function placed(Order $order)
    {
        $dishes = DishOrder::where('order_id', $order->id)->get()->transform(fn ($dish) => [
            'name' => $dish->name,
            'price' => config('constants.currency') . ' ' . $dish->price,
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
        $dishes = DishOrder::where('order_id', $order->id)->get()->transform(fn ($dish) => [
            'name' => $dish->name,
            'price' => config('constants.currency') . ' ' . $dish->price,
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
        $orders = auth()->user()->orders()->orderBy('created_at', 'DESC')
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
