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
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama', 50)->unique();
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('nip', 16);
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->date('tanggal_lahir');
            $table->string('no_hp', 12);
            $table->text('alamat');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
