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
        Schema::create('tracer_study_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->references('id')->on('tracer_study_questions')->onDelete('cascade'); // The question id
            $table->string('value'); // The option value
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_study_options');
    }
};
