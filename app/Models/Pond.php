<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pond extends Model
{
    protected $fillable = [
        'name', 'species', 'stock_count', 'stocked_at', 'notes', 'is_active'
    ];

    protected $casts = [
        'stocked_at' => 'date',
        'is_active'  => 'boolean',
    ];

    public function feedLogs(): HasMany
    {
        return $this->hasMany(DailyFeedLog::class);
    }

    public function totalFeedKg(): float
    {
        return (float) $this->feedLogs()->sum('quantity_kg');
    }

    public function totalFeedCost(): float
    {
        return (float) $this->feedLogs()->sum('total_cost');
    }

    public function todayFeedKg(): float
    {
        return (float) $this->feedLogs()->whereDate('log_date', today())->sum('quantity_kg');
    }

    public function todayFeedCost(): float
    {
        return (float) $this->feedLogs()->whereDate('log_date', today())->sum('total_cost');
    }
}