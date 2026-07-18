<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semester extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date'   => 'date:Y-m-d',
        'status'     => 'boolean',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    /**
     * Semester has many enrollments
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    /**
     * Semester has many attendances
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    /**
     * Semester has many routines
     */
    public function routines()
    {
        return $this->hasMany(Routine::class);
    }
    /**
     * Semester has many fees
     */
    public function fees()
    {
        return $this->hasMany(Fee::class);
    }
    /**
     * Semester has many examinations
     */
    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }
    /**
     * Semester has many transcripts
     */
    public function transcripts()
    {
        return $this->hasMany(Transcript::class);
    }
}