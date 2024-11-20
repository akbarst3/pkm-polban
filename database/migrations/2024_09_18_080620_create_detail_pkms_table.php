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
            $table->string('kode_pt');
            $table->string('kode_dosen');
            // $table->string('nim', 20);
            $table->string('judul');
            $table->bigInteger('dana_kemdikbud')->nullable();
            $table->bigInteger('dana_pt')->nullable();
            $table->bigInteger('dana_lain')->nullable();
            $table->string('instansi_lain')->nullable();
            $table->boolean('val_dospem')->nullable();
            $table->boolean('val_pt')->nullable();
            $table->string('proposal')->nullable();
            $table->string('lapkem')->nullable();
            $table->string('lapkhir')->nullable();

            $table->foreign('id_skema')->references('id')->on('skema_pkms');
            $table->foreign('kode_pt')->references('kode_pt')->on('perguruan_tinggis');
            $table->foreign('kode_dosen')->references('kode_dosen')->on('dosens');
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
