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
        Schema::table('students', function (Blueprint $table) {

            $table->foreignId('academic_session_id')
                ->after('semester_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('blood_group', 5)
                ->nullable()
                ->after('admission_date');

            $table->string('guardian_name')
                ->nullable()
                ->after('blood_group');

            $table->string('guardian_phone')
                ->nullable()
                ->after('guardian_name');

            $table->text('address')
                ->nullable()
                ->after('guardian_phone');

            $table->string('photo')
                ->nullable()
                ->after('address');

            $table->index('academic_session_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {

            $table->dropIndex(['academic_session_id']);
            $table->dropIndex(['status']);

            $table->dropConstrainedForeignId('academic_session_id');

            $table->dropColumn([
                'blood_group',
                'guardian_name',
                'guardian_phone',
                'address',
                'photo',
            ]);
        });
    }
};