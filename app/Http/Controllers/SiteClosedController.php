<?php

namespace App\Http\Controllers;

use App\Models\SiteMeta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteClosedController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (!SiteMeta::first()->is_closed) {
            return redirect()->route('home');
        }

        return Inertia::render('Public/Closed');
    }
}
