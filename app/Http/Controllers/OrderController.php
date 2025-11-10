<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'note' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        DB::transaction(function () use ($user, $cartItems, $request) {
            // Hitung total harga
            $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            // Buat pesanan baru
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'total' => $total,
                'note' => $request->note, // 📝 simpan catatan di sini
            ]);

            // Pindahkan item dari cart ke order_items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            // Hapus keranjang setelah checkout
            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $orderItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Jumlah item berhasil diperbarui.');
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return back()->with('success', 'Item berhasil dihapus.');
    }

    public function showPayment(Order $order)
    {
        return view('orders.payment', compact('order'));
    }

    public function processPayment(Request $request, Order $order)
    {
        $order->update(['status' => 'success']);
        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil!');
    }
}
