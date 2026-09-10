<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LogbooksExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $logbooks;

    public function __construct($logbooks)
    {
        $this->logbooks = $logbooks;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        return $this->logbooks;
    }

    public function headings(): array
    {
        return [
            'No',
            'Pegawai',
            'Tanggal',
            'Aktivitas / Deskripsi',
            'Status',
        ];
    }

    public function map($logbook): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $logbook->user->name ?? '-',
            Carbon::parse($logbook->date)->format('d M Y'),
            $logbook->description,
            strtoupper($logbook->status),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
