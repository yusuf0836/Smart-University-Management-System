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
        Schema::table('transcripts', function (Blueprint $table) {

            // Remove calculated data
            $table->dropColumn([
                'semester_gpa',
                'cgpa',
                'total_credits',
            ]);

            // Transcript Metadata
            $table->string('transcript_no')->unique()->after('semester_id');

            $table->foreignId('generated_by')
                ->nullable()
                ->after('transcript_no')
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('generated_at')
                ->nullable()
                ->after('generated_by');

            $table->string('pdf_path')
                ->nullable()
                ->after('generated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transcripts', function (Blueprint $table) {

            $table->dropForeign(['generated_by']);

            $table->dropColumn([
                'transcript_no',
                'generated_by',
                'generated_at',
                'pdf_path',
            ]);

            $table->decimal('semester_gpa', 3, 2)->default(0);

            $table->decimal('cgpa', 3, 2)->default(0);

            $table->decimal('total_credits', 5, 2)->default(0);
        });
    }
};