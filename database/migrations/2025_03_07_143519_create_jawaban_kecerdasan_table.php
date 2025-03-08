<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jawaban_kecerdasan', function (Blueprint $table) {
            $table->id('id_jawaban_kecerdasan'); // Primary Key
            $table->unsignedBigInteger('id_konsultasi')->index(); // Foreign Key ke konsultasi
            $table->unsignedBigInteger('id_pertanyaan_kecerdasan')->index(); // Foreign Key ke pertanyaan_kecerdasan
            $table->unsignedBigInteger('id_kecerdasan')->index(); // Foreign Key ke kecerdasan_majemuk
            $table->integer('poin'); // 1 jika YA, 0 jika TIDAK
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('id_konsultasi')->references('id_konsultasi')->on('konsultasi');
            $table->foreign('id_pertanyaan_kecerdasan')->references('id')->on('pertanyaan_kecerdasan');
            $table->foreign('id_kecerdasan_majemuk')->references('id')->on('kecerdasan_majemuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_kecerdasan');
    }
};
