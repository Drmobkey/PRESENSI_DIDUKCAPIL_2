<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="check-page"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Presensi Saya"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <!-- Flash Message Alerts -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible text-white fade show mb-4 shadow-sm" role="alert">
                    <span class="text-sm"><i class="material-icons align-middle text-sm me-1">check_circle</i>
                        {{ session('success') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible text-white fade show mb-4 shadow-sm" role="alert">
                    <span class="text-sm"><i class="material-icons align-middle text-sm me-1">error</i>
                        {{ session('error') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row mt-4">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                        <div class="card-header p-0 position-relative z-index-2">
                            <div class="bg-gradient-info pt-5 pb-4 text-center">
                                <h6 class="text-white mb-0 text-uppercase tracking-wider opacity-8">Presensi Hari Ini
                                </h6>
                                <h2 class="text-white mt-2 mb-0" style="font-weight: 700; font-size: 1.5rem;">
                                    {{ now()->translatedFormat('l, d F Y') }}
                                </h2>
                            </div>
                        </div>

                        <div class="card-body text-center py-5 bg-white">
                            <!-- Digital Clock -->
                            <div class="digital-clock mb-4">
                                <span id="live-clock" class="text-info font-weight-bolder"
                                    style="font-size: 4rem; letter-spacing: -2px; line-height: 1; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">--:--:--</span>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-5 px-3">
                                <button type="button"
                                    class="btn btn-success btn-lg shadow-sm w-100 rounded-pill fs-6 py-3 {{ $todayAttendance ? 'opacity-50' : '' }}"
                                    id="btnCheckIn" {{ $todayAttendance ? 'disabled' : '' }}>
                                    <i class="material-icons align-middle me-2">login</i> Check In
                                </button>
                                <button type="button"
                                    class="btn btn-warning btn-lg shadow-sm w-100 rounded-pill fs-6 py-3 text-white {{ (!$todayAttendance || $todayAttendance->time_out) ? 'opacity-50' : '' }}"
                                    id="btnCheckOut" {{ (!$todayAttendance || $todayAttendance->time_out) ? 'disabled' : '' }}>
                                    <i class="material-icons align-middle me-2">logout</i> Check Out
                                </button>
                            </div>

                            @if ($todayAttendance)
                                <div class="mt-5 p-4 bg-gray-100 rounded-4 mx-3">
                                    <div class="row text-center">
                                        <div class="col-6 border-end border-light">
                                            <p class="text-xs text-secondary mb-1 text-uppercase font-weight-bold">Waktu
                                                Masuk</p>
                                            <h5 class="mb-0 text-dark">{{ $todayAttendance->time_in ?? '-' }}</h5>
                                            @if ($todayAttendance->is_late)
                                                <span class="badge badge-sm bg-gradient-danger mt-2">Terlambat {{ $todayAttendance->formatted_late_duration ? '(' . $todayAttendance->formatted_late_duration . ')' : '' }}</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-success mt-2">Tepat Waktu</span>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            <p class="text-xs text-secondary mb-1 text-uppercase font-weight-bold">Waktu
                                                Pulang</p>
                                            <h5 class="mb-0 text-dark">{{ $todayAttendance->time_out ?? '-' }}</h5>
                                            @if ($todayAttendance->time_out)
                                                <span class="badge badge-sm bg-gradient-success mt-2">Selesai</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mt-4">
                                    <p class="text-sm text-secondary mb-0">
                                        <i class="material-icons text-sm align-middle me-1">info</i> Anda belum melakukan
                                        Check In hari ini.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('attendances.index') }}"
                            class="btn btn-link text-info text-sm font-weight-bold">
                            <i class="material-icons align-middle text-sm me-1">history</i>
                            Lihat Riwayat Presensi Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>

    @include('attendances.partials.modal-check-in')
    @include('attendances.partials.modal-check-out')

    <script>
        // Jam realtime
        function updateClock() {
            const el = document.getElementById('live-clock');
            if (el) {
                el.textContent = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            }
        }
        updateClock();
        setInterval(updateClock, 1000);

        // Global Geolocation Logic for Modals
        function fetchLocation(modalType) {
            const statusEl = document.getElementById(modalType + '_location_status');
            const submitBtn = document.getElementById(modalType + '_submit_btn');
            const latInput = document.getElementById(modalType + '_latitude');
            const lngInput = document.getElementById(modalType + '_longitude');

            statusEl.className = 'alert alert-info text-white text-sm py-2 px-3 mb-3 d-flex align-items-center';
            statusEl.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Mengambil lokasi akurat...';
            submitBtn.disabled = true;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (pos) {
                        latInput.value = pos.coords.latitude;
                        lngInput.value = pos.coords.longitude;
                        const akurasi = Math.round(pos.coords.accuracy);
                        statusEl.className = 'alert alert-success text-white text-sm py-2 px-3 mb-3 d-flex align-items-center';
                        statusEl.innerHTML = '<i class="material-icons align-middle text-sm me-2">check_circle</i> Lokasi terdeteksi (akurasi ±' + akurasi + ' m)';
                        submitBtn.disabled = false;
                    },
                    function (error) {
                        statusEl.className = 'alert alert-danger text-white text-sm py-2 px-3 mb-3 d-flex align-items-center justify-content-between';
                        let pesan = 'Gagal mengambil lokasi.';
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                pesan = 'Izin lokasi ditolak browser.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                pesan = 'GPS tidak tersedia.';
                                break;
                            case error.TIMEOUT:
                                pesan = 'Waktu pencarian habis.';
                                break;
                        }
                        statusEl.innerHTML = '<div><i class="material-icons align-middle text-sm me-2">error</i> ' + pesan + '</div>' +
                            '<button type="button" class="btn btn-sm btn-outline-white mb-0" onclick="fetchLocation(\'' + modalType + '\')"><i class="material-icons text-sm align-middle">refresh</i> Coba Lagi</button>';
                    },
                    { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                );
            } else {
                statusEl.className = 'alert alert-danger text-white text-sm py-2 px-3 mb-3 d-flex align-items-center justify-content-between';
                statusEl.innerHTML = '<div>Browser tidak mendukung GPS.</div>' +
                    '<button type="button" class="btn btn-sm btn-outline-white mb-0" onclick="fetchLocation(\'' + modalType + '\')"><i class="material-icons text-sm align-middle">refresh</i> Coba Lagi</button>';
            }
        }

        document.getElementById('checkInModal').addEventListener('show.bs.modal', function () {
            fetchLocation('checkin');
        });

        document.getElementById('checkOutModal').addEventListener('show.bs.modal', function () {
            fetchLocation('checkout');
        });

        // Validation for Check In Time
        const btnCheckIn = document.getElementById('btnCheckIn');
        if(btnCheckIn) {
            btnCheckIn.addEventListener('click', function(e) {
                @if($schedule)
                    const currentTime = new Date();
                    const startParts = "{{ $schedule->start_time }}".split(':');
                    
                    const startTime = new Date();
                    startTime.setHours(parseInt(startParts[0]), parseInt(startParts[1]), parseInt(startParts[2] || 0), 0);
                    
                    // Batas paling awal check in (misal 2 jam sebelum jam masuk)
                    const earliestCheckIn = new Date(startTime.getTime() - (2 * 60 * 60 * 1000));
                    
                    if (currentTime < earliestCheckIn) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Belum Waktunya',
                            text: "Anda baru bisa Check In mulai pukul " + earliestCheckIn.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}) + ".",
                        });
                    } else {
                        // Show modal
                        const modal = new bootstrap.Modal(document.getElementById('checkInModal'));
                        modal.show();
                    }
                @else
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: "Jadwal operasional belum diatur hari ini.",
                    });
                @endif
            });
        }

        // Validation for Check Out Time
        const btnCheckOut = document.getElementById('btnCheckOut');
        if(btnCheckOut) {
            btnCheckOut.addEventListener('click', function(e) {
                @if($schedule)
                    const currentTime = new Date();
                    const endParts = "{{ $schedule->end_time }}".split(':');
                    
                    const endTime = new Date();
                    endTime.setHours(parseInt(endParts[0]), parseInt(endParts[1]), parseInt(endParts[2] || 0), 0);
                    
                    if (currentTime < endTime) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Belum Waktunya Pulang',
                            text: "Jam kerja hari ini berakhir pukul {{ $schedule->end_time }}.",
                        });
                    } else {
                        // Show modal
                        const modal = new bootstrap.Modal(document.getElementById('checkOutModal'));
                        modal.show();
                    }
                @else
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: "Jadwal operasional belum diatur hari ini.",
                    });
                @endif
            });
        }
    </script>

</x-layout>