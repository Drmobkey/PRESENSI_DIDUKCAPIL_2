<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;


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

    public function updateStatus(Leave $leave, string $status, ?string $rejectionNote = null)
    {
        // Jika sudah diproses, tidak boleh memicu Attendance::updateOrCreate lagi
        if ($leave->status !== 'pending') {
            return $leave;
        }

        $leave->update([
            'status' => $status,
            'rejection_note' => $status === 'rejected' ? $rejectionNote : null
        ]);

        if ($status === 'approved') {
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
    public function getLeaves($user, array $filters = [], $paginate = true)
    {
        $query = Leave::with('user');

        if (!$user->can('leaves.manage_all')) {
            // Jika bukan superadmin, cek apakah admin cabang atau user biasa
            if ($user->can('leaves.manage_branch')) {
                // Admin Cabang: Lihat user di cabang yang sama (TPDK sama)
                $query->whereHas('user', function ($q) use ($user) {
                    $q->where('primary_tpdk_id', $user->primary_tpdk_id);
                });
            } else {
                // User biasa: Hanya lihat izin miliknya sendiri
                $query->where('user_id', $user->id);
            }
        } else {
            // Superadmin bisa filter berdasarkan user_id
            if (!empty($filters['user_id'])) {
                $query->where('user_id', $filters['user_id']);
            }
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('start_date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('end_date', '<=', $filters['end_date']);
        }

        if ($paginate) {
            return $query->latest()->paginate(10)->withQueryString();
        }
        return $query->latest()->get();
    }

}