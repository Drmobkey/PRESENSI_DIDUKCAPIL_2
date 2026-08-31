<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'user@gmail.com')->first();

        if ($user) {
            Attendance::firstOrCreate([
                'user_id' => $user->id,
                'date' => date('Y-m-d'),
            ], [
                'time_in' => '07:55:00',
                'time_out' => '16:05:00',
                'status' => 'hadir',
                'lat_in' => -6.200000,
                'long_in' => 106.816666,
                'photo_in' => 'dummy_photo.jpg'
            ]);
        }
    }
}
