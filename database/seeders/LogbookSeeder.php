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
    }
}
