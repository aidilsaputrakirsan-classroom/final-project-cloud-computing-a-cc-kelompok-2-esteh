<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi: membuat tabel 'order_items'
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel orders
            $table->foreignId('order_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Relasi ke tabel products
            $table->foreignId('product_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Jumlah produk yang dipesan
            $table->integer('quantity')->default(1);

            // Harga produk saat dipesan
            $table->decimal('price', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Rollback migrasi: hapus tabel 'order_items'
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
