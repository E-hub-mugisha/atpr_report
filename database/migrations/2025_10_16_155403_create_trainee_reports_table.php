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
        Schema::create('trainee_reports', function (Blueprint $table) {
            $table->id();
            $table->string('trainee_name')->nullable();
            $table->string('reg_no')->nullable();
            $table->string('academic_year')->nullable();
            $table->string('class')->nullable();
            $table->string('course_duration')->nullable();
            $table->string('qualification_title')->nullable();
            $table->float('english')->nullable();
            $table->float('francais')->nullable();
            $table->float('swahili')->nullable();
            $table->float('total_marks')->nullable();
            $table->float('percentage')->nullable();
            $table->string('decision')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainee_reports');
    }
};
