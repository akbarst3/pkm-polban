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
            $table->string('username', 20);
            $table->string('password', 20);
            $table->string('alamat');
            $table->string('kode_pos', 5);
            $table->string('no_hp', 50);
            $table->string('telp_rumah', 50);
            $table->string('email');
            $table->string('no_ktp');
            $table->char('jenis_kelamin', 1);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
    
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
