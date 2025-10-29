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
        // Ambil semua produk terbaru
        $products = Product::latest()->paginate(12);

        // Tampilkan ke view products.menu
        return view('products.menu', compact('products'));
    }
}
