<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-700 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">🍽️ {{ __('Dashboard') }}</span>

            <!-- Tombol kembali ke welcome -->
            <a href="/"
               class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded shadow-sm transition">
                ⬅️ Kembali ke Beranda
            </a>
        </h2>
    </x-slot>

    <style>
        .menu-card {
            transition: 0.3s;
            border-radius: 12px;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .icon-box {
            font-size: 40px;
            margin-bottom: 10px;
        }
    </style>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h1 class="text-3xl font-extrabold text-green-700 mb-6">
                    Selamat Datang, {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-gray-600 mb-5">
                    Pilih menu untuk melanjutkan:
                </p>

                @if(auth()->user()->role === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <a href="{{ route('admin.products.index') }}" class="menu-card bg-green-500 text-white p-6 text-center">
                        <div class="icon-box">🍔</div>
                        <h3 class="font-bold text-xl">Kelola Produk</h3>
                        <p>Tambahkan, edit, dan hapus menu makanan/minuman.</p>
                    </a>

<a href="{{ route('admin.orders.index') }}" class="menu-card bg-yellow-500 text-white p-6 text-center">
    <div class="icon-box">📦</div>
    <h3 class="font-bold text-xl">Monitoring Pesanan</h3>
    <p>Lihat status pesanan pelanggan.</p>
</a>


                    <a href="{{ route('admin.users.index') }}" class="menu-card bg-blue-500 text-white p-6 text-center">
                        <div class="icon-box">👥</div>
                        <h3 class="font-bold text-xl">Kelola User</h3>
                        <p>Kelola data pelanggan dan admin.</p>
                    </a>

                </div>

                @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <a href="{{ route('products.menu') }}" class="menu-card bg-green-600 text-white p-6 text-center">
                        <div class="icon-box">🍽️</div>
                        <h3 class="font-bold text-xl">Pesan Makanan</h3>
                        <p>Lihat menu dan lakukan pemesanan.</p>
                    </a>

                    <a href="{{ route('orders.index') }}" class="menu-card bg-blue-600 text-white p-6 text-center">
                        <div class="icon-box">🧾</div>
                        <h3 class="font-bold text-xl">Pesanan Saya</h3>
                        <p>Lihat riwayat dan status pesanan kamu.</p>
                    </a>

                </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
