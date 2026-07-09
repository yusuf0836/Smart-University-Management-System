<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'faculty_id',
        'name',
        'code',
        'description',
        'status',
    ];

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
}