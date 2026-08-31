<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Leave;
use App\Models\User;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'user@gmail.com')->first();

        if ($user) {
            Leave::firstOrCreate([
                'user_id' => $user->id,
                'start_date' => date('Y-m-d', strtotime('+1 day')),
            ], [
                'type' => 'sakit',
                'end_date' => date('Y-m-d', strtotime('+2 days')),
                'reason' => 'Sakit',
                'status' => 'pending',
                'attachment' => 'surat_sakit.pdf'
            ]);
        }
    }
}
