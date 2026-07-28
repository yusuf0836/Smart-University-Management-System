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
        Schema::table('results', function (Blueprint $table) {

            // Remove old columns
            $table->dropColumn([
                'marks',
                'grade',
                'grade_point',
            ]);

            // Add new foreign keys
            $table->foreignId('student_id')
                ->after('enrollment_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('semester_id')
                ->after('student_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('academic_session_id')
                ->after('semester_id')
                ->constrained()
                ->cascadeOnDelete();

            // Result summary
            $table->decimal('total_credit', 5, 2)->default(0);

            $table->decimal('earned_credit', 5, 2)->default(0);

            $table->decimal('total_grade_point', 6, 2)->default(0);

            $table->decimal('gpa', 3, 2)->default(0);

            $table->enum('result_status', [
                'Pass',
                'Fail',
            ])->default('Pass');

            $table->boolean('status')->default(true);

            $table->softDeletes();

            $table->unique([
                'student_id',
                'semester_id',
                'academic_session_id'
            ], 'student_semester_result_unique');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {

            $table->dropUnique('student_semester_result_unique');

            $table->dropForeign(['student_id']);
            $table->dropForeign(['semester_id']);
            $table->dropForeign(['academic_session_id']);

            $table->dropColumn([
                'student_id',
                'semester_id',
                'academic_session_id',
                'total_credit',
                'earned_credit',
                'total_grade_point',
                'gpa',
                'result_status',
                'status',
                'deleted_at',
            ]);

            $table->decimal('marks', 5, 2);

            $table->string('grade');

            $table->decimal('grade_point', 3, 2);
        });
    }
};