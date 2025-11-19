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
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->foreignId('trainer_id')->constrained('trainers')->onDelete('cascade');
            $table->integer('i_a')->nullable();
            $table->integer('f_a')->nullable();
            $table->integer('c_a')->nullable();
            $table->integer('total')->nullable();
            $table->integer('reass')->nullable();
            $table->enum('remarks', ['Pass', 'Fail', 'Distinction', 'Merit'])->nullable();
            $table->enum('obs', ['Improvement Needed', 'Good Performance', 'Excellent Performance', 'Satisfactory'])->nullable();
            $table->enum('decision', ['C', 'NYC'])->default('NYC');
            $table->boolean('reassessment_needed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
