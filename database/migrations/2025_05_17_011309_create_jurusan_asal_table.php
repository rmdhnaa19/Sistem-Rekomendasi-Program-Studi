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
        if (!Schema::hasTable('jurusan_asal')) {
            Schema::create('jurusan_asal', function (Blueprint $table) {
                $table->id('id_jurusan_asal');
                $table->string('nama', 50);
                $table->unsignedInteger('nilai'); 
                $table->unsignedBigInteger('id_kriteria')->index();

                $table->foreign('id_kriteria')->references('id_kriteria')->on('kriteria');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan_asal');
    }
};
