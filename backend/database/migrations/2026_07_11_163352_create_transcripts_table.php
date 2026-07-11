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
        Schema::create('transcripts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('semester_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('semester_gpa', 3, 2)->default(0);

            $table->decimal('cgpa', 3, 2)->default(0);

            $table->decimal('total_credits', 5, 2)->default(0);

            $table->enum('status', [
                'Published',
                'Pending'
            ])->default('Pending');

            $table->timestamps();

            $table->softDeletes();

            $table->unique(['student_id', 'semester_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transcripts');
    }
};