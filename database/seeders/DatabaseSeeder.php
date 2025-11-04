<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- USERS ---
        // Admin
        User::create([
            'name' => 'Admin Lokalicious',
            'email' => 'admin@lokalicious.com',
            'password' => bcrypt('admin123'), // ganti sesuai keinginan
            'role' => 'admin',
        ]);

        // User biasa / pelanggan
        User::create([
            'name' => 'User Lokalicious',
            'email' => 'user@lokalicious.com',
            'password' => bcrypt('user123'), // ganti sesuai keinginan
            'role' => 'user',
        ]);

        // --- PRODUK ---
        $products = [
            [
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng lengkap dengan telur, ayam, dan sayuran',
                'price' => 15000,
                'image' => 'products/nasgor.png',
            ],
            [
                'name' => 'Mie Ayam Bakso',
                'description' => 'Mie ayam dengan bakso kenyal dan kuah sedap',
                'price' => 12000,
                'image' => 'products/mie-ayam-bakso.jpg',
            ],
            [
                'name' => 'Es Teh Manis',
                'description' => 'Segelas es teh manis dingin',
                'price' => 5000,
                'image' => "products/Es-Teh-Manis.jpg",
            ],
            [
                'name' => 'Jus Alpukat',
                'description' => 'Jus alpukat segar dengan susu',
                'price' => 10000,
                'image' => "products/Jus-Alpukat.jpg",
            ],
            [
                'name' => 'Ayam Goreng Crispy',
                'description' => 'Ayam goreng renyah dan gurih',
                'price' => 20000,
                'image' => "products/ayam-crispy.jpg",
            ],
            [
                'name' => 'Kopi Hitam',
                'description' => 'Kopi hitam panas tanpa gula',
                'price' => 8000,
                'image' => "products/Kopi-Hitam.jpg",
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
