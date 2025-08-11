<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/products');

Route::resource('products', ProductsController::class);
Route::resource('orders', OrdersController::class);

// Route::put('products/{product}/buy', [ProductsController::class,'buy'])
//     ->where('product', '^\d+$')
//     ->name('products.buy');

Route::prefix('/cart')
    ->controller(CartController::class)
    ->as('cart')
    ->group(function () {
        Route::get('', 'index')->name('.index');
        Route::post('', 'buy')->name('.buy');
    });

Route::get('/welcome', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
