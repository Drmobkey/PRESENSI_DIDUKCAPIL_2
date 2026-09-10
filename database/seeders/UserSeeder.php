<?php

namespace Database\Seeders;

use App\Models\Tpdk;
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
        $faker = \Faker\Factory::create('id_ID');

        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleUser = Role::firstOrCreate(['name' => 'User']);

        $tpdk = Tpdk::first();

        // Main Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin TPDK Pusat',
                'password' => Hash::make('password'),
                'status' => 'approved',
                'tpdk_id' => $tpdk->id,
            ]
        );
        $admin->assignRole($roleAdmin);

        // Main User
        $pegawai = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Pegawai TPDK Pusat',
                'password' => Hash::make('password'),
                'status' => 'approved',
                'tpdk_id' => $tpdk->id,
            ]
        );
        $pegawai->assignRole($roleUser);

        // Get all TPDK IDs
        $tpdkIds = Tpdk::pluck('id')->toArray();

        // Generate 50 random users
        for ($i = 0; $i < 50; $i++) {
            $randomUser = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'status' => $faker->randomElement(['approved', 'pending']),
                'tpdk_id' => $faker->randomElement($tpdkIds)
            ]);
            $randomUser->assignRole($roleUser);
        }
    }
}
