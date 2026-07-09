<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'course_id',
        'semester_id',
        'attendance_date',
        'status',
        'remarks',
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    /**
     * Student Relationship
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Course Relationship
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Semester Relationship
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}