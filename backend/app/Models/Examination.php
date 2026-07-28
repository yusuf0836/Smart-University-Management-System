<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examination extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'academic_session_id',

        'department_id',

        'semester_id',

        'course_id',

        'exam_name',

        'exam_type',

        'exam_date',

        'start_time',

        'end_time',

        'venue',

        'total_marks',

        'pass_marks',

        'status',

        'remarks',
    ];

    protected $casts = [

        'exam_date' => 'date',

        'status' => 'boolean',

        'total_marks' => 'decimal:2',

        'pass_marks' => 'decimal:2',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}