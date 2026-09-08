<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService
{

    public function getAllRoles()
    {
        return Role::paginate(10);
    }

    public function createRole(array $data)
    {
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']); // Hapus dari array agar tidak error saat create

        $data['guard_name'] = $data['guard_name'] ?? 'web';
        $role = Role::create($data);

        $role->syncPermissions($permissions); // Sinkronisasi otomatis Spatie
        return $role;
    }

    public function getRoleById($id)
    {
        return Role::findOrFail($id);
    }

    public function updateRole(Role $role, array $data)
    {
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        $role->update($data);
        $role->syncPermissions($permissions);

        return $role;

    }

    public function deleteRole(Role $role)
    {

        $role->delete();
    }




}