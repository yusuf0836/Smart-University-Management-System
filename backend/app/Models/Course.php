<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Enrollment;
use App\Models\TeacherCourseAssignment;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_id',
        'semester_id',
        'course_code',
        'course_title',
        'credit',
        'type',
        'status',
    ];

    protected $casts = [
        'credit' => 'decimal:1',
        'status' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function courseAssignments()
    {
        return $this->hasMany(TeacherCourseAssignment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}