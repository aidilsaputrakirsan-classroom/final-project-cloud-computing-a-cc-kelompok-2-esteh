<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Nasi Goreng',
            'description' => 'Nasi goreng spesial dengan telur dan ayam',
            'price' => 15000,
            'image' => null,
        ]);

        Product::create([
            'name' => 'Es Teh Manis',
            'description' => 'Segelas es teh manis dingin',
            'price' => 5000,
            'image' => null,
        ]);

        // Tambah produk lain sesuai kebutuhan
    }
}
