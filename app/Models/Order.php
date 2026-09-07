<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'branch_id',
        'status',
        'method',
        'total',
        'customer_name',
        'customer_phone',
        'notes',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    const STATUSES = ['pending', 'confirmed', 'cooking', 'ready', 'completed', 'cancelled'];
    const METHODS = ['dine-in', 'online', 'delivery'];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForBranch($query, int $branchId)
    {
        return $query->where('branch_id', $branchId);
    }
}
