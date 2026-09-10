<?php

namespace App\Services;

use App\Models\WorkSchedule;
use Illuminate\Support\Carbon;

class WorkScheduleService
{
    public function getSchedules()
    {
        return WorkSchedule::orderBy('day_of_week')->get();
    }

    public function store(array $data)
    {
        return WorkSchedule::create($data);
    }

    public function update(WorkSchedule $workSchedule, array $data)
    {
        $workSchedule->update($data);
        return $workSchedule;
    }

    public function destroy(WorkSchedule $workSchedule)
    {
        return $workSchedule->delete();
    }

    public function getTodaySchedule()
    {
        // Mendapatkan angka hari: 0 (Minggu) hingga 6 (Sabtu) sesuai format di database
        $today = Carbon::now()->dayOfWeek;

        $schedule = WorkSchedule::where('day_of_week', $today)->first();

        if (!$schedule) {
            throw new \Exception("Jadwal operasional untuk hari ini belum diatur oleh Admin.");
        }
        return $schedule;
    }

}
