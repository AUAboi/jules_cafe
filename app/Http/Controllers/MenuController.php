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
            ->filter(array_merge($filters, ['active' => 1]))
            ->with(['categories', 'media'])
            ->paginate(9)
            ->withQueryString()
            ->through(fn ($dish) => [
                'id' => $dish->id,
                'name' => $dish->name,
                'ingredients' => $dish->ingredients,
                'price' => $dish->formatted_price,
                'image' => $dish->media ? $dish->media->baseMedia->getUrl() : null,
                'category' => $dish->categories
            ]);


        $categories = Category::where('active', 1)->get();


        return Inertia::render('Public/Menu', [
            'dishes' => $dishes,
            'categories' => $categories,
            'cart' => [
                'content' => \Cart::getContent()->toArray(),
                'total' => $request->user() ? money(\Cart::session($request->user()->id)->getTotal(), 'MYR', true)
                    ->formatWithoutZeroes() : null,
            ]

        ]);
    }
}
