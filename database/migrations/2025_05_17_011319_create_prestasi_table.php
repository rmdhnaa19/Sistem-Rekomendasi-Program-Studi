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
        if (!Schema::hasTable('prestasi')) {
            Schema::create('prestasi', function (Blueprint $table) {
                $table->id('id_prestasi');
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
        Schema::dropIfExists('prestasi');
    }
};
