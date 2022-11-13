<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\MenuController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Public/Home');
})->name('home');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::prefix('/admin')->middleware(['auth', 'isadmin'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');

    Route::get('/dish', [DishController::class, 'index'])->name('admin.dish');

    Route::get('/dish/create', [DishController::class, 'create'])->name('admin.dish.create');
    Route::post('/dish/create', [DishController::class, 'store'])->name('admin.dish.store');

    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
});




require __DIR__ . '/auth.php';
