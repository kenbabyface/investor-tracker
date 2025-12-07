<?php

namespace App\Exports;

use App\Models\InvestmentHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvestmentHistoryExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return InvestmentHistory::with('investor')->orderBy('payment_date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Investor Name',
            'Investor Email',
            'Investment Amount',
            'Investment Date',
            'ROI Date',
            'ROI Amount',
            'Payment Date',
            'Cycle Completed',
        ];
    }

    public function map($history): array
    {
        return [
            $history->id,
            $history->investor->name,
            $history->investor->email,
            '$' . number_format($history->investment_amount, 2),
            $history->investment_date->format('Y-m-d'),
            $history->roi_date->format('Y-m-d'),
            '$' . number_format($history->roi_amount, 2),
            $history->payment_date->format('Y-m-d'),
            $history->cycle_completed,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}