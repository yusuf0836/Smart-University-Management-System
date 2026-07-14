<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transcript extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'semester_id',
        'semester_gpa',
        'cgpa',
        'total_credits',
        'status',
    ];

    protected $casts = [
        'semester_gpa' => 'decimal:2',
        'cgpa' => 'decimal:2',
        'total_credits' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}