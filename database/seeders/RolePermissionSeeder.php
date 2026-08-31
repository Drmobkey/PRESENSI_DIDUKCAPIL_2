<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'setup.users.index',
            'setup.users.show',
            'setup.users.store',
            'setup.users.update',
            'setup.users.destroy',

            'setup.roles.index',
            'setup.roles.show',
            'setup.roles.store',
            'setup.roles.update',
            'setup.roles.destroy',

            'setup.permissions.index',
            'setup.permissions.show',
            'setup.permissions.store',
            'setup.permissions.update',
            'setup.permissions.destroy',

            // Modul Presensi
            'attendances.index',
            'attendances.show',
            'attendances.store',
            'attendances.update',
            'attendances.destroy',
            'attendances.view_all',     // Untuk Superadmin melihat semua data
            'attendances.view_branch',  // Untuk Admin memantau cabang spesifik
            'attendances.view_own',     // Untuk User melihat riwayatnya sendiri

            // Modul Pengajuan Izin
            'leaves.index',
            'leaves.show',
            'leaves.store',
            'leaves.update',
            'leaves.destroy',
            'leaves.manage_all',        // Admin menyetujui izin
            'leaves.manage_branch',     // Admin Cabang menyetujui izin
            'leaves.manage_own',        // User mengajukan izin
            'leaves.bypass_status',     // User mem-bypass status

            // Modul Logbook
            'logbooks.index',
            'logbooks.show',
            'logbooks.store',
            'logbooks.update',
            'logbooks.destroy',
            'logbooks.manage_all',
            'logbooks.manage_branch',
            'logbooks.manage_own',

            // Modul TPDK
            'tpdks.index',
            'tpdks.show',
            'tpdks.store',
            'tpdks.update',
            'tpdks.destroy',

            // Modul Work Schedule
            'work_schedules.index',
            'work_schedules.show',
            'work_schedules.store',
            'work_schedules.update',
            'work_schedules.destroy',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // create roles and assign created permissions
        $role = Role::firstOrCreate(['name' => 'Superadmin']);
        $role->givePermissionTo(Permission::all());

        // create super admin user
        $user = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'status' => 'approved',
            ]
        );
        $user->assignRole($role);
    }
}
