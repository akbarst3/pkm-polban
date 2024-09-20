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
            $table->string('judul', 255);
            $table->decimal('dana_kemdikbud', 15, 2)->nullable();
            $table->decimal('dana_pt', 15, 2)->nullable();
            $table->decimal('dana_lain', 15, 2)->nullable();
            $table->string('instansi_lain', 255)->nullable();
            $table->boolean('val_dospem')->default(false);
            $table->boolean('val_pt')->default(false);
            $table->binary('proposal')->nullable();
            $table->binary('lapkem')->nullable();
            $table->binary('lapkhir')->nullable();
            $table->integer('skema_id');
            $table->string('pengusul_id', 10);
            $table->integer('dospem_id')->nullable(); // Change to integer
            $table->string('pt_id', 6);

            $table->foreign('skema_id')->references('id')->on('skema_pkms');
            $table->foreign('dospem_id')->references('nidn')->on('dosen_pendampings'); // Ensure 'nidn' is integer
            $table->foreign('pt_id')->references('kode_pt')->on('perguruan_tinggis');
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
