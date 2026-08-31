<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Logbook;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class AttendanceService
{
    protected $geolocationService;
    protected $workScheduleService;

    public function __construct(GeolocationService $geolocationService, WorkScheduleService $workScheduleService)
    {
        $this->geolocationService = $geolocationService;
        $this->workScheduleService = $workScheduleService;

    }

    public function checkIn($user, array $data)
    {
        $nearestTpdk = $this->geolocationService->findNearestValidTpdk($data['latitude'], $data['longitude']);

        $schedule = $this->workScheduleService->getTodaySchedule();
        $currentTime = Carbon::now()->format('H:i:s');
        $isLate = $currentTime > $schedule->start_time;

        $photoPath = $data['photo_in']->store('attendances', 'public');

        return Attendance::create([
            'user_id' => $user->id,
            'tpdk_id' => $nearestTpdk->id,
            'date' => now()->toDateString(),
            'time_in' => $currentTime, // Gunakan variabel yang sudah ada
            'lat_in' => $data['latitude'],
            'long_in' => $data['longitude'],
            'photo_in' => $photoPath,
            'is_late' => $isLate,      // Injeksi status terlambat
            'status' => 'hadir'        // Kunci status kehadiran
        ]);
    }

    public function checkOut($user, array $data)
    {
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', now()->toDateString())
            ->firstOrFail();

        $schedule = $this->workScheduleService->getTodaySchedule();
        $currentTime = Carbon::now()->format('H:i:s');

        // Validasi lokasi kepulangan
        $this->geolocationService->findNearestValidTpdk($data['latitude'], $data['longitude']);

        if ($currentTime < $schedule->end_time) {
            throw new Exception("Belum waktunya pulang. Jam kerja hari ini berakhir pukul {$schedule->end_time}.");
        }

        $photoPath = $data['photo_out']->store('attendances', 'public');

        // Gunakan transaksi agar Check-Out dan Logbook terikat satu sama lain
        return DB::transaction(function () use ($attendance, $user, $data, $currentTime, $photoPath) {
            $attendance->update([
                'time_out' => $currentTime,
                'photo_out' => $photoPath,
            ]);

            // Jika form checkout menyertakan isian logbook, update/buat
            if (!empty($data['logbook_description'])) {
                Logbook::updateOrCreate(
                    ['user_id' => $user->id, 'date' => now()->toDateString()],
                    ['description' => $data['logbook_description']]
                );
            } else {
                // Jika tidak menyertakan, pastikan dia sudah mengisi logbook sebelumnya
                $hasLogbook = Logbook::where('user_id', $user->id)
                    ->where('date', now()->toDateString())
                    ->exists();

                if (!$hasLogbook) {
                    throw new \Exception("Anda belum mengisi logbook. Silakan isi logbook terlebih dahulu atau lengkapi saat Check-out.");
                }
            }

            return $attendance;
        });
    }

    public function getAttendances($user)
    {
        // Eager load relasi user dan tpdk untuk detail lengkap
        $query = Attendance::with(['user', 'tpdk']);

        // Jika user adalah Admin / Superadmin (memiliki permission view_all_data)
        if ($user->can('attendances.view_all')) {
            return $query->latest()->get();
            // Admin langsung melihat seluruh presensi dari semua TPDK
        }

        // Jika user biasa, hanya melihat miliknya sendiri
        return $query->where('user_id', $user->id)->latest()->get();

    }




}