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

        $faker = \Faker\Factory::create('id_ID');
        $users = User::where('email', '!=', 'admin@gmail.com')->get();

        if ($users->count() > 0) {
            for ($i = 0; $i < 50; $i++) {
                $randomUser = $users->random();
                Attendance::create([
                    'user_id' => $randomUser->id,
                    'date' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
                    'time_in' => $faker->time('H:i:s', '08:00:00'),
                    'time_out' => $faker->time('H:i:s', '17:00:00'),
                    'status' => $faker->randomElement(['hadir', 'alpa', 'izin', 'sakit', 'cuti', 'dinas_luar']),
                    'lat_in' => $faker->latitude(-11, 6),
                    'long_in' => $faker->longitude(95, 141),
                    'photo_in' => null
                ]);
            }
        }
    }
}
