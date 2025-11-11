<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-700">
                Keranjang Belanja
            </h2>

            <a href="{{ route('dashboard') }}"
                class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white p-6 rounded shadow">
            @if($items->count() > 0)
                @foreach($items as $item)
                    <div class="border-b py-2 flex justify-between">
                        <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endforeach

                {{-- 📝 Tambahkan catatan pesanan --}}
                <form action="{{ route('cart.checkout') }}" method="GET" class="mt-4">
                    <label for="note" class="block text-gray-700 font-semibold mb-2">Catatan Pesanan (opsional)</label>
                    <textarea name="note" id="note" rows="3" class="w-full border rounded p-2 mb-4" placeholder="Contoh: Tidak terlalu manis, bungkus terpisah, dll">{{ old('note') }}</textarea>

                    <button type="submit" class="w-full bg-green-600 text-white text-center py-2 rounded hover:bg-green-700">
                        Checkout
                    </button>
                </form>
            @else
                <p class="text-gray-500 text-center">Keranjang kosong</p>
            @endif
        </div>
    </div>
</x-app-layout>
