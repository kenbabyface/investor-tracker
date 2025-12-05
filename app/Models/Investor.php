<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'investment_amount',
        'status',
        'notes',
    ];

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function investmentHistory()
    {
        return $this->hasMany(InvestmentHistory::class);
    }

    public function activeInvestments()
    {
        return $this->hasMany(Investment::class)->where('roi_status', 'pending');
    }

    public function totalActiveInvestment()
    {
        return $this->investments()->where('roi_status', 'pending')->sum('investment_amount');
    }

    public function pendingRoiAmount()
    {
        return $this->investments()->where('roi_status', 'pending')->sum('roi_amount');
    }
}