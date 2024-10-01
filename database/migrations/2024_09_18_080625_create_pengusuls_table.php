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
            $table->string('nim');
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('telp_rumah')->nullable();
            $table->string('email')->nullable();
            $table->string('no_ktp')->nullable();
            $table->char('jenis_kelamin', 1)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
    
            $table->foreign('nim')->references('nim')->on('mahasiswas');
            $table->timestamps();
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
