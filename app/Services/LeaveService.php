<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Support\Carbon;


class LeaveService
{
    public function createLeave($user, array $data)
    {
        $data['user_id'] = $user->id;
        $data['status'] = 'pending';

        if (isset($data['attachment'])) {
            $data['attachment'] = $data['attachment']->store('leaves', 'public');
        }

        return Leave::create($data);


    }

    public function approvalLeave(Leave $leave)
    {
        $leave->update(['status' => 'approved']);

        $startDate = Carbon::parse($leave->start_date);
        $endDate = Carbon::parse($leave->end_date);

        while ($startDate->lte($endDate)) {
            Attendance::updateOrCreate(
                [
                    'user_id' => $leave->user_id,
                    'date' => $startDate->toDateString(),
                ],
                [
                    // Status akan terisi 'sakit', 'cuti', atau 'dinas_luar' tanpa memerlukan kordinat lat/long
                    'status' => $leave->type,
                ]
            );
            $startDate->addDay();


        }

        return $leave;
    }

    public function updateLeave(Leave $leave, array $data)
    {
        if (isset($data['attachment'])) {
            // Hapus file lama jika ada
            if ($leave->attachment) {
                Storage::disk('public')->delete($leave->attachment);
            }
            $data['attachment'] = $data['attachment']->store('leaves', 'public');
        }

        $leave->update($data);
        return $leave;
    }

    public function deleteLeave(Leave $leave)
    {
        if ($leave->attachment) {
            Storage::disk('public')->delete($leave->attachment);
        }
        return $leave->delete();
    }

    /**
     * Menampilkan daftar izin berdasarkan Permission/Role
     */
    public function getLeaves($user)
    {
        $query = Leave::with('user');

        if ($user->can('leaves.manage_all')) {
            return $query->latest()->paginate(10);
        } else {
            // User biasa: Hanya lihat izin miliknya sendiri
            return $query->where('user_id', $user->id)->latest()->paginate(10);
        }


    }

}