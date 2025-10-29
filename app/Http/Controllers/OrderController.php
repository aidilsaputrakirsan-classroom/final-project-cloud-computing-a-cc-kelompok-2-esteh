<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Lihat pesanan user
    public function index()
    {
        $orders = Auth::user()->orders()->with('items.product')->get();
        return view('orders.index', compact('orders'));
    }

    // Tambah produk ke pesanan (tombol "Pesan")
    public function add(Product $product)
    {
        $user = Auth::user();

        $order = Order::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'pending'],
            ['total' => 0]
        );

        $orderItem = $order->items()->firstOrCreate(
            ['product_id' => $product->id],
            ['quantity' => 0, 'price' => $product->price]
        );

        $orderItem->quantity += 1;
        $orderItem->save();

        $order->total = $order->items()->sum(DB::raw('quantity * price'));
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Produk berhasil ditambahkan ke pesanan.');
    }

    // Update jumlah item
    public function update(Request $request, OrderItem $orderItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $orderItem->update(['quantity' => $validated['quantity']]);

        $order = $orderItem->order;
        $order->total = $order->items()->sum(DB::raw('quantity * price'));
        $order->save();

        return redirect()->back()->with('success', 'Jumlah item berhasil diupdate.');
    }

    // Hapus item
    public function destroy(OrderItem $orderItem)
    {
        $order = $orderItem->order;
        $orderItem->delete();

        $order->total = $order->items()->sum(DB::raw('quantity * price'));
        $order->save();

        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }
}
