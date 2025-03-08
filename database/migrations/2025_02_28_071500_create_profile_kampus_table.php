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
        Schema::create('profile_kampus', function (Blueprint $table) {
            $table->id('id_profile_kampus');
            $table->string('logo')->nullable(); // Menyimpan URL/logo
            $table->string('welcome_text')->nullable(); // Menyimpan teks "Selamat Datang!"
            $table->text('info_text')->nullable(); // Menyimpan teks informasi
            $table->string('youtube_link')->nullable(); // Menyimpan link YouTube
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_kampus');
    }
};
