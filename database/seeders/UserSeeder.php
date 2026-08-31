<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleUser = Role::firstOrCreate(['name' => 'User']);

        $tpdk = \App\Models\Tpdk::firstOrCreate([
            'name' => 'TPDK Kecamatan A',
        ], [
            'latitude' => -6.210000, 
            'longitude' => 106.820000, 
            'radius' => 50
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin TPDK A',
                'password' => Hash::make('password'),
                'status' => 'approved',
                'tpdk_id' => $tpdk->id,
            ]
        );
        $admin->assignRole($roleAdmin);

        $pegawai = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Pegawai TPDK A',
                'password' => Hash::make('password'),
                'status' => 'approved',
                'tpdk_id' => $tpdk->id,
            ]
        );
        $pegawai->assignRole($roleUser);
    }
}
