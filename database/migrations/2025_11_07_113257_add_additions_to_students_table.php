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
        Schema::table('students', function (Blueprint $table) {
            //
            $table->integer('id_number')->unique()->after('student_id');
            $table->unsignedBigInteger('intake_id');
            $table->foreign('intake_id')->references('id')->on('intakes')->onDelete('cascade');
            $table->integer('phone_next_of_kin')->after('phone');
            $table->string('address')->after('email');
            $table->boolean('disability')->default(false)->after('status');
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->after('disability');
            $table->string('education_level')->after('marital_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
};
