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
        Schema::create('logbook_keuangans', function (Blueprint $table) {
            $table->id('id_lbkeu')->primary();
            $table->integer('id_pkm');
            $table->date('tanggal');
            $table->text('ket_item');
            $table->bigInteger('harga');
            $table->string('bukti');

            $table->foreign('id_pkm')->references('id_pkm')->on('detail_pkms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook_keuangans');
    }
};
