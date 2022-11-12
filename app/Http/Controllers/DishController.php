<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DishController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->all('search');
        $dishes = Dish::orderBy("name")
            ->filter($filters)
            ->paginate(9)
            ->withQueryString();

        return Inertia::render(
            "Admin/Dish/Index",
            [
                'dishes' => $dishes
            ]
        );
    }

    public function create()
    {
        return Inertia::render('Admin/Dish/Create');
    }

    public function store(Request $request)
    {
        $dish = DB::transaction(function () use ($request) {
            return Dish::create([
                'name' => $request->name,
                'price' => $request->price,
                'is_active' => $request->is_active
            ]);
        });
    }
}
