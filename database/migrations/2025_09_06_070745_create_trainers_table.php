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
        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('qualification')->nullable();
            $table->text('bio')->nullable();
            // Personal info
            $table->enum('sex', ['male', 'female']);
            $table->enum('civil_status', ['single', 'married', 'divorced', 'widow']);
            $table->date('dob')->nullable();
            $table->string('id_or_passport');

            // School/Office
            $table->string('school_name')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('sector')->nullable();
            $table->enum('school_level', ['polytechnic', 'tss', 'vtc'])->nullable();
            $table->enum('school_status', ['public', 'government_aid', 'private'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainers');
    }
};
