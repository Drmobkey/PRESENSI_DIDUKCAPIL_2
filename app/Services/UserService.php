<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserService
{

    public function approveUser(User $user, string $tpdkId)
    {
        $user->update([
            'status' => 'approved',
            'tpdk_id' => $tpdkId
        ]);

        return $user;

    }

    public function getAllUser()
    {
        return User::with(['primary_tpdk', 'roles'])->paginate(10);
    }

    public function getUserById(User $user)
    {
        return $user->load(['primary_tpdk', 'roles']);

    }

    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['status'] = $data['status'] ?? 'pending';

        if (isset($data['primary_tpdk_id']) && !isset($data['tpdk_id'])) {
            $data['tpdk_id'] = $data['primary_tpdk_id'];
        }

        $user = User::create($data);

        if (isset($data['role'])) {
            $user->assignRole($data['role']);
        }

        return $user;
    }

    public function updateUser(User $user, array $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (isset($data['primary_tpdk_id']) && !isset($data['tpdk_id'])) {
            $data['tpdk_id'] = $data['primary_tpdk_id'];
        }

        $user->update($data);

        if (isset($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        return $user;
    }

    public function rejectUser(User $user)
    {
        $user->update([
            'status' => 'rejected'
        ]);

        return $user;
    }

    public function deleteUser(User $user)
    {
        return $user->delete();
    }
}