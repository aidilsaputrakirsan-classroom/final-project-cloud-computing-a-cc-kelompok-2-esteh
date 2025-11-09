<?php

use Illuminate\Support\Facades\Route;

// Controller Imports
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;

// =======================
// HALAMAN AWAL
// =======================
Route::get('/', function () {
    return view('welcome');
});

// =======================
// DASHBOARD
// =======================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =======================
// PROFILE USER
// =======================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =======================
// ADMIN AREA
// =======================
Route::middleware(['auth', 'IsAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // CRUD Produk
        Route::resource('products', AdminProductController::class);

        // CRUD Pengguna
        Route::resource('users', AdminUserController::class);

        // CRUD Pesanan (Admin)
        Route::resource('orders', AdminOrderController::class);

        // Update status order
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');

        // Edit pembayaran order
        Route::get('/orders/{order}/edit-payment', [AdminOrderController::class, 'editPayment'])
            ->name('orders.editPayment');
        Route::put('/orders/{order}/edit-payment', [AdminOrderController::class, 'updatePayment'])
            ->name('orders.updatePayment');

        // ✅ CRUD Metode Pembayaran
        Route::resource('payment-methods', PaymentMethodController::class)
            ->except(['show']);
    });

// =======================
// USER AREA
// =======================
Route::middleware('auth')->group(function () {

    // MENU PRODUK
    Route::get('/menu', [ProductController::class, 'menu'])->name('products.menu');

    // CART
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // CHECKOUT
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    // ✅ PEMBAYARAN PESANAN
    Route::get('/orders/{order}/pay', [OrderController::class, 'showPayment'])->name('orders.payment');
    Route::post('/orders/{order}/pay', [OrderController::class, 'processPayment'])->name('orders.payment.process');

    // RIWAYAT PESANAN
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::match(['put', 'patch'], '/order-items/{orderItem}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/order-items/{orderItem}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // NOTIFIKASI
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
});

// AUTH
require __DIR__.'/auth.php';
