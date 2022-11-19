<?php

namespace App\Http\Controllers;

use App\Models\SiteMeta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $siteMeta = SiteMeta::first();
        return Inertia::render('Admin/Dashboard', ['siteMeta' => $siteMeta]);
    }
}
