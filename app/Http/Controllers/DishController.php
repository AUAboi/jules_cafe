<?php

namespace App\Http\Controllers;

use App\Actions\SyncCategoryDishes;
use App\Models\Category;
use App\Models\Dish;
use App\Models\DishMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DishController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->all('search', 'active');
        $dishes = Dish::orderBy('name')
            ->filter($filters)
            ->paginate(9)
            ->withQueryString()
            ->through(fn ($dish) => [
                'id' => $dish->id,
                'name' => $dish->name,
                'price' => $dish->formatted_price,
                'active' => $dish->active,
                'image' => $dish->media ? $dish->media->baseMedia->getUrl() : null,
            ]);


        return Inertia::render(
            "Admin/Dish/Index",
            [
                'dishes' => $dishes,
                'filters' => $filters
            ]
        );
    }

    public function create()
    {
        return Inertia::render('Admin/Dish/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            'price' => 'numeric|required|min:1',
            'image' => 'file|nullable|max:8000|mimetypes:image/jpg,image/jpeg,image/png,image/webp',
            'active' => 'boolean'
        ]);

        DB::transaction(function () use ($request) {
            $dish = Dish::create([
                'name' => $request->name,
                'price' => $request->price,
                'active' => $request->active
            ]);

            if ($request->hasFile('image')) {
                $image = $request->image;
                $dishMedia = $dish->media()->create([]);
                $dishMedia->baseMedia()->associate(
                    $dishMedia->addMedia($image)->toMediaCollection()
                )->save();
            }
        });

        return Redirect::route('admin.dish')->with('success', 'Dish added succesfully.');
    }

    public function edit(Dish $dish)
    {
        $category_dishes = $dish->categories()->get();
        $categories =  Category::orderBy('name')
            ->get()
            ->transform(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,

                'belongs_to_program' => $category_dishes->contains($category->id),
            ]);

        return Inertia::render('Admin/Dish/Edit', [
            'dish' => [
                'id' => $dish->id,
                'name' => $dish->name,
                'price' => $dish->price,
                'active' => $dish->active,
                'image' => $dish->media ? $dish->media->baseMedia->getUrl() : null,
            ],
            'categories' => $categories,
            'category_dishes' => $category_dishes
        ]);
    }

    public function update(Request $request, Dish $dish, SyncCategoryDishes $syncCategoryDishes)
    {
        $request->validate([
            'name' => 'string|required',
            'price' => 'numeric|required|min:1',
            'image' => 'file|nullable|max:8000|mimetypes:image/jpg,image/jpeg,image/png,image/webp',
            'active' => 'boolean'
        ]);

        DB::transaction(function () use ($request, $dish) {
            $dish->update([
                'name' => $request->name,
                'price' => $request->price,
                'active' => $request->active,
                'categories' => 'required|array|min:1',
            ]);


            if ($dish->media) {
                $dish->media->delete();
            }
            if ($request->hasFile('image')) {
                $image = $request->image;
                $dishMedia = $dish->media()->create([]);
                $dishMedia->baseMedia()->associate(
                    $dishMedia->addMedia($image)->toMediaCollection()
                )->save();
            }
        });


        $syncCategoryDishes->handle($dish, $request->categories);
        return Redirect::route('admin.dish')->with('success', 'Dish edited succesfully.');
    }

    public function destroy(Dish $dish)
    {
        if ($dish->media) {
            $dish->media->delete();
        }

        $dish->delete();

        return Redirect::route('admin.dish')->with('success', 'Dish deleted succesfully.');
    }

    public function activate(Dish $dish)
    {
        $dish->update(['active' => 1]);
        return redirect()->back();
    }
}
