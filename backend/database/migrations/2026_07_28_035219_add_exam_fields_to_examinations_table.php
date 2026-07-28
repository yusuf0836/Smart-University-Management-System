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
        Schema::table('examinations', function (Blueprint $table) {

            $table->foreignId('academic_session_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('course_id')
                ->nullable()
                ->after('semester_id')
                ->constrained()
                ->nullOnDelete();

            $table->decimal('total_marks', 5, 2)
                ->default(100)
                ->after('venue');

            $table->decimal('pass_marks', 5, 2)
                ->default(40)
                ->after('total_marks');

            $table->text('remarks')
                ->nullable()
                ->after('status');

            $table->unique(
                [
                    'academic_session_id',
                    'course_id',
                    'exam_type'
                ],
                'exam_unique'
            );

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {

            $table->dropUnique('exam_unique');

            $table->dropColumn([
                'total_marks',
                'pass_marks',
                'remarks'
            ]);

            $table->dropConstrainedForeignId('course_id');

            $table->dropConstrainedForeignId('academic_session_id');

        });
    }
};