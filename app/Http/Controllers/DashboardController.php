<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Investment;
use App\Models\InvestmentHistory;
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

        // ROI Dashboard Data
        $currentMonth = Carbon::now();
        
        // ROI due this month
        $roiThisMonth = Investment::where('roi_status', 'pending')
            ->whereYear('roi_date', $currentMonth->year)
            ->whereMonth('roi_date', $currentMonth->month)
            ->with('investor')
            ->get();
        
        // Total ROI amount due this month
        $totalRoiThisMonth = $roiThisMonth->sum('roi_amount');
        
        // Overdue ROI
        $overdueRoi = Investment::where('roi_status', 'pending')
            ->where('roi_date', '<', Carbon::today())
            ->with('investor')
            ->get();
        
        // Total overdue amount
        $totalOverdue = $overdueRoi->sum('roi_amount');
        
        // Upcoming ROI (next 30 days)
        $upcomingRoi = Investment::where('roi_status', 'pending')
            ->whereBetween('roi_date', [Carbon::today(), Carbon::today()->addDays(30)])
            ->with('investor')
            ->orderBy('roi_date', 'asc')
            ->limit(5)
            ->get();

        // NEW: Total ROI Statistics
        $totalActiveInvestments = Investment::where('roi_status', 'pending')->sum('investment_amount');
        $totalRoiPending = Investment::where('roi_status', 'pending')->sum('roi_amount');
        $totalRoiPaid = InvestmentHistory::sum('roi_amount');
        $totalRoiGenerated = $totalRoiPending + $totalRoiPaid;

        return view('dashboard', compact(
            'totalInvestors',
            'totalInvestment',
            'activeInvestors',
            'pendingInvestors',
            'inactiveInvestors',
            'chartLabels',
            'chartData',
            'roiThisMonth',
            'totalRoiThisMonth',
            'overdueRoi',
            'totalOverdue',
            'upcomingRoi',
            'totalActiveInvestments',
            'totalRoiPending',
            'totalRoiPaid',
            'totalRoiGenerated'
        ));
    }
}