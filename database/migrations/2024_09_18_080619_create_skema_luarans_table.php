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
            $table->integer('skema_id');
            $table->integer('luaran_id');
            $table->primary(['skema_id', 'luaran_id']);

            $table->foreign('skema_id')->references('id')->on('skema_pkms');
            $table->foreign('luaran_id')->references('id')->on('luaran_pkms');
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
