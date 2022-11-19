<?php

namespace App\Http\Middleware;

use App\Models\SiteMeta;
use Closure;
use Illuminate\Http\Request;

class ShopIsOpen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $site = SiteMeta::first();

        if (!$site->is_closed) return $next($request);
        return redirect()->route('home');
    }
}
