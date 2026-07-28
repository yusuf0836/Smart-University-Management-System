<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'title',

        'description',

        'category',

        'audience',

        'publish_date',

        'expiry_date',

        'is_pinned',

        'attachment',

        'status',

        'created_by',

    ];

    protected $casts = [

        'publish_date' => 'date',

        'expiry_date' => 'date',

        'status' => 'boolean',

        'is_pinned' => 'boolean',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('status', true);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeActive($query)
    {
        return $query->whereDate(
            'publish_date',
            '<=',
            now()
        )
        ->where(function ($query) {

            $query->whereNull('expiry_date')

                ->orWhereDate(
                    'expiry_date',
                    '>=',
                    now()
                );

        });
    }
}