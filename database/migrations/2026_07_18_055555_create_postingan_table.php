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
        Schema::create('postingan', function (Blueprint $table) {
            $table->id();
            
            // Kolom user_id diizinkan kosong (nullable) agar tidak error saat input
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            
            // Tipe data text agar bisa menampung link yang sangat panjang
            $table->text('link');
            
            $table->string('judul');
            $table->foreignId('jenis_konten_id')->constrained('jenis_konten');
            $table->foreignId('sumber_konten_id')->constrained('sumber_konten');
            
            // Nama kolom disesuaikan menjadi tagar agar sinkron dengan form HTML
            $table->string('tagar')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postingan');
    }
};