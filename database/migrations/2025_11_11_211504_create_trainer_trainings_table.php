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
        Schema::create('trainer_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained('trainers')->cascadeOnDelete();

            $table->enum('type', [
                'training_package',
                'pedagogical',
                'assessor',
                'technical',
                'cross_cutting'
            ]);

            $table->string('title')->nullable();
            $table->string('provider')->nullable();
            $table->integer('hours')->nullable();
            $table->string('institution')->nullable();
            $table->string('company')->nullable();
            $table->string('status')->nullable(); // certified / not / done / not done
            $table->text('details')->nullable();

            // Dates
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();

            $table->boolean('evidence')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_trainings');
    }
};
