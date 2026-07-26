<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_id',
        'semester_id',
        'academic_session_id',

        'student_id',
        'name',
        'email',
        'phone',

        'gender',
        'date_of_birth',
        'admission_date',

        'blood_group',

        'guardian_name',
        'guardian_phone',

        'address',
        'photo',

        'status',
    ];

    protected $casts = [

        'date_of_birth' => 'date',

        'admission_date' => 'date',

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

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }
}