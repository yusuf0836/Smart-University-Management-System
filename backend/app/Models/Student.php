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
        'name',
        'student_id',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'admission_date',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'date_of_birth' => 'date',
        'admission_date' => 'date',
    ];

    /**
     * Student belongs to a Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Student belongs to a Semester
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}