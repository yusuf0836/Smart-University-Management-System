<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_id',
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

    /**
     * A course belongs to a department.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}