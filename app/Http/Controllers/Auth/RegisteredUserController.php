<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Propaganistas\LaravelPhone\PhoneNumber;

class RegisteredUserController extends Controller
{

    public function index(Request $request)
    {
        $filters = $request->all('search');

        $users = User::orderBy('created_at', 'DESC')
            ->with(['orders'])
            ->filter($filters)
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'last_order' =>  $user->orders->count() ? '#' . $user->orders()->latest()->first()->order_no : null,
                'created_at' => $user->created_at->format('Y/m/d')
            ]);

        return Inertia::render('Admin/User/Index', [
            'filters' => $filters,
            'users' => $users
        ]);
    }

    public function show(User $user)
    {
        $orders = $user->orders()->orderBy('created_at', 'DESC')
            ->with(['dishes'])
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($order) => [
                'order_no' => $order->order_no,
                'total' => $order->total_price,
                'type' => $order->order_type,
                'user_name' => $user->name,
                'phone' => $user->phone,
                'created_at' => $order->created_at->diffForHumans(),
                'slug' => $order->order_no,
                'status' => $order->status
            ]);
        return Inertia::render('Admin/User/Show', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'created_at' => $user->created_at->format('Y/m/d')
            ],
            'orders' => $orders
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users');
    }

    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }



    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|phone:MY',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('menu');
    }
}
