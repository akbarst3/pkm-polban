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
        Schema::create('sosial_media', function (Blueprint $table) {
            $table->id('id_smd')->primary();
            $table->integer('id_sosmed');
            $table->integer('id_pkm');
            $table->string('link_sosmed');

            $table->foreign('id_pkm')->references('id_pkm')->on('detail_pkms');
            $table->foreign('id_sosmed')->references('id_sosmed')->on('tipe_sosmeds');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sosial_media');
    }
};
