<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // harus login
    }

    public function index()
    {
        // nanti bisa diisi dengan logic ambil pesanan user
        return view('orders.index');
    }

    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
    ]);

    \App\Models\Order::create([
        'user_id' => auth()->id(),
        'product_id' => $request->product_id,
        'status' => 'pending'
    ]);

    return redirect()->route('products.menu')->with('success', 'Pesanan berhasil dibuat!');
}


    // metode lain seperti create, store, edit, update, destroy bisa ditambahkan nanti
}
