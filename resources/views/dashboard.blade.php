<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <h1 class="text-2xl font-bold mb-4">Selamat Datang, {{ auth()->user()->name }}!</h1>

                @if(auth()->user()->role === 'admin')
                    <!-- Menu Admin -->
                    <div class="space-y-2">
                        <a href="{{ route('admin.products.index') }}" class="inline-block px-4 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Kelola Produk
                        </a>
                        <a href="{{ route('orders.index') }}" class="inline-block px-4 py-3 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Monitoring Pesanan
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="inline-block px-4 py-3 bg-green-600 text-white rounded hover:bg-green-700">
                            Kelola User
                        </a>
                    </div>
                @else
                    <!-- Menu User / Pelanggan -->
                    <div>
                        <a href="{{ route('products.menu') }}" class="inline-block px-4 py-3 bg-green-600 text-white rounded hover:bg-green-700">
                            Pesan Makanan / Minuman
                        </a>
                        <a href="{{ route('orders.index') }}" class="inline-block px-4 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 mt-2">
                            Pesanan Saya
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
