<?php

namespace App\Http\Middleware;

use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed[]
     */
    public function share(Request $request)
    {



        if ($request->user()) {
            \Cart::session($request->user()->id);
            $cart = [
                'total' => money(\Cart::getTotal(), 'MYR', true)->formatWithoutZeroes()
            ];
        } else {
            $cart = ['total' => null];
        }


        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'appName' => config('app.name'),

            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'notifications' => $request->user()->unreadNotifications ?? null,
            'cart' => [
                'total' => $request->user ? money(\Cart::session($request->user()->id)->getTotal(), 'MYR', true)
                    ->formatWithoutZeroes() : null,
            ],
        ]);
    }
}
