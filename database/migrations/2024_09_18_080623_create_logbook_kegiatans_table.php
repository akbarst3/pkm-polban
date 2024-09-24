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
        Schema::create('logbook_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->text('uraian_kegiatan');
            $table->integer('capaian');
            $table->integer('waktu');
            $table->binary('bukti')->nullable();
            $table->integer('pkm_id');

            $table->foreign('pkm_id')->references('id')->on('detail_pkms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook_kegiatans');
    }
};
