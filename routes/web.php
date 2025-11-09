<?php

use Illuminate\Support\Facades\Route;

// Controller Imports
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\PaymentMethodController; // <-- controller untuk admin payment methods
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController; // <-- notifikasi (in-app)

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di file inilah semua route web aplikasi didefinisikan.
| Route di sini akan diproses oleh web middleware group.
|
*/

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

        // Update status order oleh admin (existing)
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');

        // Admin - Edit / Update pembayaran untuk sebuah order
        Route::get('/orders/{order}/edit-payment', [AdminOrderController::class, 'editPayment'])
            ->name('orders.editPayment');
        Route::put('/orders/{order}/edit-payment', [AdminOrderController::class, 'updatePayment'])
            ->name('orders.updatePayment');

        // =======================
        // Admin - Manajemen Metode Pembayaran (CRUD)
        // =======================
        // resource controller: index, create, store, edit, update, destroy
        Route::resource('payment-methods', PaymentMethodController::class)->except(['show']);
    });

// =======================
// USER BIASA (Customer)
// =======================
Route::middleware('auth')->group(function () {

    // MENU PRODUK
    Route::get('/menu', [ProductController::class, 'menu'])->name('products.menu');

    // KERANJANG (CART)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // CHECKOUT
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    // ✅ PEMBAYARAN PESANAN (Dummy Payment)
    Route::get('/orders/{order}/pay', [OrderController::class, 'showPayment'])->name('orders.pay');
    Route::post('/orders/{order}/pay', [OrderController::class, 'processPayment'])->name('orders.processPayment');

    // RIWAYAT PESANAN
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::match(['put', 'patch'], '/order-items/{orderItem}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/order-items/{orderItem}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // =======================
    // NOTIFIKASI (in-app)
    // =======================
    // Ambil notifikasi (unread + read)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    // Tandai 1 notifikasi sebagai terbaca
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Tandai semua notifikasi terbaca
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
});

// =======================
// AUTHENTICATION ROUTES
// (Login, Register, Forgot Password, dll.)
// =======================
require __DIR__.'/auth.php';
