<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {       
            $table->id();
            $table->string('name');            // Nama metode (Transfer Bank, Dana, Ovo, dll)
            $table->string('code')->unique();  // Kode (BANK, DANA, OVO, COD) 
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
