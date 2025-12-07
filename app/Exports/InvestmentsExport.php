<?php

namespace App\Exports;

use App\Models\Investment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvestmentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Investment::with('investor')->orderBy('roi_date', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Investor Name',
            'Investor Email',
            'Investment Amount',
            'Investment Date',
            'Investment Type',
            'Cycle Number',
            'ROI Date',
            'ROI Amount',
            'Status',
            'Days Until ROI',
        ];
    }

    public function map($investment): array
    {
        $daysUntil = $investment->daysUntilRoi();
        
        return [
            $investment->id,
            $investment->investor->name,
            $investment->investor->email,
            '$' . number_format($investment->investment_amount, 2),
            $investment->investment_date->format('Y-m-d'),
            $investment->investment_type == 'single_cycle' ? 'Single Cycle' : 'Double Cycle',
            $investment->cycle_number,
            $investment->roi_date->format('Y-m-d'),
            '$' . number_format($investment->roi_amount, 2),
            ucfirst($investment->roi_status),
            $daysUntil >= 0 ? $daysUntil . ' days' : 'Overdue by ' . abs($daysUntil) . ' days',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}