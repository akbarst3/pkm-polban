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
        Schema::create('dosen_pendampings', function (Blueprint $table) {
            $table->string('kode_dosen');
            $table->string('username');
            $table->string('password');
            $table->foreign('kode_dosen')->references('kode_dosen')->on('dosens');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_pendampings');
    }
};
