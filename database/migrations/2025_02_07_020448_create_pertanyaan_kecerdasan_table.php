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
        Schema::create('pertanyaan_kecerdasan', function (Blueprint $table) {
            $table->id('id_pertanyaan_kecerdasan');
            $table->string('pertanyaan', 50)->unique();
            $table->unsignedBigInteger('id_kecerdasan_majemuk')->index();

            $table->foreign('id_kecerdasan_majemuk')->references('id_kecerdasan_majemuk')->on('kecerdasan_majemuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_kecerdasan');
    }
};
