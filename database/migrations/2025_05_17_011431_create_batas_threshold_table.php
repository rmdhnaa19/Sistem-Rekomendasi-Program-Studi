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
        if (!Schema::hasTable('batas_threshold')) {
            Schema::create('batas_threshold', function (Blueprint $table) {
                $table->id('id_batas_threshold');

                $table->decimal('nilai_threshold', 5, 2);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batas_threshold');
    }
};
