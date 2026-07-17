<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'faculty_id',
        'name',
        'code',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Relationships
     */

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function routines()
    {
        return $this->hasMany(Routine::class);
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }
}