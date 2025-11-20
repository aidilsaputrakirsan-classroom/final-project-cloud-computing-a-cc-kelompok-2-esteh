<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Pembayaran Pesanan #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-6">

                <p class="mb-2 text-gray-700 dark:text-gray-300">Total Pembayaran:</p>
                <h3 class="text-3xl font-extrabold text-green-600 dark:text-green-400 mb-6">
                    Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}
                </h3>

                <form action="{{ route('orders.payment.process', $order->id) }}" 
                      method="POST" 
                      class="space-y-6">
                    @csrf

                    <p class="font-semibold text-gray-700 dark:text-gray-300">
                        Pilih Metode Pembayaran:
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                        @foreach($methods as $m)
                        <label class="cursor-pointer">
                            <input type="radio" 
                                   name="method" 
                                   value="{{ $m->code }}" 
                                   class="hidden peer" 
                                   required>

                            <div
                                class="border rounded-xl p-4 flex items-center gap-3 
                                       bg-gray-50 dark:bg-gray-700 
                                       peer-checked:border-green-500 
                                       peer-checked:bg-green-50 
                                       dark:peer-checked:bg-green-900/30 
                                       transition">

                                <div class="w-10 h-10 flex items-center justify-center 
                                            rounded-full 
                                            bg-white dark:bg-gray-600 shadow">
                                    🏦
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $m->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 uppercase">
                                        {{ $m->code }}
                                    </p>
                                </div>
                            </div>
                        </label>
                        @endforeach

                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-3 bg-green-600 hover:bg-green-700 
                               text-white font-bold rounded-lg text-lg transition">
                        Bayar Sekarang
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
