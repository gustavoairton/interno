<?php

namespace App\Models;

use App\Observers\SaleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(SaleObserver::class)]
class Sale extends Model
{
    protected $fillable = [
        'lead_id',
        'user_id',
        'service_id',
        'value'
    ];

    protected $appends = [
        'total_receipts_value'
    ];

    public function getTotalReceiptsValueAttribute(): float
    {
        return $this->receipts->sum('value');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }
}
