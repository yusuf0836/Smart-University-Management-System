<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'marks',
        'grade',
        'grade_point',
        'remarks',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}