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
        Schema::create('detail_pkms', function (Blueprint $table) {
            $table->id();
            $table->integer('id_skema');
            // $table->string('nim', 20);
            $table->string('judul');
            $table->bigInteger('dana_kemdikbud');
            $table->bigInteger('dana_pt');
            $table->bigInteger('dana_lain');
            $table->string('instansi_lain');
            $table->boolean('val_dospem')->default(false);
            $table->boolean('val_pt')->default(false);
            $table->string('proposal');
            $table->string('lapkem');
            $table->string('lapkhir');

            $table->foreign('id_skema')->references('id')->on('skema_pkms');
            // $table->foreign('nim')->references('nim')->on('mahasiswas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pkms');
    }
};
