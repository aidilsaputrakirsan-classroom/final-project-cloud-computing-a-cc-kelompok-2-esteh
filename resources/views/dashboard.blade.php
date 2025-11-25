<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-700">
                Dashboard
            </h2>

            <a href="/"
                class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 text-sm">
                Kembali ke Beranda
            </a>
        </div>
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

            <div class="bg-white dark:bg-gray-800 dark:text-gray-200 shadow-sm rounded-lg p-6">
                <h1 class="text-3xl font-extrabold text-green-700 mb-6">
                    Selamat Datang, {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-gray-600 mb-5">
                    Pilih menu untuk melanjutkan:
                </p>

                @if(auth()->user()->role === 'admin')
                <!-- GRID UNTUK ADMIN -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Kelola Produk -->
                    <a href="{{ route('admin.products.index') }}" class="menu-card bg-green-500 text-white p-6 text-center">
                        <div class="icon-box">🍔</div>
                        <h3 class="font-bold text-xl">Kelola Produk</h3>
                        <p>Tambahkan, edit, dan hapus menu makanan/minuman.</p>
                    </a>

                    <!-- Monitoring Pesanan -->
                    <a href="{{ route('admin.orders.index') }}" class="menu-card bg-yellow-500 text-white p-6 text-center">
                        <div class="icon-box">📦</div>
                        <h3 class="font-bold text-xl">Monitoring Pesanan</h3>
                        <p>Lihat status pesanan pelanggan.</p>
                    </a>

                    <!-- Metode Pembayaran -->
                    <a href="{{ route('admin.payment-methods.index') }}" class="menu-card bg-purple-500 text-white p-6 text-center">
                        <div class="icon-box">💳</div>
                        <h3 class="font-bold text-xl">Metode Pembayaran</h3>
                        <p>Kelola metode pembayaran (DANA, Bank, OVO, dll).</p>
                    </a>

                    <!-- Kelola User -->
                    <a href="{{ route('admin.users.index') }}" class="menu-card bg-blue-600 text-white p-6 text-center">
                        <div class="icon-box">👥</div>
                        <h3 class="font-bold text-xl">Kelola User</h3>
                        <p>Kelola akun pengguna, role, dan kontrol akses.</p>
                    </a>

                    <!-- Activity Log -->
                    <a href="{{ route('admin.activity-logs.index') }}" class="menu-card bg-gray-600 text-white p-6 text-center">
                        <div class="icon-box">📜</div>
                        <h3 class="font-bold text-xl">Activity Log</h3>
                        <p>Lihat semua aktivitas user dan admin.</p>
                    </a>

                </div>

                @else
                <!-- GRID UNTUK USER BIASA -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Menu Pesanan -->
                    <a href="{{ route('products.menu') }}" class="menu-card bg-green-600 text-white p-6 text-center">
                        <div class="icon-box">🍽️</div>
                        <h3 class="font-bold text-xl">Pesan Makanan</h3>
                        <p>Lihat menu dan lakukan pemesanan.</p>
                    </a>

                    <!-- Riwayat Pesanan -->
                    <a href="{{ route('orders.index') }}" class="menu-card bg-blue-600 text-white p-6 text-center">
                        <div class="icon-box">🧾</div>
                        <h3 class="font-bold text-xl">Pesanan Saya</h3>
                        <p>Lihat riwayat dan status pesanan kamu.</p>
                    </a>

                    <!-- Activity Log User -->
                    <a href="{{ route('activity-logs.user') }}" class="menu-card bg-gray-600 text-white p-6 text-center">
                        <div class="icon-box">📜</div>
                        <h3 class="font-bold text-xl">Activity Log</h3>
                        <p>Lihat aktivitas akunmu sendiri.</p>
                    </a>

                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
