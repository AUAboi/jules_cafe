<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SiteClosedController;
use App\Models\Order;
use App\Models\SiteMeta;
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

Route::get('/category', [CategoryController::class, 'publicView'])->name('category');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::get('/we-are-closed', SiteClosedController::class)->name('closed');

Route::middleware(['auth'])->group(function () {
    Route::prefix('/cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart');
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');

        Route::post('/remove-item', [CartController::class, 'removeItem'])->name('cart.removeitem');
    });

    Route::prefix('/orders')->group(function () {
        Route::get('/', [OrderController::class, 'publicView'])->name('orders');
        Route::get('/{order}', [OrderController::class, 'showOrder'])->name('orders.show');

        Route::get('/placed/{order}', [OrderController::class, 'placed'])->name('orders.placed');


        Route::post('/orders/create', [OrderController::class, 'store'])->middleware(['shopisopen'])->name('orders.store');
    });
});

Route::prefix('/admin')->middleware(['auth', 'isadmin'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');


    //Dish routes
    Route::get('/dish', [DishController::class, 'index'])->name('admin.dish');

    Route::get('/dish/create', [DishController::class, 'create'])->name('admin.dish.create');
    Route::post('/dish/create', [DishController::class, 'store'])->name('admin.dish.store');

    Route::get('/dish/{dish}/', [DishController::class, 'edit'])->name('admin.dish.edit');
    Route::put('/dish/{dish}/activate', [DishController::class, 'activate'])->name('admin.dish.activate');
    Route::put('/dish/{dish}/update', [DishController::class, 'update'])->name('admin.dish.update');

    Route::delete('/dish/{dish}/delete', [DishController::class, 'destroy'])->name('admin.dish.destroy');

    //Category routes
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');

    Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/category/create', [CategoryController::class, 'store'])->name('admin.category.store');

    Route::get('/category/{category}/', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/category/{category}/activate', [CategoryController::class, 'activate'])->name('admin.category.activate');
    Route::put('/category/{category}/update', [CategoryController::class, 'update'])->name('admin.category.update');

    Route::delete('/category/{category}/delete', [CategoryController::class, 'destroy'])->name('admin.category.destroy');

    //Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');

    Route::put('/orders/{order}/update', [OrderController::class, 'update'])->name('admin.orders.update');

    Route::post('/site/togglestatus', function () {
        $site  = SiteMeta::first();
        $site->update(['is_closed' => !$site->is_closed]);
    })->name('admin.site.togglestatus');

    //Users
    Route::get('/users', [RegisteredUserController::class, 'index'])->name('admin.users');
    Route::get('/users/{user}', [RegisteredUserController::class, 'show'])->name('admin.users.show');

    Route::delete('/users/{user}', [RegisteredUserController::class, 'destroy'])->name('admin.users.destroy');
});



require __DIR__ . '/auth.php';
