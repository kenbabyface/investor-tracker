<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentScheduleController extends Controller
{
    
    public function index(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $selectedDate = Carbon::parse($month . '-01');

        $investments = Investment::with('investor')
            ->where('roi_status', 'pending')
            ->get();

        $paymentsByMonth = $this->groupPaymentsByMonth($investments);

        $monthlyPayments = $paymentsByMonth[$month] ?? [
            'single_cycle' => [],
            'double_cycle_first' => [],
            'double_cycle_second' => [],
            'totals' => [
                'single_cycle_total' => 0,
                'double_cycle_first_total' => 0,
                'double_cycle_second_total' => 0,
                'total_capital' => 0,
                'total_roi' => 0,
                'grand_total' => 0,
            ]
        ];

        $summary = $this->calculateSummary($paymentsByMonth);

        return view('payments.schedule', [
            'selectedDate' => $selectedDate,
            'monthlyPayments' => $monthlyPayments,
            'paymentsByMonth' => $paymentsByMonth,
            'summary' => $summary,
        ]);
    }

    private function groupPaymentsByMonth($investments)
    {
        $grouped = [];

        foreach ($investments as $investment) {
            $roiDate = Carbon::parse($investment->roi_date);
            $investmentDate = Carbon::parse($investment->investment_date);
            $monthKey = $roiDate->format('Y-m');

            if (!isset($grouped[$monthKey])) {
                $grouped[$monthKey] = [
                    'single_cycle' => [],
                    'double_cycle_first' => [],
                    'double_cycle_second' => [],
                    'totals' => [
                        'single_cycle_total' => 0,
                        'double_cycle_first_total' => 0,
                        'double_cycle_second_total' => 0,
                        'total_capital' => 0,
                        'total_roi' => 0,
                        'grand_total' => 0,
                    ]
                ];
            }

            if ($investment->investment_type === 'single_cycle') {
                $payment = [
                    'investment' => $investment,
                    'investor_name' => $investment->investor->name,
                    'capital' => $investment->investment_amount,
                    'roi' => $investment->roi_amount,
                    'total' => $investment->investment_amount + $investment->roi_amount,
                    'due_date' => $roiDate,
                ];

                $grouped[$monthKey]['single_cycle'][] = $payment;
                $grouped[$monthKey]['totals']['single_cycle_total'] += $payment['total'];
                $grouped[$monthKey]['totals']['total_capital'] += $payment['capital'];
                $grouped[$monthKey]['totals']['total_roi'] += $payment['roi'];
                $grouped[$monthKey]['totals']['grand_total'] += $payment['total'];

            } else {
                $midCycleDate = $investmentDate->copy()->addMonths(6);
                $midMonthKey = $midCycleDate->format('Y-m');
                $endMonthKey = $roiDate->format('Y-m');

                if (!isset($grouped[$midMonthKey])) {
                    $grouped[$midMonthKey] = [
                        'single_cycle' => [],
                        'double_cycle_first' => [],
                        'double_cycle_second' => [],
                        'totals' => [
                            'single_cycle_total' => 0,
                            'double_cycle_first_total' => 0,
                            'double_cycle_second_total' => 0,
                            'total_capital' => 0,
                            'total_roi' => 0,
                            'grand_total' => 0,
                        ]
                    ];
                }

                $firstPayment = [
                    'investment' => $investment,
                    'investor_name' => $investment->investor->name,
                    'capital' => 0, 
                    'roi' => $investment->roi_amount,
                    'total' => $investment->roi_amount,
                    'due_date' => $midCycleDate,
                ];

                $grouped[$midMonthKey]['double_cycle_first'][] = $firstPayment;
                $grouped[$midMonthKey]['totals']['double_cycle_first_total'] += $firstPayment['total'];
                $grouped[$midMonthKey]['totals']['total_roi'] += $firstPayment['roi'];
                $grouped[$midMonthKey]['totals']['grand_total'] += $firstPayment['total'];

                if (!isset($grouped[$endMonthKey])) {
                    $grouped[$endMonthKey] = [
                        'single_cycle' => [],
                        'double_cycle_first' => [],
                        'double_cycle_second' => [],
                        'totals' => [
                            'single_cycle_total' => 0,
                            'double_cycle_first_total' => 0,
                            'double_cycle_second_total' => 0,
                            'total_capital' => 0,
                            'total_roi' => 0,
                            'grand_total' => 0,
                        ]
                    ];
                }

                $secondPayment = [
                    'investment' => $investment,
                    'investor_name' => $investment->investor->name,
                    'capital' => $investment->investment_amount,
                    'roi' => $investment->roi_amount,
                    'total' => $investment->investment_amount + $investment->roi_amount,
                    'due_date' => $roiDate,
                ];

                $grouped[$endMonthKey]['double_cycle_second'][] = $secondPayment;
                $grouped[$endMonthKey]['totals']['double_cycle_second_total'] += $secondPayment['total'];
                $grouped[$endMonthKey]['totals']['total_capital'] += $secondPayment['capital'];
                $grouped[$endMonthKey]['totals']['total_roi'] += $secondPayment['roi'];
                $grouped[$endMonthKey]['totals']['grand_total'] += $secondPayment['total'];
            }
        }

        ksort($grouped);

        return $grouped;
    }

    private function calculateSummary($paymentsByMonth)
    {
        $summary = [
            'total_single_cycle' => 0,
            'total_double_cycle_first' => 0,
            'total_double_cycle_second' => 0,
            'total_capital' => 0,
            'total_roi' => 0,
            'grand_total' => 0,
            'total_months' => count($paymentsByMonth),
        ];

        foreach ($paymentsByMonth as $month => $data) {
            $summary['total_single_cycle'] += $data['totals']['single_cycle_total'];
            $summary['total_double_cycle_first'] += $data['totals']['double_cycle_first_total'];
            $summary['total_double_cycle_second'] += $data['totals']['double_cycle_second_total'];
            $summary['total_capital'] += $data['totals']['total_capital'];
            $summary['total_roi'] += $data['totals']['total_roi'];
            $summary['grand_total'] += $data['totals']['grand_total'];
        }

        return $summary;
    }
}