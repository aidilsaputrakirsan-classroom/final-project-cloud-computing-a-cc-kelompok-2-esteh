<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // user yg melakukan aksi
            $table->string('action'); // contoh: create, update, delete, login, logout
            $table->text('description')->nullable(); // penjelasan singkat
            $table->text('detail')->nullable(); // detail tambahan (JSON atau teks)
            $table->timestamps(); // created_at = timestamp
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
