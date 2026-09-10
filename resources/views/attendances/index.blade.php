<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <!-- Memanggil sidebar dengan activePage attendances agar tersorot -->
    <x-navbars.sidebar activePage="attendances"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Presensi Pegawai"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <!-- Flash Message Alerts -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible text-white fade show mb-4" role="alert">
                    <span class="text-sm"><i class="material-icons align-middle text-sm me-1">check_circle</i>
                        {{ session('success') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible text-white fade show mb-4" role="alert">
                    <span class="text-sm"><i class="material-icons align-middle text-sm me-1">error</i>
                        {{ session('error') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3 mb-0"><strong>Riwayat Presensi</strong></h6>

                                <!-- Aksi check-in/check-out sudah dipindah ke halaman /presensi -->
                                <div class="me-3">
                                    <a href="{{ route('attendances.export.excel', request()->all()) }}" class="btn btn-success btn-sm mb-0 shadow-sm me-2">
                                        <i class="material-icons text-sm align-middle">table_view</i> Excel
                                    </a>
                                    <a href="{{ route('attendances.export.pdf', request()->all()) }}" class="btn btn-danger btn-sm mb-0 shadow-sm me-2">
                                        <i class="material-icons text-sm align-middle">picture_as_pdf</i> PDF
                                    </a>
                                    <a href="{{ route('attendances.check-page') }}"
                                        class="btn btn-white btn-sm mb-0 shadow-sm">
                                        <i class="material-icons text-sm align-middle">fingerprint</i> Presensi Saya
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Form -->
                        <div class="card-body px-4 pb-3 mt-3 border-bottom">
                            <form action="{{ route('attendances.index') }}" method="GET"
                                class="row gx-2 gy-3 align-items-center">
                                @if(auth()->user()->can('attendances.view_all'))
                                    <div class="col-md-2 col-sm-6">
                                        <select name="user_id"
                                            class="form-select px-3 border border-2 border-light rounded text-sm"
                                            aria-label="Pilih Pegawai">
                                            <option value="">-- Semua Pegawai --</option>
                                            @foreach($users as $u)
                                                <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                                    {{ $u->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="col-md-2 col-sm-6">
                                    <select name="tpdk_id"
                                        class="form-select px-3 border border-2 border-light rounded text-sm"
                                        aria-label="Pilih TPDK">
                                        <option value="">-- Semua TPDK --</option>
                                        @foreach($tpdks as $t)
                                            <option value="{{ $t->id }}" {{ request('tpdk_id') == $t->id ? 'selected' : '' }}>
                                                {{ $t->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2 col-sm-6">
                                    <select name="status"
                                        class="form-select px-3 border border-2 border-light rounded text-sm"
                                        aria-label="Pilih Status">
                                        <option value="">-- Semua Status --</option>
                                        <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir
                                        </option>
                                        <option value="alpa" {{ request('status') == 'alpa' ? 'selected' : '' }}>Alpa
                                        </option>
                                        <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin
                                        </option>
                                        <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit
                                        </option>
                                        <option value="cuti" {{ request('status') == 'cuti' ? 'selected' : '' }}>Cuti
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-2 col-sm-6">
                                    <input type="date" name="start_date"
                                        class="form-control px-3 border border-2 border-light rounded text-sm"
                                        value="{{ request('start_date') }}" title="Tanggal Mulai">
                                </div>
                                <div class="col-md-2 col-sm-6">
                                    <input type="date" name="end_date"
                                        class="form-control px-3 border border-2 border-light rounded text-sm"
                                        value="{{ request('end_date') }}" title="Tanggal Akhir">
                                </div>

                                <div class="col-md-2 col-sm-12 d-flex">
                                    <button type="submit" class="btn btn-dark btn-sm mb-0 w-100 me-2"
                                        title="Terapkan Filter">Filter</button>
                                    @if(request()->hasAny(['user_id', 'tpdk_id', 'status', 'start_date', 'end_date']))
                                        <a href="{{ route('attendances.index') }}"
                                            class="btn btn-outline-dark btn-sm mb-0 w-100" title="Reset">Reset</a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                style="width: 5%;">
                                                NO
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                PEGAWAI
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                TANGGAL
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                LOKASI TPDK
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                WAKTU MASUK
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                WAKTU PULANG
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                STATUS
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                style="width: 10%;">
                                                AKSI
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Looping data $attendances dari Controller -->
                                        @forelse ($attendances as $attendance)
                                            <tr>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ $loop->iteration }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="d-flex px-3 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <!-- Memanggil relasi user -->
                                                            <h6 class="mb-0 text-sm font-weight-bold">
                                                                {{ $attendance->user->name ?? 'User Terhapus' }}
                                                            </h6>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ $attendance->user->email ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                                                    </span>
                                                </td>

                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        <!-- Memanggil relasi tpdk -->
                                                        {{ $attendance->tpdk->name ?? 'Di Luar TPDK / Izin' }}
                                                    </p>
                                                </td>

                                                <td class="align-middle text-center">
                                                    @if($attendance->time_in)
                                                        <span
                                                            class="text-dark text-sm font-weight-bold">{{ $attendance->time_in }}</span>
                                                        @if($attendance->is_late)
                                                            <br><span
                                                                class="badge badge-sm bg-gradient-danger text-xxs mt-1">Terlambat</span>
                                                        @endif
                                                    @else
                                                        <span class="text-secondary text-xs">-</span>
                                                    @endif
                                                </td>

                                                <td class="align-middle text-center">
                                                    @if($attendance->time_out)
                                                        <span
                                                            class="text-dark text-sm font-weight-bold">{{ $attendance->time_out }}</span>
                                                    @else
                                                        <span class="text-secondary text-xs">-</span>
                                                    @endif
                                                </td>

                                                <td class="align-middle text-center text-sm">
                                                    <!-- Menampilkan status (hadir, alpa, izin, dsb) -->
                                                    @if ($attendance->status === 'hadir')
                                                        <span class="badge badge-sm bg-gradient-success">Hadir</span>
                                                    @elseif ($attendance->status === 'alpa')
                                                        <span class="badge badge-sm bg-gradient-danger">Alpa</span>
                                                    @else
                                                        <span
                                                            class="badge badge-sm bg-gradient-info text-uppercase">{{ $attendance->status }}</span>
                                                    @endif
                                                </td>

                                                <td class="align-middle text-center">
                                                    <!-- Tombol Detail memicu modal -->
                                                    <button type="button" class="btn btn-link text-info p-2 mb-0"
                                                        data-bs-toggle="modal" data-bs-target="#showModal{{ $attendance->id }}"
                                                        title="Lihat Detail Foto & Peta">
                                                        <i class="material-icons text-lg">visibility</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            
                                            <!-- Include Modal Detail -->
                                            @include('attendances.show', ['attendance' => $attendance])
                                            
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4 text-secondary">
                                                    <i class="material-icons align-middle text-sm me-1">info</i> Belum ada
                                                    data presensi.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div
                                class="px-4 py-3 d-flex flex-column flex-md-row justify-content-between align-items-center border-top">
                                <p class="text-xs text-secondary mb-2 mb-md-0">
                                    Menampilkan <strong>{{ $attendances->firstItem() ?? 0 }}</strong> -
                                    <strong>{{ $attendances->lastItem() ?? 0 }}</strong> dari
                                    <strong>{{ $attendances->total() }}</strong> presensi
                                </p>
                                <div>
                                    {{ $attendances->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>

</x-layout>