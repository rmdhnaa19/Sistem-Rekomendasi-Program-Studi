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
        if (!Schema::hasTable('normalisasi')) {
            Schema::create('normalisasi', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_kasus_lama');
                $table->string('kd_kasus_lama',50)->unique();
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
                $table->integer('kec_eksistensial')->default(0);
                $table->unsignedBigInteger('id_prodi')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('normalisasi');
    }
};
