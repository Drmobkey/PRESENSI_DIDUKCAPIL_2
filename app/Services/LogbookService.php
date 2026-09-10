<?php

namespace App\Services;

use App\Models\Logbook;
use App\Models\User;

class LogbookService
{
    public function getLogbooks($user, array $filters = [], $paginate = true)
    {
        $query = Logbook::with('user');

        // Admin dan Superadmin melihat seluruh logbook
        if (!$user->can('logbooks.manage_all')) {
            // User biasa hanya melihat logbook miliknya sendiri
            $query->where('user_id', $user->id);
        } else {
            // Admin bisa filter by user_id
            if (!empty($filters['user_id'])) {
                $query->where('user_id', $filters['user_id']);
            }
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('date', '<=', $filters['end_date']);
        }

        if ($paginate) {
            return $query->orderBy('date', 'desc')->paginate(10)->withQueryString();
        }
        return $query->orderBy('date', 'desc')->get();
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