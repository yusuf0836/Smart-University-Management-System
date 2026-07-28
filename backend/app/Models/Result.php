<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'enrollment_id',

        'student_id',

        'semester_id',

        'academic_session_id',

        'total_credit',

        'earned_credit',

        'total_grade_point',

        'gpa',

        'result_status',

        'remarks',

        'status',
    ];

    protected $casts = [

        'total_credit' => 'decimal:2',

        'earned_credit' => 'decimal:2',

        'total_grade_point' => 'decimal:2',

        'gpa' => 'decimal:2',

        'status' => 'boolean',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}