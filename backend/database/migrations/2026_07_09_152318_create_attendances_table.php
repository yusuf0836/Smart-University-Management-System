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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('course_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('semester_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('attendance_date');

            $table->enum('status', [
                'Present',
                'Absent',
                'Late'
            ]);

            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique([
                'student_id',
                'course_id',
                'semester_id',
                'attendance_date'
            ], 'attendance_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};