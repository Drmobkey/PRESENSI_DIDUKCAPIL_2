<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendancesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $attendances;

    public function __construct($attendances)
    {
        $this->attendances = $attendances;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        return $this->attendances;
    }

    public function headings(): array
    {
        return [
            'No',
            'Pegawai',
            'Tanggal',
            'Lokasi TPDK',
            'Waktu Masuk',
            'Waktu Pulang',
            'Keterlambatan (Menit)',
            'Status',
        ];
    }

    public function map($attendance): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $attendance->user->name ?? '-',
            Carbon::parse($attendance->date)->format('d M Y'),
            $attendance->tpdk->name ?? 'Di Luar TPDK / Izin',
            $attendance->time_in ?? '-',
            $attendance->time_out ?? '-',
            $attendance->formatted_late_duration ?? '-',
            strtoupper(str_replace('_', ' ', $attendance->status)),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
