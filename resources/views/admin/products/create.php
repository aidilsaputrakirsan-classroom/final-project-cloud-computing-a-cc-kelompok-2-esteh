<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Produk</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block">Nama Produk</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ old('name') }}">
                    @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block">Keterangan</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block">Harga</label>
                    <input type="number" step="0.01" name="price" class="w-full border rounded px-3 py-2" value="{{ old('price') }}">
                    @error('price') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block">Gambar</label>
                    <input type="file" name="image">
                    @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layout>
