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
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id('id_konsultasi'); // Primary Key
            $table->string('nama');
            $table->float('nilai_rata_rata_rapor');
            $table->unsignedBigInteger('jurusan_asal'); // Foreign Key ke sub_kriteria
            $table->unsignedBigInteger('prestasi'); // Foreign Key ke sub_kriteria
            $table->unsignedBigInteger('organisasi'); // Foreign Key ke sub_kriteria
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('jurusan_asal')->references('id_sub_kriteria')->on('sub_kriteria')->onDelete('cascade');
            $table->foreign('prestasi')->references('id_sub_kriteria')->on('sub_kriteria')->onDelete('cascade');
            $table->foreign('organisasi')->references('id_sub_kriteria')->on('sub_kriteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};