<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeavesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $leaves;

    public function __construct($leaves)
    {
        $this->leaves = $leaves;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        return $this->leaves;
    }

    public function headings(): array
    {
        return [
            'No',
            'Pegawai',
            'Tipe',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Alasan',
            'Status',
        ];
    }

    public function map($leave): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $leave->user->name ?? '-',
            strtoupper(str_replace('_', ' ', $leave->type)),
            Carbon::parse($leave->start_date)->format('d M Y'),
            Carbon::parse($leave->end_date)->format('d M Y'),
            $leave->reason,
            strtoupper($leave->status),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
