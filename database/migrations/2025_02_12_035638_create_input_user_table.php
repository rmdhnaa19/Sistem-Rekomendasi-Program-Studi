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
        Schema::create('input_user', function (Blueprint $table) {
            $table->id('id_input_user');
            $table->string('nama');
            $table->decimal('nilai_rapor', 5, 2);
            $table->string('jurusan_asal');
            $table->string('prestasi');
            $table->string('organisasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_user');
    }
};
