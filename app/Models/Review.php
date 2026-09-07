<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'branch_id',
        'nama_pelanggan',
        'rating',
        'komentar',
        'is_approved',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    public function branch(): ?BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->branch()?->reviews()->where('is_approved', true)->avg('rating') ?? 0;
    }
}
