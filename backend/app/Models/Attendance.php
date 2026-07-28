<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'student_id',

        'course_id',

        'semester_id',

        'routine_id',

        'attendance_date',

        'status',

        'remarks',
    ];

    protected $casts = [

        'attendance_date' => 'date',

    ];

    public function scopePresent($query)
    {
        return $query->where('status', 'Present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'Absent');
    }

    public function scopeLate($query)
    {
        return $query->where('status', 'Late');
    }

    public function scopeLeave($query)
    {
        return $query->where('status', 'Leave');
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function routine()
    {
        return $this->belongsTo(Routine::class);
    }
}