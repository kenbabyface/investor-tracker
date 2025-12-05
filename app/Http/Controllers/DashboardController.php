<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalInvestors = Investor::count();
        $totalInvestment = Investor::sum('investment_amount');
        $activeInvestors = Investor::where('status', 'active')->count();
        $pendingInvestors = Investor::where('status', 'pending')->count();
        $inactiveInvestors = Investor::where('status', 'inactive')->count();

        $chartLabels = [];
        $chartData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthYear = $date->format('M Y'); 
            
            $monthlyInvestment = Investor::whereYear('created_at', $date->year)
                                        ->whereMonth('created_at', $date->month)
                                        ->sum('investment_amount');
            
            $chartLabels[] = $monthYear;
            $chartData[] = $monthlyInvestment;
        }

        return view('dashboard', compact(
            'totalInvestors',
            'totalInvestment',
            'activeInvestors',
            'pendingInvestors',
            'inactiveInvestors',
            'chartLabels',
            'chartData'
        ));
    }
}