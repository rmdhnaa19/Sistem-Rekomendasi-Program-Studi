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
        Schema::create('kasus_lama', function (Blueprint $table) {
                $table->id('id_kasus_lama');
                $table->string('kd_kasus_lama',50)->unique();
                $table->string('nama');
                $table->string('jurusan_asal');
                $table->decimal('nilai_rata_rata_rapor', 5, 2);
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
                $table->string('nama_prodi');
            
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kasus_lama');
    }
};
