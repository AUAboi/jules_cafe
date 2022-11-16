<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->all('search', 'category');

        $dishes = Dish::orderBy("name")
            ->filter($filters)
            ->active()
            ->paginate(9)
            ->withQueryString()
            ->through(fn ($dish) => [
                'id' => $dish->id,
                'name' => $dish->name,
                'price' => $dish->formatted_price,
                'image' => $dish->media ? $dish->media->baseMedia->getUrl() : null,
                'category' => $dish->categories
            ]);


        $categories = Category::active()->get();


        return Inertia::render('Public/Menu', [
            'dishes' => $dishes,
            'categories' => $categories,

        ]);
    }
}
