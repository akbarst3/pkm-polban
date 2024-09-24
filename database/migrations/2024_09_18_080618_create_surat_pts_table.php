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
            $table->string('file_surat', 1024);
            $table->integer('tipe_id');
            $table->string('kode_pt', 6);

            $table->foreign('tipe_id')->references('id')->on('tipe_surats');
            $table->foreign('kode_pt')->references('kode_pt')->on('perguruan_tinggis');
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
