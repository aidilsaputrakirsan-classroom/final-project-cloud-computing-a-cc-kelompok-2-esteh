<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi: membuat tabel 'orders'
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Status pesanan: pending, paid, cancelled, dll
            $table->string('status')->default('pending');

            // Total harga seluruh item
            $table->decimal('total', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Rollback migrasi: hapus tabel 'orders'
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
