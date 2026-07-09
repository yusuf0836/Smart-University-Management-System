<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'semester_id',
        'amount',
        'paid_amount',
        'due_amount',
        'payment_date',
        'payment_method',
        'transaction_id',
        'status',
        'remarks',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /**
     * Student Relationship
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Semester Relationship
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}