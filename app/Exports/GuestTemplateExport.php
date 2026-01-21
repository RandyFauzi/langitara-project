<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuestTemplateExport implements WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'Name',
            'Category',
            'Phone',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Bold the first row
            1 => ['font' => ['bold' => true]],
        ];
    }
}
