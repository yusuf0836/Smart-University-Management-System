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
        Schema::table('teachers', function (Blueprint $table) {

            $table->foreignId('faculty_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();

            $table->enum('gender', [
                'Male',
                'Female',
                'Other',
            ])->nullable()->after('phone');

            $table->string('qualification')
                ->nullable()
                ->after('designation');

            $table->string('blood_group', 5)
                ->nullable()
                ->after('salary');

            $table->text('address')
                ->nullable()
                ->after('blood_group');

            $table->string('photo')
                ->nullable()
                ->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {

            $table->dropConstrainedForeignId('faculty_id');

            $table->dropColumn([
                'gender',
                'qualification',
                'blood_group',
                'address',
                'photo',
            ]);
        });
    }
};