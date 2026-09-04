<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PdfFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'category',
        'uploaded_by',
        'status',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'status' => 'boolean',
    ];

    /**
     * User who uploaded the PDF.
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Active PDF scope.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}