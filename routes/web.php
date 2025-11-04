<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// =======================
// HALAMAN AWAL / WELCOME
// =======================
Route::get('/', function () {
    return view('welcome');
});

// =======================
// DASHBOARD (BUTUH LOGIN)
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
// ADMIN (KHUSUS ROLE ADMIN)
// =======================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Produk (CRUD Admin)
    Route::resource('products', AdminProductController::class);

    // User Management (CRUD Admin)
    Route::resource('users', AdminUserController::class);

});


// =======================
// USER BIASA
// =======================
Route::middleware(['auth'])->group(function () {

    // ====== MENU PRODUK ======
    Route::get('/menu', [ProductController::class, 'menu'])->name('products.menu');



    // =======================
    // CART / KERANJANG
    // =======================

    // Lihat isi keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    // Tambah produk ke keranjang
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

    // Hapus item dari keranjang
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Halaman review sebelum pembayaran
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Simpan order ke database
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');



    // =======================
    // ORDER / RIWAYAT PESANAN
    // =======================
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // Update status pesanan (opsional)
    Route::match(['put', 'patch'], '/order-items/{orderItem}', [OrderController::class, 'update'])
        ->name('orders.update');

    // Hapus item pesanan (opsional)
    Route::delete('/order-items/{orderItem}', [OrderController::class, 'destroy'])
        ->name('orders.destroy');

    


});

require __DIR__.'/auth.php';
