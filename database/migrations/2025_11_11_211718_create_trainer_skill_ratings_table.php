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
        Schema::create('trainer_skill_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained('trainers')->cascadeOnDelete();

            $table->enum('skill_type', ['language', 'computer']);

            // For languages: reading/speaking/writing (0–5)
            $table->string('skill_name');
            $table->integer('reading')->nullable();
            $table->integer('speaking')->nullable();
            $table->integer('writing')->nullable();

            // For computer skills: poor / good / very good
            $table->enum('computer_level', ['poor', 'good', 'very_good'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_skill_ratings');
    }
};
