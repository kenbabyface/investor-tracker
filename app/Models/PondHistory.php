<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PondHistory extends Model
{
    protected $fillable = [
        'pond_id', 'pond_name', 'species', 'stock_count',
        'stocked_at', 'total_feed_bags', 'total_feed_kg', 'total_cost',
    ];

    protected $casts = [
        'stocked_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function pond()
    {
        return $this->belongsTo(Pond::class);
    }
}