<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController;

// Root redirect
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home.page');
    }
    return redirect()->route('login');
})->name('root');

// ==================== USER SIDE (PUBLIC) ====================
Route::get('/home', [HomeController::class, 'index'])->name('home.page');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show');

// ==================== AUTH REQUIRED ====================
Route::middleware('auth')->group(function () {

    // Dashboard redirect
    Route::get('/dashboard', function () {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home.page');
    })->name('dashboard');

    Route::get('/profile', function () {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home.page');
    })->name('profile.edit');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{menuItem}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');

    // Orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}/confirmation', [OrderController::class, 'confirmation'])->name('orders.confirmation');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
});

require __DIR__.'/auth.php';

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('menu-items', MenuItemController::class);

    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// ==================== API ROUTES (Cart AJAX) ====================
Route::middleware('auth')->prefix('api')->name('api.')->group(function () {
    Route::get('/cart', [\App\Http\Controllers\Api\CartApiController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{menuItem}', [\App\Http\Controllers\Api\CartApiController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [\App\Http\Controllers\Api\CartApiController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [\App\Http\Controllers\Api\CartApiController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/count', [\App\Http\Controllers\Api\CartApiController::class, 'count'])->name('cart.count');
});