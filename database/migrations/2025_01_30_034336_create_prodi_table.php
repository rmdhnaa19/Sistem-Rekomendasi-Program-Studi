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
        Schema::create('prodi', function (Blueprint $table) {
            $table->id('id_prodi');
            $table->string('nama_prodi', 50)->unique();
            $table->unsignedBigInteger('id_jurusan')->index();
            $table->string('akreditasi', 10);
            $table->string('jenjang', 50);
            $table->string('durasi_studi', 50);
            $table->text('deskripsi');

            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
