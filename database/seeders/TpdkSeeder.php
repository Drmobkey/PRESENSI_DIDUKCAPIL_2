<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tpdk;

class TpdkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // Static TPDKs
        $tpdks = [
            ['name' => 'Disdukcapil Pusat', 'alamat' => 'Jl. Pusat Pemerintahan', 'latitude' => -6.200000, 'longitude' => 106.816666, 'radius' => 100],
            ['name' => 'TPDK Kecamatan A', 'alamat' => 'Jl. Kecamatan A No. 1', 'latitude' => -6.210000, 'longitude' => 106.820000, 'radius' => 50],
            ['name' => 'TPDK Kecamatan B', 'alamat' => 'Jl. Kecamatan B No. 2', 'latitude' => -6.220000, 'longitude' => 106.830000, 'radius' => 50],
        ];

        foreach ($tpdks as $tpdk) {
            Tpdk::firstOrCreate(['name' => $tpdk['name']], $tpdk);
        }

        // Generate 20 Random TPDKs in Indonesia
        for ($i = 0; $i < 20; $i++) {
            Tpdk::create([
                'name' => 'TPDK Kecamatan ' . $faker->city,
                'alamat' => $faker->address,
                'latitude' => $faker->latitude(-11, 6), // Indonesia latitude bounds roughly
                'longitude' => $faker->longitude(95, 141), // Indonesia longitude bounds roughly
                'radius' => $faker->randomElement([50, 100, 150, 200])
            ]);
        }
    }
}
