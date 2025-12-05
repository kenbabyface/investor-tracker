<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentHistory extends Model
{
    use HasFactory;

    protected $table = 'investment_history';

    protected $fillable = [
        'investor_id',
        'investment_amount',
        'investment_date',
        'roi_date',
        'roi_amount',
        'payment_date',
        'cycle_completed',
    ];

    protected $casts = [
        'investment_date' => 'date',
        'roi_date' => 'date',
        'payment_date' => 'date',
        'investment_amount' => 'decimal:2',
        'roi_amount' => 'decimal:2',
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }
}