<?php

namespace App\Services;

use App\Models\Tpdk;
use Exception;

class TpdkService
{
    public function getAllTpdks()
    {
        return Tpdk::latest()->paginate();
    }

    public function createTpdk(array $data): Tpdk
    {
        return Tpdk::create($data);
    }

    public function updateTpdk(Tpdk $tpdk, array $data): Tpdk
    {
        $tpdk->update($data);
        return $tpdk;
    }

    public function deleteTpdk(Tpdk $tpdk): bool
    {
        // Mencegah hapus jika TPDK terikat sebagai homebase pegawai atau histori presensi
        if ($tpdk->users()->exists() || $tpdk->attendances()->exists()) {
            throw new Exception("TPDK tidak dapat dihapus karena masih terikat dengan data pegawai atau histori presensi.");
        }

        return $tpdk->delete();
    }
}