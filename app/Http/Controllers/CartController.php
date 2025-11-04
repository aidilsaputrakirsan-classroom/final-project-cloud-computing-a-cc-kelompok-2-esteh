<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Tambah produk ke keranjang
    public function add(Request $request, $id)
    {
        // Jika form mengirim quantity, pakai itu. Jika tidak, set default 1
        $quantity = $request->input('quantity', 1);

        $request->validate([
            'quantity' => 'nullable|integer|min:1'
        ]);

        $cart = Cart::where('user_id', auth()->id())
                    ->where('product_id', $id)
                    ->first();

        if ($cart) {
            // jika sudah ada di keranjang, tambahkan quantity-nya
            $cart->update([
                'quantity' => $cart->quantity + $quantity
            ]);
        } else {
            // kalau belum ada, buat baru
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $id,
                'quantity' => $quantity
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil ditambahkan ke keranjang!');
    }

    // Lihat keranjang
    public function index()
    {
        $items = Cart::where('user_id', auth()->id())->get();
        return view('cart.index', compact('items'));
    }

    // Hapus item
    public function remove($id)
    {
        Cart::where('id', $id)->delete();
        return back()->with('success', 'Item dihapus dari keranjang');
    }

    // Checkout
    public function checkout()
    {
        $items = Cart::where('user_id', auth()->id())->get();

        if ($items->count() == 0) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        // Buat Order
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        foreach ($items as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'price'    => $cart->product->price,
            ]);
        }

        // Kosongkan keranjang setelah checkout
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }
}
