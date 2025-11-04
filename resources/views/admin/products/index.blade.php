<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-700 leading-tight">
            {{ __('Kelola Produk') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <a href="{{ route('admin.products.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-2 inline-block">
        Tambah Produk
    </a>

        <a href="{{ route('dashboard') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mb-4 inline-block hover:bg-gray-300 shadow-sm mt-2">
        ⬅️ Kembali ke Dashboard
    </a>
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <table class="w-full table-auto">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Nama</th>
                            <th class="border px-4 py-2">Harga</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="border px-4 py-2">{{ $product->name }}</td>
                            <td class="border px-4 py-2">{{ number_format($product->price,0,',','.') }}</td>
                           <td class="border px-4 py-2">
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
