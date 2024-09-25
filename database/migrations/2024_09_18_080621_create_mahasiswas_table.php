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
            $table->string('nim', 20)->primary();
            $table->integer('id_pkm');
            $table->string('kode_prodi', 50);
            $table->string('nama', 100);
            $table->string('angkatan', 4);
            $table->string('prodi', 5);

            $table->foreign('id_pkm')->references('id_pkm')->on('detail_pkms');
            $table->foreign('kode_prodi')->references('kode_prodi')->on('program_studis');
            $table->timestamps();
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
