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
        Schema::table('notices', function (Blueprint $table) {

            $table->enum('category', [
                'Academic',
                'Examination',
                'Holiday',
                'Event',
                'Admission',
                'Scholarship',
                'General',
                'Emergency',
            ])->default('General')->after('description');

            $table->enum('audience', [
                'All',
                'Admin',
                'Teacher',
                'Student',
            ])->default('All')->after('category');

            $table->boolean('is_pinned')
                ->default(false)
                ->after('expiry_date');

            $table->string('attachment')
                ->nullable()
                ->after('is_pinned');

            $table->foreignId('created_by')
                ->nullable()
                ->after('attachment')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notices', function (Blueprint $table) {

            $table->dropForeign(['created_by']);

            $table->dropColumn([
                'category',
                'audience',
                'is_pinned',
                'attachment',
                'created_by',
            ]);
        });
    }
};