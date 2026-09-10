<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Logbook;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $user = auth()->user();
        
        $isAdmin = $user->hasAnyRole(['admin', 'superadmin']);

        // Data array to pass to view
        $data = [
            'isAdmin' => $isAdmin,
        ];

        if ($isAdmin) {
            // ==========================================
            // ADMIN / SUPERADMIN DASHBOARD DATA
            // ==========================================

            // ─── Statistik Utama (Global) ───
            $totalPegawai    = User::count();
            
            $hadirTepatWaktu = Attendance::whereDate('date', $today)->where('status', 'hadir')->where('is_late', false)->count();
            $hadirTerlambat  = Attendance::whereDate('date', $today)->where('status', 'hadir')->where('is_late', true)->count();
            $izinSakitCuti   = Attendance::whereDate('date', $today)->whereIn('status', ['sakit', 'cuti', 'dinas_luar'])->count();
            
            $hadirHariIni    = $hadirTepatWaktu + $hadirTerlambat;
            $belumHadir      = max(0, $totalPegawai - ($hadirHariIni + $izinSakitCuti));

            $data['totalPegawai']   = $totalPegawai;
            $data['hadirHariIni']   = $hadirHariIni;
            $data['izinPending']    = Leave::where('status', 'pending')->count();
            $data['logbookPending'] = Logbook::where('status', 'pending')->count();
            $data['persenHadir']    = $totalPegawai > 0 ? round(($hadirHariIni / $totalPegawai) * 100) : 0;

            // ─── Chart Kehadiran 7 Hari Terakhir (Global) ───
            $chartLabels   = [];
            $dataHadir     = [];
            $dataTerlambat = [];
            
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $chartLabels[] = $date->translatedFormat('D, d M');
                
                $dataHadir[] = Attendance::whereDate('date', $date)->where('status', 'hadir')->where('is_late', false)->count();
                $dataTerlambat[] = Attendance::whereDate('date', $date)->where('status', 'hadir')->where('is_late', true)->count();
            }
            $data['chartLabels']   = $chartLabels;
            $data['dataHadir']     = $dataHadir;
            $data['dataTerlambat'] = $dataTerlambat;

            // ─── Chart Donut (Status Hari Ini Global) ───
            $data['donutData'] = [$hadirTepatWaktu, $hadirTerlambat, $izinSakitCuti, $belumHadir];

            // ─── Presensi Hari Ini (Global terbaru) ───
            $data['attendancesToday'] = Attendance::with('user')
                                ->whereDate('date', $today)
                                ->latest('time_in')
                                ->limit(6)
                                ->get();

            // ─── Pengajuan Terbaru (Global) ───
            $data['recentLeaves'] = Leave::with('user')
                            ->where('status', 'pending')
                            ->latest()
                            ->limit(4)
                            ->get();

            $data['recentLogbooks'] = Logbook::with('user')
                              ->where('status', 'pending')
                              ->latest()
                              ->limit(4)
                              ->get();

        } else {
            // ==========================================
            // USER (PEGAWAI) DASHBOARD DATA
            // ==========================================
            
            $thisMonth = Carbon::now()->month;
            $thisYear  = Carbon::now()->year;

            // ─── Statistik Utama (Personal) ───
            $data['izinPending']    = Leave::where('user_id', $user->id)->where('status', 'pending')->count();
            $data['logbookPending'] = Logbook::where('user_id', $user->id)->where('status', 'pending')->count();
            
            $hadirBulanIniTepat = Attendance::where('user_id', $user->id)->whereMonth('date', $thisMonth)->whereYear('date', $thisYear)->where('status', 'hadir')->where('is_late', false)->count();
            $hadirBulanIniTelat = Attendance::where('user_id', $user->id)->whereMonth('date', $thisMonth)->whereYear('date', $thisYear)->where('status', 'hadir')->where('is_late', true)->count();
            $izinBulanIni       = Attendance::where('user_id', $user->id)->whereMonth('date', $thisMonth)->whereYear('date', $thisYear)->whereIn('status', ['sakit', 'cuti', 'dinas_luar'])->count();
            $alphaBulanIni      = Attendance::where('user_id', $user->id)->whereMonth('date', $thisMonth)->whereYear('date', $thisYear)->where('status', 'alpha')->count(); // Jika ada

            $data['hadirBulanIni'] = $hadirBulanIniTepat + $hadirBulanIniTelat;
            $data['totalHariKerjaBerjalan'] = $data['hadirBulanIni'] + $izinBulanIni + $alphaBulanIni;
            $data['persenHadirPersonal'] = $data['totalHariKerjaBerjalan'] > 0 ? round(($data['hadirBulanIni'] / $data['totalHariKerjaBerjalan']) * 100) : 0;

            // Status Hari Ini
            $presensiHariIni = Attendance::where('user_id', $user->id)->whereDate('date', $today)->first();
            $data['statusHariIni'] = $presensiHariIni ? $presensiHariIni->status : 'belum_presensi';

            // ─── Chart Kehadiran 7 Hari Terakhir (Personal) ───
            $chartLabels   = [];
            $dataHadir     = [];
            $dataTerlambat = [];
            
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $chartLabels[] = $date->translatedFormat('D, d M');
                
                $att = Attendance::where('user_id', $user->id)->whereDate('date', $date)->first();
                $dataHadir[] = ($att && $att->status === 'hadir' && !$att->is_late) ? 1 : 0;
                $dataTerlambat[] = ($att && $att->status === 'hadir' && $att->is_late) ? 1 : 0;
            }
            $data['chartLabels']   = $chartLabels;
            $data['dataHadir']     = $dataHadir;
            $data['dataTerlambat'] = $dataTerlambat;

            // ─── Chart Donut (Status Bulan Ini Personal) ───
            $data['donutData'] = [$hadirBulanIniTepat, $hadirBulanIniTelat, $izinBulanIni, $alphaBulanIni];

            // ─── Presensi 7 Hari Terakhir (Personal table) ───
            $data['recentAttendances'] = Attendance::where('user_id', $user->id)
                                ->latest('date')
                                ->limit(7)
                                ->get();

            // ─── Pengajuan Terbaru (Personal) ───
            $data['recentLeaves'] = Leave::where('user_id', $user->id)
                            ->latest()
                            ->limit(4)
                            ->get();

            $data['recentLogbooks'] = Logbook::where('user_id', $user->id)
                              ->latest()
                              ->limit(4)
                              ->get();
        }

        return view('dashboard.index', $data);
    }
}
