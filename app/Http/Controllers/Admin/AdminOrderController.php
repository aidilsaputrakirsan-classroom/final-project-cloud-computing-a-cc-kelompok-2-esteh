<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // ✅ Hapus order
    public function destroy(Order $order)
    {
        $order->items()->delete(); // hapus itemnya
        $order->delete();          // hapus order

        return back()->with('success', 'Pesanan berhasil dihapus!');
    }

    // ✅ Update status
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,success,cancel'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pesanan diperbarui!');
    }
}
