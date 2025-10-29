<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Halaman welcome
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (login required)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =======================
// ADMIN ROUTES
// =======================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class);
    Route::resource('users', AdminUserController::class);
    // Nanti bisa ditambah: monitoring pesanan, laporan, dll
});

// =======================
// USER ROUTES
// =======================

// User bisa lihat daftar produk (menu)
Route::middleware(['auth'])->group(function () {
    Route::get('menu', [ProductController::class, 'menu'])->name('products.menu');

    // Tambah produk ke pesanan
    Route::post('orders/add/{product}', [OrderController::class, 'add'])->name('orders.add');

    // CRUD pesanan
    Route::get('orders', [OrderController::class,'index'])->name('orders.index');
    Route::post('orders', [OrderController::class,'store'])->name('orders.store');
    Route::patch('orders/{orderItem}', [OrderController::class,'update'])->name('orders.update');
    Route::delete('orders/{orderItem}', [OrderController::class,'destroy'])->name('orders.destroy');
});

require __DIR__.'/auth.php';
