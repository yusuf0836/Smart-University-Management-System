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
        Schema::create('academic_sessions', function (Blueprint $table) {

            $table->id();

            $table->string('name',20)->unique();

            $table->date('start_date')->nullable();

            $table->date('end_date')->nullable();

            $table->enum('status',[
                'upcoming',
                'active',
                'completed'
            ])->default('upcoming');

            $table->boolean('is_current')
                ->default(false)
                ->index();

            $table->text('description')->nullable();

            $table->timestamps();

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_sessions');
    }
};