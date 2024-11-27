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
        Schema::create('skema_luarans', function (Blueprint $table) {
            $table->integer('id_skema');
            $table->integer('id_luaran');
            $table->primary(['id_skema', 'id_luaran']);
            $table->foreign('id_skema')->references('id')->on('skema_pkms');
            $table->foreign('id_luaran')->references('id')->on('luaran_pkms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skema_luarans');
    }
};
