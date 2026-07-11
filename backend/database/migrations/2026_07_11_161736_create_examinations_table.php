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
        Schema::create('examinations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('department_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('semester_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('exam_name');

            $table->enum('exam_type', [
                'Mid',
                'Final',
                'Quiz',
                'Assignment',
                'Practical',
                'Viva',
                'Improvement'
            ]);

            $table->date('exam_date');

            $table->time('start_time');

            $table->time('end_time');

            $table->string('venue')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};