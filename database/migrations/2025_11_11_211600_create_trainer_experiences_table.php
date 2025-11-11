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
        Schema::create('trainer_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained('trainers')->cascadeOnDelete();

            $table->enum('type', [
                'work_experience',
                'industrial_attachment',
                'delivery_history'
            ]);

            $table->string('position')->nullable();
            $table->string('institution')->nullable();
            $table->string('place')->nullable();
            $table->string('status')->nullable(); // permanent, contract…
            $table->string('sector')->nullable();
            $table->string('trade')->nullable();
            $table->text('core_responsibility')->nullable();

            // Dates
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->integer('days')->nullable();

            // Delivery fields
            $table->integer('times_assessed')->nullable();
            $table->integer('sessions_competent')->nullable();
            $table->string('master_trainer')->nullable();

            $table->boolean('evidence')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_experiences');
    }
};
