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
        Schema::create('layanan_alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // The name of the alumni
            $table->string('prodi'); // The prodi of the alumni
            $table->string('tahun_lulus'); // The year of graduation of the alumni
            $table->string('divisi'); // The division of the alumni
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_alumnis');
    }
};
