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
        Schema::create('operator_pts', function (Blueprint $table) {
            $table->id('id_op')->primary();
            $table->string('kode_pt', 15);
            $table->string('username', 20);
            $table->string('password', 20);

            $table->foreign('kode_pt')->references('kode_pt')->on('perguruan_tinggis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operator_pts');
    }
};
