<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pembayaran Pesanan #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg p-6">

                {{-- Informasi Total Pembayaran --}}
                <p class="mb-4 text-gray-700">Total Pembayaran:</p>
                <h3 class="text-2xl font-bold text-green-600 mb-6">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </h3>

                {{-- FORM PEMBAYARAN --}}
                <form action="{{ route('orders.processPayment', $order) }}" method="POST">
                    @csrf

                    {{-- METODE PEMBAYARAN --}}
                    <div class="mb-4">
                        <h4 class="font-semibold mb-2">Pilih Metode Pembayaran</h4>

                        @php
                            use App\Models\PaymentMethod;
                            $methods = PaymentMethod::where('active', true)->orderBy('name')->get();
                        @endphp

                        @forelse($methods as $m)
                            <label class="inline-flex items-center mb-2">
                                <input type="radio" name="method" value="{{ $m->code }}" {{ $loop->first ? 'checked' : '' }} class="mr-2">
                                <span>{{ $m->name }}</span>
                            </label>
                            <br>
                        @empty
                            <div class="text-sm text-gray-500">
                                Belum ada metode pembayaran tersedia. Hubungi admin.
                            </div>
                        @endforelse
                    </div>

                    {{-- CATATAN --}}
                    <div class="mb-4 text-sm text-gray-600">
                        <strong>Catatan:</strong> Ini hanya simulasi pembayaran. Setelah klik <em>Bayar Sekarang</em>,
                        pesanan akan otomatis ditandai <strong>paid</strong>.
                    </div>

                    {{-- TOMBOL --}}
                    <div class="flex gap-3">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700">
                            Bayar Sekarang
                        </button>

                        <a href="{{ route('orders.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md text-sm">
                            Kembali
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
