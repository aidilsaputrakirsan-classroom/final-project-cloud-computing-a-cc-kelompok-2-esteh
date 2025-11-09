<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-700">
                Makanan dan Minuman
            </h2>

            <a href="{{ route('dashboard') }}"
                class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="border rounded shadow hover:shadow-lg transition p-4 flex flex-col">

                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         class="w-full h-40 object-cover rounded mb-4">
                                @endif

                                <h3 class="font-bold text-lg mb-1">{{ $product->name }}</h3>
                                <p class="text-gray-600 mb-2">{{ $product->description }}</p>
                                <p class="mt-auto font-semibold text-gray-800">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>

                                <!-- Form dengan Quantity -->
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3">
                                    @csrf

                                    <div class="flex items-center gap-2">
                                        <input type="number" name="quantity" value="1" min="1"
                                            class="w-20 border rounded p-2 focus:ring-green-500 focus:border-green-500" required>
                                        
                                        <button type="submit"
                                            class="flex-1 text-center px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                            Tambah
                                        </button>
                                    </div>
                                </form>

                            </div>
                        @endforeach
                    </div>

                @else
                    <p class="text-center text-gray-500">Belum ada menu tersedia.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
