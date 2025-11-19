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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique(); // e.g. REG2025/001
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('class')->nullable();
            $table->string('academic_year')->nullable();
            $table->string('qualification_title')->nullable();
            $table->string('intake_no')->nullable();
            $table->string('intake_year')->nullable();
            $table->enum('status', ['active', 'inactive','graduated','dropped'])->default('active');
            $table->integer('id_number')->unique();
            $table->unsignedBigInteger('intake_id');
            $table->foreign('intake_id')->references('id')->on('intakes')->onDelete('cascade');
            $table->integer('phone_next_of_kin');
            $table->string('address');
            $table->boolean('disability')->default(false);
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->string('education_level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
