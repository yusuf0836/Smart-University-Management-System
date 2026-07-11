<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examination extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'department_id',
        'semester_id',
        'exam_name',
        'exam_type',
        'exam_date',
        'start_time',
        'end_time',
        'venue',
        'status',
    ];

    protected $casts = [
        'exam_date' => 'date',
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
}