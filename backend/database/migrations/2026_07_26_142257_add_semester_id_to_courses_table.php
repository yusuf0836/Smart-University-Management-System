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
        Schema::table('courses', function (Blueprint $table) {

            $table->foreignId('semester_id')
                ->after('department_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {

            $table->dropForeign(['semester_id']);

            $table->dropIndex(['status']);

            $table->dropColumn('semester_id');
        });
    }
};