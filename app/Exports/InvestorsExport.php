<?php

namespace App\Exports;

use App\Models\Investor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvestorsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Investor::orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Company',
            'Investment Amount',
            'Status',
            'Notes',
            'Created Date',
        ];
    }

    public function map($investor): array
    {
        return [
            $investor->id,
            $investor->name,
            $investor->email,
            $investor->phone ?? 'N/A',
            $investor->company ?? 'N/A',
            '$' . number_format($investor->investment_amount, 2),
            ucfirst($investor->status),
            $investor->notes ?? 'N/A',
            $investor->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}