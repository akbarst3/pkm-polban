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
            $table->id();
            $table->date('tanggal');
            $table->text('ket_item');
            $table->decimal('harga', 15, 2);
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
        Schema::dropIfExists('logbook_keuangans');
    }
};
