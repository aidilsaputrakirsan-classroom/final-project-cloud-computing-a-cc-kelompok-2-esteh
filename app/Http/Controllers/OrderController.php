<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\OrderNotification; // ✅ Tambah

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
            $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'total' => $total,
                'note' => $request->note,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            Cart::where('user_id', $user->id)->delete();

            // ✅ Kirim notifikasi pesanan dibuat
            $user->notify(new OrderNotification($order, 'create'));
        });

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        if ($orderItem->order->status === 'success') {
            return back()->with('error', 'Pesanan sudah dibayar dan tidak bisa diubah.');
        }

        $request->validate(['quantity' => 'required|integer|min:1']);
        $orderItem->update(['quantity' => $request->quantity]);

        // ✅ Notifikasi update
        $orderItem->order->user->notify(new OrderNotification($orderItem->order, 'update'));

        return back()->with('success', 'Jumlah item berhasil diperbarui.');
    }

    public function destroy(OrderItem $orderItem)
    {
        if ($orderItem->order->status === 'success') {
            return back()->with('error', 'Pesanan sudah dibayar dan tidak bisa dihapus.');
        }

        $order = $orderItem->order;

        $orderItem->delete();

        // ✅ Notifikasi delete
        $order->user->notify(new OrderNotification($order, 'delete'));

        return back()->with('success', 'Item berhasil dihapus.');
    }

    public function showPayment($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $methods = PaymentMethod::active()->get();

        return view('orders.payment', compact('order', 'methods'));
    }

    public function processPayment(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'method' => 'required|string|exists:payment_methods,code',
        ]);

        $order->update([
            'payment_method' => $request->method,
            'payment_status' => 'paid',
        ]);

        // ✅ Notifikasi pembayaran
        $order->user->notify(new OrderNotification($order, 'paid'));

        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil! Menunggu verifikasi admin.');
    }
}
