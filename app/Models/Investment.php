<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'investor_id',
        'investment_amount',
        'investment_date',
        'investment_type',
        'cycle_number',
        'roi_date',
        'roi_amount',
        'roi_status',
    ];

    protected $casts = [
        'investment_date' => 'date',
        'roi_date' => 'date',
        'investment_amount' => 'decimal:2',
        'roi_amount' => 'decimal:2',
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }

    public static function calculateRoiDate($investmentDate)
    {
        return Carbon::parse($investmentDate)->addMonths(6);
    }

    public static function calculateRoiAmount($investmentAmount)
    {
        return $investmentAmount * 0.20;
    }

    public function isDue()
    {
        return Carbon::now()->greaterThanOrEqualTo($this->roi_date);
    }

    public function daysUntilRoi()
    {
        return Carbon::now()->diffInDays($this->roi_date, false);
    }
}