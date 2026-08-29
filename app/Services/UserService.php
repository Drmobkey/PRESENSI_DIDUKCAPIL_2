<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserService
{

    public function approveUser(User $user, array $Tpdk)
    {
        $user->update(['status' => 'approved']);
        $user->Tpdk()->sync($Tpdk);

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
        $data['password'] = Hash::make(($data['password']));
        $data['status'] = $data['status'] ?? 'pending';

        $user = User::create($data);

        if (isset($data['role'])) {
            $user->assignRole($data['role']);
        }

        return $user;

    }

    public function updateUser(User $user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        if (isset($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        return $user;

    }

    public function deleteUser(User $user)
    {
        return $user->delete();

    }


}