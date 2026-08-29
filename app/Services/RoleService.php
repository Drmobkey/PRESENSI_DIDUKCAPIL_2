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
        $data['guard_name'] = $data['guard_name'] ?? 'web';
        return Role::create($data);
    }

    public function getRoleById($id)
    {
        return Role::findOrFail($id);
    }

    public function updateRole(Role $role, array $data)
    {
        $role->update($data);
        return $role;

    }

    public function deleteRole(Role $role)
    {

        $role->delete();
    }




}