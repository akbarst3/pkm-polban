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
            $table->id();
            $table->string('link_sosmed', 1024);
            $table->integer('pkm_id');
            $table->integer('tipe_id');

            $table->foreign('pkm_id')->references('id')->on('detail_pkms');
            $table->foreign('tipe_id')->references('id')->on('tipe_sosmeds');
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
