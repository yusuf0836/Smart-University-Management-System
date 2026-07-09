<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Routine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'department_id',
        'semester_id',
        'course_id',
        'teacher_id',
        'day',
        'start_time',
        'end_time',
        'room_no',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Department Relationship
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Semester Relationship
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Course Relationship
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Teacher Relationship
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}