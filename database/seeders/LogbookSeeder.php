<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Logbook;
use App\Models\User;

class LogbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'user@gmail.com')->first();

        if ($user) {
            Logbook::firstOrCreate([
                'user_id' => $user->id,
                'date' => date('Y-m-d'),
            ], [
                'description' => 'Entry data 50 KK selesai.',
            ]);
        }

        $faker = \Faker\Factory::create('id_ID');
        $users = User::where('email', '!=', 'admin@gmail.com')->get();

        if ($users->count() > 0) {
            for ($i = 0; $i < 50; $i++) {
                $randomUser = $users->random();
                $status = $faker->randomElement(['pending', 'approved', 'revision']);
                $rejectionNote = $status === 'revision' ? $faker->realText(50) : null;

                Logbook::create([
                    'user_id' => $randomUser->id,
                    'date' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
                    'description' => $faker->realText(100),
                    'status' => $status,
                    'rejection_note' => $rejectionNote,
                ]);
            }
        }
    }
}
