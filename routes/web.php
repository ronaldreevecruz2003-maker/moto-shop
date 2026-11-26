<?php

use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\StorefrontController;
use App\Models\Sale;
use Illuminate\Support\Facades\Route;

Route::get('/', [StorefrontController::class, 'index'])->name('home');

// Customer Authentication & Account Routes
Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('customer.login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('customer.login.post');
Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('customer.register');
Route::post('/register', [CustomerAuthController::class, 'register'])->name('customer.register.post');
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

Route::middleware('auth')->group(function () {
    Route::get('/my-account', [CustomerAuthController::class, 'dashboard'])->name('customer.dashboard');
    Route::post('/my-account/profile', [CustomerAuthController::class, 'updateProfile'])->name('customer.profile.update');
    Route::post('/book-repair', [StorefrontController::class, 'bookRepair'])->name('book.repair');
    Route::post('/checkout-cart', [StorefrontController::class, 'checkoutCart'])->name('cart.checkout');
    Route::post('/reviews', [StorefrontController::class, 'storeReview'])->name('reviews.store');
});

Route::get('/sales/{sale}/receipt', function (Sale $sale) {
    $sale->load('items.part');
    return view('receipt', compact('sale'));
})->middleware('auth')->name('sales.receipt');