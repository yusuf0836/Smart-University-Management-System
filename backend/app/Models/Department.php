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
}