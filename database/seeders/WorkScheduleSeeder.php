<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkSchedule;

class WorkScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat jadwal kerja untuk hari Senin (1) hingga Jumat (5)
        for ($day = 1; $day <= 5; $day++) {
            WorkSchedule::firstOrCreate(
                ['day_of_week' => $day],
                [
                    'start_time' => '08:00:00',
                    'end_time' => '16:00:00'
                ]
            );
        }
    }
}
