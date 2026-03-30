<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeedSize extends Model
{
    protected $fillable = [
        'name', 'size', 'price_per_kg', 'description', 'is_active'
    ];

    protected $casts = [
        'price_per_kg' => 'decimal:2',
        'is_active'    => 'boolean',
    ];

    public function feedLogs(): HasMany
    {
        return $this->hasMany(DailyFeedLog::class);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->size ? "{$this->name} ({$this->size})" : $this->name;
    }
}