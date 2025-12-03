<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'investment_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'investment_amount' => 'decimal:2',
    ];
}