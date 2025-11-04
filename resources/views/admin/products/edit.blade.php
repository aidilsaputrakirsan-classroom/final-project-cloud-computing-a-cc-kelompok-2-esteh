<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-700 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <a href="{{ route('admin.products.index') }}" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded shadow-sm mb-4 inline-block">
                    ⬅️ Kembali
                </a>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-1">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                               class="w-full border-gray-300 rounded px-3 py-2 focus:ring-green-500 focus:border-green-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-medium mb-1">Deskripsi</label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full border-gray-300 rounded px-3 py-2 focus:ring-green-500 focus:border-green-500">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 font-medium mb-1">Harga</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01"
                               class="w-full border-gray-300 rounded px-3 py-2 focus:ring-green-500 focus:border-green-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 font-medium mb-1">Gambar Produk</label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full border-gray-300 rounded px-3 py-2">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" class="mt-2 w-32 h-32 object-cover">
                        @endif
                    </div>

                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow-sm">
                        Update Produk
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
