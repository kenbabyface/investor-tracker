<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\InvestmentHistory;
use App\Models\Investor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\InvestmentsExport;
use App\Exports\InvestmentHistoryExport;
use Maatwebsite\Excel\Facades\Excel;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::with('investor')
            ->orderBy('roi_date', 'asc')
            ->paginate(15);

        return view('investments.index', compact('investments'));
    }

    public function create()
    {
        $investors = Investor::orderBy('name')->get();
        return view('investments.create', compact('investors'));
    }

        public function store(Request $request)
    {
        $validated = $request->validate([
            'investor_id' => 'required|exists:investors,id',
            'investment_amount' => 'required|numeric|min:0',
            'investment_date' => 'required|date',
            'investment_type' => 'required|in:single_cycle,double_cycle',
        ]);

        if ($validated['investment_type'] === 'double_cycle') {

            $validated['roi_date'] = Carbon::parse($validated['investment_date'])->addMonths(12);
        } else {
            $validated['roi_date'] = Carbon::parse($validated['investment_date'])->addMonths(6);
        }

        $validated['roi_amount'] = Investment::calculateRoiAmount($validated['investment_amount']);
        $validated['cycle_number'] = 1;
        $validated['roi_status'] = 'pending';

        Investment::create($validated);

        return redirect()->route('investments.index')->with('success', 'Investment added successfully!');
    }

    public function show(Investment $investment)
    {
        $investment->load('investor');
        return view('investments.show', compact('investment'));
    }

    public function markAsPaid(Investment $investment)
    {
        $investment->roi_status = 'paid';
        $investment->save();
        if ($investment->investment_type === 'single_cycle') {
            InvestmentHistory::create([
                'investor_id' => $investment->investor_id,
                'investment_amount' => $investment->investment_amount,
                'investment_date' => $investment->investment_date,
                'roi_date' => $investment->roi_date,
                'roi_amount' => $investment->roi_amount,
                'payment_date' => now(),
                'cycle_completed' => 'Single Cycle - ROI + Capital',
            ]);

            $investment->delete();
            $message = 'ROI marked as paid and moved to history!';

        } elseif ($investment->investment_type === 'double_cycle' && $investment->cycle_number === 1) {
            Investment::create([
                'investor_id' => $investment->investor_id,
                'investment_amount' => $investment->investment_amount,
                'investment_date' => $investment->roi_date,
                'investment_type' => 'double_cycle',
                'cycle_number' => 2,
                'roi_date' => Investment::calculateRoiDate($investment->roi_date),
                'roi_amount' => Investment::calculateRoiAmount($investment->investment_amount),
                'roi_status' => 'pending',
            ]);

            InvestmentHistory::create([
                'investor_id' => $investment->investor_id,
                'investment_amount' => $investment->investment_amount,
                'investment_date' => $investment->investment_date,
                'roi_date' => $investment->roi_date,
                'roi_amount' => $investment->roi_amount,
                'payment_date' => now(),
                'cycle_completed' => 'Double Cycle - First Payment (ROI Only)',
            ]);

            $investment->delete();
            $message = 'First cycle ROI paid! Second cycle created automatically.';

        } else {
            InvestmentHistory::create([
                'investor_id' => $investment->investor_id,
                'investment_amount' => $investment->investment_amount,
                'investment_date' => $investment->investment_date,
                'roi_date' => $investment->roi_date,
                'roi_amount' => $investment->roi_amount,
                'payment_date' => now(),
                'cycle_completed' => 'Double Cycle - Second Payment (ROI + Capital)',
            ]);

            $investment->delete();
            $message = 'Final ROI marked as paid and moved to history!';
        }

        return redirect()->route('investments.index')->with('success', $message);
    }

    public function history()
    {
        $history = InvestmentHistory::with('investor')
            ->orderBy('payment_date', 'desc')
            ->paginate(15);

        return view('investments.history', compact('history'));
    }

    public function destroy(Investment $investment)
    {
        $investment->delete();
        return redirect()->route('investments.index')->with('success', 'Investment deleted successfully!');
    }

        public function exportInvestments()
    {
        return Excel::download(new InvestmentsExport, 'active_investments_' . date('Y-m-d') . '.xlsx');
    }

    public function exportHistory()
    {
        return Excel::download(new InvestmentHistoryExport, 'investment_history_' . date('Y-m-d') . '.xlsx');
    }
}