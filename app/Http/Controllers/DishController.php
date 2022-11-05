<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DishController extends Controller
{
    public function index()
    {

        $dishes = Dish::all();
        return Inertia::render(
            "Admin/Dish/Index",
            [
                'dishes' => $dishes
            ]
        );
    }

    public function create()
    {

        Inertia::render('Admin/Dish/Create');
    }
}
