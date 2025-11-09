<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Notification
use App\Notifications\OrderNotification;

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

        // Kirim notifikasi ke user (order dibuat / diupdate)
        $user->notify(new OrderNotification($order, 'create'));

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

        // Notifikasi: order diperbarui
        $order->user?->notify(new OrderNotification($order, 'update'));

        return redirect()->back()->with('success', 'Jumlah item berhasil diupdate.');
    }

    // Hapus item
    public function destroy(OrderItem $orderItem)
    {
        // Ambil order dan user sebelum hapus item
        $order = $orderItem->order;
        $user = $order->user;

        // Hapus itemnya
        $orderItem->delete();

        // Jika order tidak punya item lagi → hapus order
        if ($order->items()->count() == 0) {
            // simpan info id untuk notifikasi setelah delete (karena $order akan dihapus)
            $orderId = $order->id;
            // hapus order
            $order->delete();

            // Notifikasi: order dihapus (kirim ke user yang terkait sebelumnya)
            if ($user) {
                $user->notify(new OrderNotification($order, 'delete', "Order #{$orderId} telah dihapus karena tidak ada item."));
            }
        } else {
            // update total jika masih ada item
            $order->total = $order->items()->sum(DB::raw('quantity * price'));
            $order->save();

            // Notifikasi: order diperbarui (item dihapus)
            $order->user?->notify(new OrderNotification($order, 'update', "Satu item pada Order #{$order->id} telah dihapus."));
        }

        return back()->with('success', 'Item berhasil dihapus!');
    }

    /**
     * Tampilkan halaman pilihan metode pembayaran.
     * Mengambil metode aktif dari tabel payment_methods supaya admin bisa mengatur metode.
     */
    public function showPayment(Order $order)
    {
        // Pastikan user yang login adalah pemilik order
        if ($order->user_id !== Auth::id()) {
            return back()->with('error', 'Tidak berhak mengakses pembayaran order ini.');
        }

        // Jika order sudah dibayar, alihkan
        if (isset($order->payment_status) && $order->payment_status === 'paid') {
            return redirect()->route('orders.index')->with('success', 'Pesanan sudah dibayar.');
        }

        // AMBIL METODE AKTIF DARI DB (admin bisa atur lewat admin panel)
        $methods = PaymentMethod::where('active', true)->orderBy('name')->get();

        // Tampilkan view payment (resources/views/orders/payment.blade.php)
        return view('orders.payment', compact('order', 'methods'));
    }

    /**
     * Proses pembayaran dummy.
     * Metode yang diterima harus ada di tabel payment_methods dan aktif.
     */
    public function processPayment(Request $request, Order $order)
    {
        // Keamanan: pastikan pemilik order
        if ($order->user_id !== Auth::id()) {
            return back()->with('error', 'Tidak berhak mengakses.');
        }

        // Validasi input dasar
        $validated = $request->validate([
            'method' => 'required|string'
        ]);

        $method = $validated['method'];

        // Pastikan metode ada dan aktif di DB
        $pm = PaymentMethod::where('code', $method)->where('active', true)->first();
        if (!$pm) {
            return back()->with('error', 'Metode pembayaran tidak valid atau tidak aktif.');
        }

        // Buat transaction id sederhana (unik)
        $tx = strtoupper(substr(sha1(now() . $order->id . $method), 0, 12));

        // Update order — pastikan kolom ada di migration dan model $fillable
        $order->update([
            'payment_method' => $method,
            'payment_status' => 'paid',
            'transaction_id' => $tx,
            // sesuaikan status dengan sistemmu (di project ini sering pakai 'success' untuk paid)
            'status' => 'success',
        ]);

        // Notifikasi: pembayaran berhasil
        $order->user?->notify(new OrderNotification($order, 'paid', "Pembayaran berhasil (TX: $tx)"));

        return redirect()->route('orders.index')->with('success', "Pembayaran berhasil via {$pm->name}. (TX: $tx)");
    }
}
