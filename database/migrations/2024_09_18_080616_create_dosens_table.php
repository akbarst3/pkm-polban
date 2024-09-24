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
        Schema::create('dosens', function (Blueprint $table) {
            $table->string('nidn', 15)->primary();
            $table->string('nama', 100);
            $table->string('no_hp', 15);
            $table->string('email');
            $table->string('prodi_id', 5);

            $table->foreign('prodi_id')->references('id')->on('program_studis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
