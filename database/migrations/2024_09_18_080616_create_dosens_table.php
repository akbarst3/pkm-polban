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
        Schema::create('dosens', function (Blueprint $table) {
            $table->string('kode_dosen')->primary();
            $table->string('kode_prodi');
            $table->string('nama');
            $table->string('no_hp');
            $table->string('email');

            $table->foreign('kode_prodi')->references('kode_prodi')->on('program_studis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
