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
            $table->id();
            $table->integer('id_pkm');
            $table->integer('waktu_pelaksanaan');
            $table->string('kota_pengesahan');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('NIP');

            $table->foreign('id_pkm')->references('id')->on('detail_pkms');
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
