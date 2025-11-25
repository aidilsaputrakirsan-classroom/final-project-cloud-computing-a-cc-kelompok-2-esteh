<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade'); // User yang melakukan aksi

            $table->string('action'); 
            // Contoh nilai: create_account, order, payment, update_profile, login, logout

            $table->string('description')->nullable(); 
            // Penjelasan singkat aktivitas, misal: "User melakukan pemesanan"

            $table->text('detail')->nullable(); 
            // Informasi tambahan, bisa JSON, misal: {"order_id":1,"total":50000}

            $table->timestamps(); 
            // created_at = waktu aktivitas terjadi
            // updated_at biasanya tidak dipakai untuk log
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
