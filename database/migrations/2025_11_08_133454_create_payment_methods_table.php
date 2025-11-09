<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi: membuat tabel payment_methods
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Nama tampilan, misal "DANA", "Bank Transfer"
            $table->string('code')->unique();    // Kode unik internal, misal "dana", "bank", "ovo"
            $table->boolean('active')->default(true); // Apakah metode ini aktif dan bisa dipilih user
            $table->json('config')->nullable();  // Bisa untuk menyimpan info tambahan (VA, nomor rekening, dsb)
            $table->timestamps();
        });
    }

    /**
     * Rollback migrasi: hapus tabel payment_methods
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
