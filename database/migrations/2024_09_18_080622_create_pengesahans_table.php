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
        Schema::create('pengesahans', function (Blueprint $table) {
            $table->id('id_pengesahan')->primary();
            $table->integer('id_pkm');
            $table->integer('waktu_pelaksanaan');
            $table->string('kota_pengesahan');
            $table->string('nama');
            $table->string('jabatan', 255);
            $table->string('NIP', 255);

            $table->foreign('id_pkm')->references('id_pkm')->on('detail_pkms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengesahans');
    }
};
