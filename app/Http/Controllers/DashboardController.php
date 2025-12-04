<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate statistics
        $totalInvestors = Investor::count();
        $totalInvestment = Investor::sum('investment_amount');
        $activeInvestors = Investor::where('status', 'active')->count();
        $pendingInvestors = Investor::where('status', 'pending')->count();
        $inactiveInvestors = Investor::where('status', 'inactive')->count();

        return view('dashboard', compact(
            'totalInvestors',
            'totalInvestment',
            'activeInvestors',
            'pendingInvestors',
            'inactiveInvestors'
        ));
    }
}