<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'department_id',
        'name',
        'employee_id',
        'email',
        'phone',
        'designation',
        'joining_date',
        'salary',
        'status',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}