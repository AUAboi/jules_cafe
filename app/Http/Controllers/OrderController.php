<?php

namespace App\Http\Controllers;

use App\Actions\CreateUserOrder;
use App\Models\Dish;
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
        $orders = Order::with(['user'])->orderBy('created_at')
            ->filter($filters)
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($order) => [
                'order_no' => $order->order_no,
                'total' => $order->total_price,
                'type' => $order->order_type,
                'user_name' => $order->user->name,
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
            'price' => $dish->pivot->price,
            'quantity' => $dish->pivot->quantity,
        ]);
        return Inertia::render('Admin/Orders/Show', [
            'order' => $order,
            'dishes' => $dishes
        ]);
    }

    public function store(Request $request, CreateUserOrder $createUserOrder)
    {
        $request->validate([
            'is_dine' => 'boolean|required',
            'table_no' => 'required_if:is_dine,true',
            'note' => 'string'
        ]);

        $createUserOrder->handle(auth()->user(), $request->all('table_no', 'note'));

        return redirect()->route('home');
    }

    public function publicView()
    {
        $orders = auth()->user()->orders()->orderBy('created_at')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($order) => [
                'order_no' => $order->order_no,
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
