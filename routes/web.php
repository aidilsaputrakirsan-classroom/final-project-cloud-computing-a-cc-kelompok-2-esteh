<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// =======================
// HALAMAN AWAL
// =======================
Route::get('/', function () {
    return view('welcome');
});

// =======================
// DASHBOARD (LOGIN WAJIB)
// =======================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =======================
// PROFILE (USER LOGIN)
// =======================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =======================
// ADMIN ROUTES
// =======================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // CRUD Produk (Admin)
    Route::resource('products', AdminProductController::class);

    // CRUD User (Admin)
    Route::resource('users', AdminUserController::class);

    // TODO: Tambahkan monitoring pesanan, laporan, dll.
});

// =======================
// USER ROUTES
// =======================
Route::middleware(['auth'])->group(function () {

    // Lihat daftar produk/menu
    Route::get('menu', [ProductController::class, 'menu'])->name('products.menu');

    // Tambahkan produk ke pesanan
    Route::post('orders/add/{product}', [OrderController::class, 'add'])->name('orders.add');

    // Lihat semua pesanan user
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

    // Update item pesanan (terima PUT dan PATCH agar fleksibel)
    Route::match(['put', 'patch'], 'order-items/{orderItem}', [OrderController::class, 'update'])
        ->name('orders.update');

    // Hapus item dari pesanan
    Route::delete('order-items/{orderItem}', [OrderController::class, 'destroy'])
        ->name('orders.destroy');
});

require __DIR__.'/auth.php';
