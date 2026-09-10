<?php

namespace App\Services;

use App\Models\Tpdk;
use Exception;

class GeolocationService
{
    /**
     * Menghitung jarak menggunakan Haversine Formula.
     * Mengembalikan jarak dalam satuan meter.
     */

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        // Jari-jari bumi dalam meter
        $earthRadius = 6371000;

        // Konversi derajat ke radian
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        //Selisih Kordinat
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        //rumus Haversine
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    /**
     * Mencari cabang TPDK terdekat yang masih dalam batas radius aman.
     */
    public function findNearestValidTpdk($userLat, $userLon)
    {
        $tpdks = Tpdk::all();

        if ($tpdks->isEmpty()) {
            throw new Exception("Data master TPDK belum tersedia di sistem");
        }

        $nearestTpdk = null;
        $shortestDistance = PHP_FLOAT_MAX;

        foreach ($tpdks as $tpdk) {
            $distance = $this->calculateDistance($userLat, $userLon, $tpdk->latitude, $tpdk->longitude);

            if ($distance < $shortestDistance) {
                $shortestDistance = $distance;
                $nearestTpdk = $tpdk;
            }

        }

        // Cek apakah jarak terdekat tersebut masih masuk dalam radius toleransi TPDK terkait
        if ($nearestTpdk && $shortestDistance <= $nearestTpdk->radius) {
            // Kita simpan info jarak untuk bisa ditampilkan ke user jika perlu
            $nearestTpdk->distance_from_user = round($shortestDistance, 2);
            return $nearestTpdk;
        }

        // Jika jarak terdekat ternyata melebihi radius, lemparkan error
        throw new Exception("Anda berada di luar jangkauan presensi. Cabang terdekat berjarak " . round($shortestDistance, 2) . " meter.");

    }

}