<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'course_id',
        'semester_id',
        'enrollment_date',
        'status',
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