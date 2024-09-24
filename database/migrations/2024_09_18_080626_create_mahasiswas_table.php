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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->string('nim', 10)->primary();
            $table->string('nama', 100);
            $table->string('angkatan', 4);
            $table->string('prodi', 5);
            $table->integer('pkm_id')->nullable();

            $table->foreign('prodi')->references('id')->on('program_studis');
            $table->foreign('pkm_id')->references('id')->on('detail_pkms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
