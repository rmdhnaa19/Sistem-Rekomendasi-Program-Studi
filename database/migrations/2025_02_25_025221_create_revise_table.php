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
        Schema::create('revise', function (Blueprint $table) {
            $table->id('id_revise');
            $table->string('kd_revise', 50)->unique();
            $table->string('nama');
            $table->string('jurusan_asal');
            $table->float('nilai_rata_rata_rapor');
            $table->string('prestasi')->nullable();
            $table->string('organisasi')->nullable();
            // Kolom untuk menyimpan skor tiap kecerdasan
            $table->integer('kec_linguistik')->default(0);
            $table->integer('kec_musikal')->default(0);
            $table->integer('kec_logika_matematis')->default(0);
            $table->integer('kec_spasial')->default(0);
            $table->integer('kec_kinestetik')->default(0);
            $table->integer('kec_interpersonal')->default(0);
            $table->integer('kec_intrapersonal')->default(0);
            $table->integer('kec_naturalis')->default(0);
            $table->string('prodi')->nullable();

            // Similarity score (untuk melihat seberapa dekat dengan kasus lama)
            $table->float('similarity_score')->default(0);

            // Status revisi (misalnya: pending, direvisi, disetujui)
            $table->enum('status', ['pending', 'direvisi', 'disetujui'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revise');
    }
};
