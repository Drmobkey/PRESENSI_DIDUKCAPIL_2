<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class InjectAlpaStatus extends Command
{
    /**
     * Execute the console command.
     */

    // Nama perintah yang akan dipanggil di scheduler
    protected $signature = 'attendance:alpa';
    protected $description = 'Otomatis mencatat status Alpa bagi user yang tidak presensi atau izin hari ini';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $users = User::where('status', 'approved')->get();
        $alpaCount = 0;

        foreach ($users as $user) {
            // Cek apakah user sudah punya presensi (hadir/izin/sakit/dll) pada hari ini
            $hasAttendance = Attendance::where('user_id', $user->id)
                ->where('date', $today)
                ->exists();
            
            if (!$hasAttendance) {
                Attendance::create([
                    'user_id' => $user->id,
                    'date' => $today,
                    'status' => 'alpa',
                ]);
                $alpaCount++;
            }
        }

        $this->info("Berhasil menambahkan {$alpaCount} status Alpa untuk tanggal {$today}.");
        Log::info("Cron Job Alpa dijalankan: {$alpaCount} user dialpakan.");
    }
}
