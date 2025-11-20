<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
           <h2 class="font-semibold text-xl text-green-700">
                Manajemen Kelola Produk
            </h2>

            <a href="{{ route('dashboard') }}"
                class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('admin.products.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-2 inline-block">
                Tambah Produk
            </a>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 dark:text-gray-200 p-6 rounded shadow">

                <table class="w-full table-auto dark:text-gray-200">
                    <thead>
                        <tr>
                            <th class="border dark:border-gray-600 px-4 py-2">Nama</th>
                            <th class="border dark:border-gray-600 px-4 py-2">Harga</th>
                            <th class="border dark:border-gray-600 px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="border dark:border-gray-600 px-4 py-2">{{ $product->name }}</td>
                            <td class="border dark:border-gray-600 px-4 py-2">{{ number_format($product->price,0,',','.') }}</td>
                            <td class="border dark:border-gray-600 px-4 py-2">
                                <div class="flex flex-wrap gap-2 justify-center">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded text-sm">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
