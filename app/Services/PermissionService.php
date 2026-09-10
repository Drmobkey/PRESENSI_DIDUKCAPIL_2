<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService
{

    public function getAllPermission()
    {

        return Permission::paginate(10);
    }

    public function createPermission(array $data)
    {
        $data['guard_name'] = $data['guard_name'] ?? 'web';
        return Permission::create($data);
    }

    public function updatePermission(Permission $permission, array $data)
    {
        $permission->update($data);
        return $permission;
    }

    public function deletePermission(Permission $permission)
    {
        if ($permission->roles()->count() > 0 || $permission->users()->count() > 0) {
            throw new \Exception('Permission sedang digunakan oleh Role atau User dan tidak dapat dihapus.');
        }
        $permission->delete();
    }

}