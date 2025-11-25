<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Halaman menu untuk user/pelanggan
     */
public function menu()
{
    $products = \App\Models\Product::all(); // ambil semua produk
    return view('products.menu', compact('products'));
}

}
