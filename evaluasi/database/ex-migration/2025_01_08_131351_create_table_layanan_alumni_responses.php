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
        Schema::create('layanan_alumni_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->references('id')->on('layanan_alumnis')->onDelete('cascade'); // The alumni id
            $table->string('question_id'); // The question id
            $table->string('response_value'); // The response value
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_alumni_responses');
    }
};
