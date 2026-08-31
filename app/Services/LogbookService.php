<?php

namespace App\Services;

use App\Models\Logbook;
use App\Models\User;

class LogbookService
{
    public function getLogbooks($user)
    {
        $query = Logbook::with('user');

        // Admin dan Superadmin melihat seluruh logbook
        if ($user->can('logbook.manage_all')) {
            return $query->latest()->get();
        }

        // User biasa hanya melihat logbook miliknya sendiri
        return $query->where('user_id', $user->id)->latest()->get();
    }

    public function storeLogbook(User $user, array $data)
    {
        // Gunakan updateOrCreate agar tidak ada 2 logbook di hari yang sama
        return Logbook::updateOrCreate(
            ['user_id' => $user->id, 'date' => now()->toDateString()],
            ['description' => $data['description']]
        );
    }

    public function updateLogbook(Logbook $logbook, array $data)
    {
        $logbook->update($data);
        return $logbook;
    }

    public function deleteLogbook(Logbook $logbook)
    {
        return $logbook->delete();
    }
}