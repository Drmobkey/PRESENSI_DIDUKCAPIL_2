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
        $tpdks = [
            ['name' => 'Disdukcapil Pusat', 'latitude' => -6.200000, 'longitude' => 106.816666, 'radius' => 100],
            ['name' => 'TPDK Kecamatan A', 'latitude' => -6.210000, 'longitude' => 106.820000, 'radius' => 50],
            ['name' => 'TPDK Kecamatan B', 'latitude' => -6.220000, 'longitude' => 106.830000, 'radius' => 50],
        ];

        foreach ($tpdks as $tpdk) {
            Tpdk::firstOrCreate(['name' => $tpdk['name']], $tpdk);
        }
    }
}
