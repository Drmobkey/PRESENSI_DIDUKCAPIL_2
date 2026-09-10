<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Dashboard"></x-navbars.navs.auth>

        <div class="container-fluid py-4">

            {{-- ─── Flash Messages ─────────────────────────────────────────── --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible text-white mb-3" role="alert">
                    <span class="text-sm"><i class="material-icons text-sm align-middle me-1">check_circle</i> {{ session('success') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            {{-- ======================================================== --}}
            {{-- ADMIN / SUPERADMIN VIEW --}}
            {{-- ======================================================== --}}
            @hasanyrole('admin|superadmin')
            
            {{-- ─── Kartu Statistik Global ─────────────────────────────────── --}}
            <div class="row">
                {{-- Total Pegawai --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">people</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Pegawai</p>
                                <h4 class="mb-0">{{ $totalPegawai }}</h4>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-0">
                            <hr class="dark horizontal my-2">
                            <div class="d-flex justify-content-between">
                                <p class="mb-0 text-sm">Keseluruhan sistem</p>
                                <a href="{{ route('setup.users.index') }}" class="text-primary text-sm font-weight-bold">Lihat &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Hadir Hari Ini --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">how_to_reg</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Hadir Hari Ini</p>
                                <h4 class="mb-0">{{ $hadirHariIni }}</h4>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-0">
                            <hr class="dark horizontal my-2">
                            <div class="progress-wrapper">
                                <div class="progress-info d-flex justify-content-between mb-1">
                                    <span class="text-sm">Persentase Kehadiran</span>
                                    <span class="text-sm font-weight-bold">{{ $persenHadir }}%</span>
                                </div>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-gradient-success" role="progressbar"
                                        style="width: {{ $persenHadir }}%" aria-valuenow="{{ $persenHadir }}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Izin Pending --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">edit_calendar</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Izin Menunggu</p>
                                <h4 class="mb-0 {{ $izinPending > 0 ? 'text-warning' : '' }}">{{ $izinPending }}</h4>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-0 d-flex flex-column justify-content-end">
                            <hr class="dark horizontal my-2">
                            @if($izinPending > 0)
                                <a href="{{ route('leaves.index') }}"
                                    class="mb-0 text-sm text-warning font-weight-bold d-flex align-items-center">
                                    <i class="material-icons text-sm me-1">warning</i> Perlu aksi &rarr;
                                </a>
                            @else
                                <span class="mb-0 text-sm text-success d-flex align-items-center">
                                    <i class="material-icons text-sm me-1">check_circle</i> Semua diproses
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Logbook Pending --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">menu_book</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Logbook Menunggu</p>
                                <h4 class="mb-0 {{ $logbookPending > 0 ? 'text-info' : '' }}">{{ $logbookPending }}</h4>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-0 d-flex flex-column justify-content-end">
                            <hr class="dark horizontal my-2">
                            @if($logbookPending > 0)
                                <a href="{{ route('logbooks.index') }}"
                                    class="mb-0 text-sm text-info font-weight-bold d-flex align-items-center">
                                    <i class="material-icons text-sm me-1">warning</i> Perlu aksi &rarr;
                                </a>
                            @else
                                <span class="mb-0 text-sm text-success d-flex align-items-center">
                                    <i class="material-icons text-sm me-1">check_circle</i> Semua diproses
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─── Baris Charts Global ───────────────────────────────────────── --}}
            <div class="row mt-5">
                {{-- Chart Kehadiran 7 Hari --}}
                <div class="col-lg-8 col-md-6 mb-4">
                    <div class="card z-index-2">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-kehadiran-global" class="chart-canvas" height="220"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0">Tren Kehadiran Instansi (7 Hari)</h6>
                            <p class="text-sm mb-0">Perbandingan Hadir Tepat Waktu dan Terlambat</p>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Chart Donut Status Presensi Hari Ini --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6>Status Presensi Hari Ini</h6>
                            <p class="text-sm mb-0">Distribusi seluruh pegawai</p>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart">
                                <canvas id="chart-donut-global" class="chart-canvas" height="220"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─── Baris Tabel & Timeline Global ────────────────────────────── --}}
            <div class="row mt-2">
                {{-- Tabel Presensi Hari Ini --}}
                <div class="col-lg-8 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6>Aktivitas Presensi Terbaru</h6>
                            <p class="text-sm mb-0">Data absensi real-time hari ini</p>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pegawai</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Masuk</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Keluar</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($attendancesToday as $att)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-3 py-1 align-items-center">
                                                        <div class="avatar avatar-sm bg-gradient-{{ in_array($att->status, ['hadir', 'terlambat']) ? 'success' : 'secondary' }} me-3">
                                                            <span class="text-white text-xs font-weight-bold">{{ substr($att->user->name, 0, 2) }}</span>
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $att->user->name }}</h6>
                                                            <span class="text-xs text-secondary">{{ $att->user->tpdk?->nama ?? 'Pusat' }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-dark font-weight-bold">{{ $att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('H:i') : '—' }}</span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-dark font-weight-bold">{{ $att->time_out ? \Carbon\Carbon::parse($att->time_out)->format('H:i') : '—' }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @php
                                                        $badgeColor = match ($att->status) {
                                                            'hadir' => 'success',
                                                            'terlambat' => 'warning',
                                                            'sakit', 'cuti', 'dinas_luar' => 'info',
                                                            default => 'secondary',
                                                        };
                                                    @endphp
                                                    <span class="badge badge-sm bg-gradient-{{ $badgeColor }} text-capitalize">
                                                        {{ str_replace('_', ' ', $att->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-secondary py-4">Belum ada presensi yang masuk.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Timeline Pengajuan Terbaru --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6>Tugas Menunggu (Pending)</h6>
                            <p class="text-sm mb-0">Izin & Logbook yang belum disetujui</p>
                        </div>
                        <div class="card-body p-3">
                            <div class="timeline timeline-one-side mt-2">
                                @forelse($recentLeaves as $leave)
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <i class="material-icons text-warning text-gradient">edit_calendar</i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">
                                                Izin {{ str_replace('_', ' ', $leave->type) }} — {{ $leave->user->name }}
                                            </h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                {{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }} &middot; <span class="text-warning">{{ $leave->created_at->diffForHumans() }}</span>
                                            </p>
                                        </div>
                                    </div>
                                @empty @endforelse

                                @forelse($recentLogbooks as $logbook)
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <i class="material-icons text-info text-gradient">menu_book</i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">
                                                Logbook — {{ $logbook->user->name }}
                                            </h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                {{ \Carbon\Carbon::parse($logbook->date)->format('d M') }} &middot; <span class="text-info">{{ $logbook->created_at->diffForHumans() }}</span>
                                            </p>
                                        </div>
                                    </div>
                                @empty @endforelse

                                @if($recentLeaves->isEmpty() && $recentLogbooks->isEmpty())
                                    <div class="text-center py-5">
                                        <div class="icon icon-lg icon-shape bg-gradient-success shadow text-center border-radius-md mb-3 mx-auto">
                                            <i class="material-icons opacity-10">task_alt</i>
                                        </div>
                                        <h6 class="text-dark mb-0">Luar Biasa!</h6>
                                        <p class="text-sm text-secondary">Semua pengajuan telah diproses.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @else
            {{-- ======================================================== --}}
            {{-- USER (PEGAWAI) VIEW --}}
            {{-- ======================================================== --}}

            {{-- ─── Kartu Statistik Personal ───────────────────────────────── --}}
            <div class="row">
                {{-- Kehadiran Saya Bulan Ini --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">fact_check</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Kehadiran Bulan Ini</p>
                                <h4 class="mb-0">{{ $hadirBulanIni }} <span class="text-sm">hari</span></h4>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-0">
                            <hr class="dark horizontal my-2">
                            <div class="progress-wrapper">
                                <div class="progress-info d-flex justify-content-between mb-1">
                                    <span class="text-sm">Rasio Berjalan</span>
                                    <span class="text-sm font-weight-bold">{{ $persenHadirPersonal }}%</span>
                                </div>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-gradient-primary" role="progressbar"
                                        style="width: {{ $persenHadirPersonal }}%" aria-valuenow="{{ $persenHadirPersonal }}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status Hari Ini --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header p-3 pt-2">
                            @php
                                $statusIcon = match($statusHariIni) {
                                    'hadir', 'terlambat' => 'fingerprint',
                                    'sakit', 'cuti', 'dinas_luar' => 'event_busy',
                                    default => 'help_outline'
                                };
                                $statusBg = match($statusHariIni) {
                                    'hadir' => 'bg-gradient-success shadow-success',
                                    'terlambat' => 'bg-gradient-warning shadow-warning',
                                    'sakit', 'cuti', 'dinas_luar' => 'bg-gradient-info shadow-info',
                                    default => 'bg-gradient-secondary shadow-secondary'
                                };
                            @endphp
                            <div class="icon icon-lg icon-shape {{ $statusBg }} text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">{{ $statusIcon }}</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Presensi Hari Ini</p>
                                <h4 class="mb-0 text-capitalize">
                                    @if($statusHariIni === 'belum_presensi')
                                        Belum Absen
                                    @else
                                        {{ str_replace('_', ' ', $statusHariIni) }}
                                    @endif
                                </h4>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-0 d-flex flex-column justify-content-end">
                            <hr class="dark horizontal my-2">
                            @if($statusHariIni === 'belum_presensi')
                                <a href="{{ route('attendances.index') }}" class="mb-0 text-sm text-secondary font-weight-bold d-flex align-items-center">
                                    <i class="material-icons text-sm me-1">touch_app</i> Isi presensi sekarang &rarr;
                                </a>
                            @else
                                <span class="mb-0 text-sm text-success d-flex align-items-center">
                                    <i class="material-icons text-sm me-1">check_circle</i> Data terekam
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Izin Saya Pending --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">edit_calendar</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Izin Saya (Pending)</p>
                                <h4 class="mb-0 {{ $izinPending > 0 ? 'text-warning' : '' }}">{{ $izinPending }}</h4>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-0 d-flex flex-column justify-content-end">
                            <hr class="dark horizontal my-2">
                            <a href="{{ route('leaves.index') }}" class="mb-0 text-sm text-primary font-weight-bold d-flex align-items-center">
                                Lihat riwayat &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Logbook Saya Pending --}}
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">menu_book</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Logbook Saya (Pending)</p>
                                <h4 class="mb-0 {{ $logbookPending > 0 ? 'text-info' : '' }}">{{ $logbookPending }}</h4>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-0 d-flex flex-column justify-content-end">
                            <hr class="dark horizontal my-2">
                            <a href="{{ route('logbooks.index') }}" class="mb-0 text-sm text-primary font-weight-bold d-flex align-items-center">
                                Kelola logbook &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─── Baris Charts Personal ────────────────────────────────────── --}}
            <div class="row mt-5">
                {{-- Chart Kehadiran Saya 7 Hari --}}
                <div class="col-lg-8 col-md-6 mb-4">
                    <div class="card z-index-2">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-kehadiran-personal" class="chart-canvas" height="220"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0">Aktivitas 7 Hari Terakhir</h6>
                            <p class="text-sm mb-0">Riwayat presensi harian Anda</p>
                        </div>
                    </div>
                </div>

                {{-- Chart Donut Status Bulan Ini (Personal) --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6>Ringkasan Bulan Ini</h6>
                            <p class="text-sm mb-0">Distribusi presensi Anda bulan berjalan</p>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart">
                                <canvas id="chart-donut-personal" class="chart-canvas" height="220"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─── Baris Tabel & Timeline Personal ──────────────────────────── --}}
            <div class="row mt-2">
                {{-- Histori Kehadiran --}}
                <div class="col-lg-8 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6>Riwayat Absensi Terakhir</h6>
                            <p class="text-sm mb-0">Data absensi harian Anda</p>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Masuk</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Keluar</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentAttendances as $att)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-3 py-1 align-items-center">
                                                        <h6 class="mb-0 text-sm">{{ \Carbon\Carbon::parse($att->date)->translatedFormat('l, d M Y') }}</h6>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-dark font-weight-bold">{{ $att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('H:i') : '—' }}</span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-dark font-weight-bold">{{ $att->time_out ? \Carbon\Carbon::parse($att->time_out)->format('H:i') : '—' }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @php
                                                        $badgeColor = match ($att->status) {
                                                            'hadir' => 'success',
                                                            'terlambat' => 'warning',
                                                            'sakit', 'cuti', 'dinas_luar' => 'info',
                                                            default => 'secondary',
                                                        };
                                                    @endphp
                                                    <span class="badge badge-sm bg-gradient-{{ $badgeColor }} text-capitalize">
                                                        {{ str_replace('_', ' ', $att->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-secondary py-4">Belum ada riwayat.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status Pengajuan (Timeline) --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6>Status Pengajuan</h6>
                            <p class="text-sm mb-0">Izin & Logbook terakhir Anda</p>
                        </div>
                        <div class="card-body p-3">
                            <div class="timeline timeline-one-side mt-2">
                                @forelse($recentLeaves as $leave)
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            @php 
                                                $iconColor = $leave->status === 'approved' ? 'success' : ($leave->status === 'rejected' ? 'danger' : 'warning'); 
                                            @endphp
                                            <i class="material-icons text-{{ $iconColor }} text-gradient">edit_calendar</i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">
                                                Izin {{ str_replace('_', ' ', $leave->type) }}
                                            </h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                {{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }} &middot; 
                                                <span class="badge badge-sm bg-gradient-{{ $iconColor }}">{{ $leave->status }}</span>
                                            </p>
                                        </div>
                                    </div>
                                @empty @endforelse

                                @forelse($recentLogbooks as $logbook)
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            @php 
                                                $iconColor = $logbook->status === 'approved' ? 'success' : ($logbook->status === 'rejected' ? 'danger' : 'warning'); 
                                            @endphp
                                            <i class="material-icons text-{{ $iconColor }} text-gradient">menu_book</i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">
                                                Logbook
                                            </h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                {{ \Carbon\Carbon::parse($logbook->date)->format('d M') }} &middot; 
                                                <span class="badge badge-sm bg-gradient-{{ $iconColor }}">{{ $logbook->status }}</span>
                                            </p>
                                        </div>
                                    </div>
                                @empty @endforelse

                                @if($recentLeaves->isEmpty() && $recentLogbooks->isEmpty())
                                    <div class="text-center py-5">
                                        <div class="icon icon-lg icon-shape bg-gradient-secondary shadow text-center border-radius-md mb-3 mx-auto">
                                            <i class="material-icons opacity-10">history</i>
                                        </div>
                                        <p class="text-sm text-secondary">Belum ada pengajuan.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endhasanyrole
        </div>
    </main>
    <x-plugins></x-plugins>

    @push('js')
        <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
        
        <script>
            // ─── CONFIGURATION FOR BAR CHART ───
            var barOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#fff',
                            font: { size: 12, family: "Roboto" },
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#344767',
                        bodyColor: '#344767',
                        borderColor: '#e9ecef',
                        borderWidth: 1,
                        padding: 10,
                        usePointStyle: true
                    }
                },
                interaction: { intersect: false, mode: 'index' },
                scales: {
                    y: {
                        stacked: true,
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            suggestedMin: 0,
                            beginAtZero: true,
                            padding: 10,
                            font: { size: 13, weight: 300, family: "Roboto" },
                            color: "#fff",
                            stepSize: 1,
                        }
                    },
                    x: {
                        stacked: true,
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: { size: 12, weight: 300, family: "Roboto" },
                        }
                    },
                },
            };

            var barData = {
                labels: @json($chartLabels),
                datasets: [
                    {
                        label: "Tepat Waktu",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "rgba(255, 255, 255, 1)",
                        data: @json($dataHadir),
                        maxBarThickness: 15,
                    },
                    {
                        label: "Terlambat",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "rgba(255, 255, 255, 0.4)", // Translucent white for contrast
                        data: @json($dataTerlambat),
                        maxBarThickness: 15,
                    }
                ],
            };

            // ─── CONFIGURATION FOR DONUT CHART ───
            var donutOptions = {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: { size: 12, family: "Roboto" }
                        }
                    }
                },
            };

            var donutDataObj = {
                labels: ["Hadir Tepat Waktu", "Terlambat", "Izin/Sakit", "Belum Hadir/Alpha"],
                datasets: [{
                    data: @json($donutData),
                    backgroundColor: [
                        "#4CAF50", // Success (Hadir)
                        "#FF9800", // Warning (Terlambat)
                        "#03A9F4", // Info (Izin)
                        "#e9ecef"  // Gray (Belum Hadir)
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }],
            };

            // Initialize Charts conditionally based on DOM elements
            if (document.getElementById("chart-kehadiran-global")) {
                new Chart(document.getElementById("chart-kehadiran-global").getContext("2d"), {
                    type: "bar",
                    data: barData,
                    options: barOptions
                });
            }

            if (document.getElementById("chart-donut-global")) {
                new Chart(document.getElementById("chart-donut-global").getContext("2d"), {
                    type: "doughnut",
                    data: donutDataObj,
                    options: donutOptions
                });
            }

            if (document.getElementById("chart-kehadiran-personal")) {
                new Chart(document.getElementById("chart-kehadiran-personal").getContext("2d"), {
                    type: "bar",
                    data: barData,
                    options: barOptions
                });
            }

            if (document.getElementById("chart-donut-personal")) {
                new Chart(document.getElementById("chart-donut-personal").getContext("2d"), {
                    type: "doughnut",
                    data: donutDataObj,
                    options: donutOptions
                });
            }
        </script>
    @endpush
</x-layout>