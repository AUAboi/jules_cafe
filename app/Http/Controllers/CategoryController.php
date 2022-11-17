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
        $filters = $request->all('search', 'active');

        $categories = Category::orderBy("name")
            ->filter($filters)
            ->get()
            ->transform(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
                'active' => $category->active,
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

    public function edit(Category $category)
    {
        return Inertia::render('Admin/Category/Edit', [
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'active' => $category->active,
                'image' => $category->media ? $category->media->baseMedia->getUrl() : null,
            ]
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'string|required',
            'image' => 'file|nullable|max:8000|mimetypes:image/jpg,image/jpeg,image/png',
            'active' => 'boolean'
        ]);

        DB::transaction(function () use ($request, $category) {
            $category->update([
                'name' => $request->name,
                'active' => $request->active,
            ]);


            if ($category->media) {
                $category->media->delete();
            }
            if ($request->hasFile('image')) {
                $image = $request->image;
                $categoryMedia = $category->media()->create([]);
                $categoryMedia->baseMedia()->associate(
                    $categoryMedia->addMedia($image)->toMediaCollection()
                )->save();
            }
        });

        return Redirect::route('admin.category')->with('success', 'Category edited succesfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->media) {
            $category->media->delete();
        }

        $category->delete();

        return Redirect::route('admin.category')->with('success', 'Category deleted succesfully.');
    }

    public function activate(Category $category)
    {
        $category->update(['active' => 1]);
        return redirect()->back();
    }

    public function publicView()
    {

        $categories =
            Category::orderBy("name")
            ->where('active', 1)
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
