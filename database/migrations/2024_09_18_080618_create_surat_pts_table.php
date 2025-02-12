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
        Schema::create('surat_pts', function (Blueprint $table) {
            $table->id();
            $table->integer('id_tipe');
            $table->string('kode_pt');
            $table->string('file_surat');

            $table->foreign('id_tipe')->references('id')->on('tipe_surats');
            $table->foreign('kode_pt')->references('kode_pt')->on('perguruan_tinggis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pts');
    }
};
