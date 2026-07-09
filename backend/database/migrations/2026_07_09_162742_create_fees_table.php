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
        Schema::create('fees', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('semester_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);

            $table->decimal('paid_amount', 10, 2)->default(0);

            $table->decimal('due_amount', 10, 2);

            $table->date('payment_date')->nullable();

            $table->enum('payment_method', [
                'Cash',
                'Bank',
                'Mobile Banking'
            ])->nullable();

            $table->string('transaction_id')->nullable();

            $table->enum('status', [
                'Paid',
                'Partial',
                'Due'
            ])->default('Due');

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};