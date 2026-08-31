<?php

namespace App\Services;

use App\Models\WorkSchedule;
use Illuminate\Support\Carbon;

class WorkScheduleService
{
    public function getTodaySchedule()
    {
        // Mendapatkan angka hari: 1 (Senin) hingga 7 (Minggu)
        $today = Carbon::now()->dayOfWeekIso;

        $schedule = WorkSchedule::where('day_of_week', $today)->first();

        if (!$schedule) {
            throw new Exception("Jadwal operasional untuk hari ini belum diatur oleh Admin.");
        }
        return $schedule;

    }

}
