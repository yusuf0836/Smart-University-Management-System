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
        Schema::create('teacher_course_assignments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('teacher_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('course_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('semester_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('academic_session_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('section',20);

            $table->date('assigned_date');

            $table->boolean('status')
                ->default(true)
                ->index();

            $table->text('remarks')
                ->nullable();

            $table->softDeletes();

            $table->timestamps();

            $table->unique(
                [
                    'teacher_id',
                    'course_id',
                    'semester_id',
                    'academic_session_id',
                    'section'
                ],
                'teacher_course_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_course_assignments');
    }
};