<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::orderBy('created_at', 'desc')->get();
        return view('admin.payment_methods.index', compact('methods'));
    }

    public function create()
    {
        return view('admin.payment_methods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|alpha_dash|unique:payment_methods,code',
            'active' => 'nullable|boolean',
            'config' => 'nullable|string', // JSON string or simple text
        ]);

        $config = null;
        if ($validated['config'] ?? null) {
            // try decode if valid JSON
            $decoded = json_decode($validated['config'], true);
            $config = is_array($decoded) ? $decoded : ['info' => $validated['config']];
        }

        PaymentMethod::create([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'active' => $request->has('active') ? (bool) $validated['active'] : true,
            'config' => $config,
        ]);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_methods.edit', ['method' => $paymentMethod]);
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|alpha_dash|unique:payment_methods,code,' . $paymentMethod->id,
            'active' => 'nullable|boolean',
            'config' => 'nullable|string',
        ]);

        $config = null;
        if ($validated['config'] ?? null) {
            $decoded = json_decode($validated['config'], true);
            $config = is_array($decoded) ? $decoded : ['info' => $validated['config']];
        }

        $paymentMethod->update([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'active' => $request->has('active') ? (bool) $validated['active'] : false,
            'config' => $config,
        ]);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran dihapus.');
    }
}
