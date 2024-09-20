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
        Schema::create('pengusuls', function (Blueprint $table) {
            $table->string('mahasiswa_nim', 10);
            $table->string('username', 20);
            $table->string('password', 20);
            $table->string('alamat', 1024);
            $table->string('kode_pos', 1024);
            $table->string('no_hp', 15);
            $table->string('telp_rumah', 15);
            $table->string('email');
            $table->string('no_ktp');
            $table->char('jenis_kelamin');
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->integer('pkm_id');
            
            $table->primary('mahasiswa_nim');
            $table->foreign('pkm_id')->references('id')->on('detail_pkms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengusuls');
    }
};
