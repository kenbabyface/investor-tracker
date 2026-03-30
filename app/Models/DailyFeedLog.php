<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyFeedLog extends Model
{
    protected $fillable = [
        'pond_id', 'feed_size_id', 'log_date',
        'quantity_kg', 'price_per_kg', 'total_cost', 'notes'
    ];

    protected $casts = [
        'log_date'     => 'date',
        'quantity_kg'  => 'decimal:2',
        'price_per_kg' => 'decimal:2',
        'total_cost'   => 'decimal:2',
    ];

    public function pond(): BelongsTo
    {
        return $this->belongsTo(Pond::class);
    }

    public function feedSize(): BelongsTo
    {
        return $this->belongsTo(FeedSize::class);
    }
}