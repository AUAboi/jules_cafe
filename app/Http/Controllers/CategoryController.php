<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->all('search');

        $categories = Category::orderBy("name")
            ->filter($filters)
            ->get()
            ->transform(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
                'image' => $category->media ? $category->media->baseMedia->getUrl() : null,
            ]);

        return Inertia::render('Admin/Category/Index', ['categories' => $categories]);
    }

    public function create()
    {
        return Inertia::render('Admin/Category/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            'image' => 'file|max:8000|mimetypes:image/jpg,image/jpeg,image/png',
            'active' => 'boolean'
        ]);


        DB::transaction(function () use ($request) {
            $category = Category::create([
                'name' => $request->name,
                'active' => $request->active
            ]);


            if ($request->hasFile('image')) {
                $image = $request->image;
                $categoryMedia = $category->media()->create([]);
                $categoryMedia->baseMedia()->associate(
                    $categoryMedia->addMedia($image)->toMediaCollection()
                )->save();
            }
        });

        return Redirect::route('admin.category')->with('success', 'Category added succesfully.');
    }

    public function publicView()
    {

        $categories = Category::orderBy("name")
            ->get()
            ->transform(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
                'image' => $category->media ? $category->media->baseMedia->getUrl() : null,
            ]);
        return Inertia::render('Public/Category', [
            'categories' => $categories
        ]);
    }
}
