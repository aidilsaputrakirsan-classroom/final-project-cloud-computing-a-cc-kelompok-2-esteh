<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('cart.index', compact('items'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->input('quantity', 1);
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->input('quantity', 1),
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang.'
            ]);
        }

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
            }

    public function remove($id)
    {
        $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $user = auth()->user();
        $items = Cart::where('user_id', $user->id)->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        // Simpan catatan sementara di session (optional)
        session(['checkout_note' => $request->note]);

        // Langsung arahkan ke proses simpan pesanan
        return app(\App\Http\Controllers\OrderController::class)->store($request);
    }
}
