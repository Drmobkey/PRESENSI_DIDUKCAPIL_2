<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <x-navbars.navs.auth titlePage='Profil Saya'></x-navbars.navs.auth>

        <div class="container-fluid px-2 px-md-4">

            {{-- Cover & Avatar --}}
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('{{ asset('/assets/img/Lawang_Sewu.jpg') }}');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>

            <div class="card card-body mx-3 mx-md-4 mt-n6 shadow-lg">

                {{-- Header Profil --}}
                <div class="row gx-4 mb-2 align-items-center">
                    <div class="col-auto">
                        <div
                            class="avatar avatar-xl position-relative bg-gradient-primary border-radius-lg d-flex align-items-center justify-content-center shadow">
                            <i class="material-icons text-white" style="font-size: 3rem;">account_circle</i>
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                            <p class="mb-0 font-weight-normal text-sm text-secondary">
                                {{ auth()->user()->getRoleNames()->implode(', ') ?: 'Tidak ada role' }}
                            </p>
                        </div>
                    </div>
                </div>

                <hr class="horizontal dark mt-2">

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible text-white" role="alert">
                        <span class="text-sm">{{ session('success') }}</span>
                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                            data-bs-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible text-white" role="alert">
                        <span class="text-sm">{{ session('error') }}</span>
                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                            data-bs-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if(is_array($errors) && count($errors) > 0)
                    <div class="alert alert-danger text-white">
                        <ul class="mb-0">
                            @foreach($errors as $err)
                                <li class="text-sm">{{ is_array($err) ? implode(', ', $err) : $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @elseif(is_object($errors) && method_exists($errors, 'any') && $errors->any())
                    <div class="alert alert-danger text-white">
                        <ul class="mb-0">@foreach($errors->all() as $err)
                        <li class="text-sm">{{ $err }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                {{-- Statistik Personal --}}
                <div class="row mb-4">
                    @php
                        $user = auth()->user();
                        $thisMonth = \Carbon\Carbon::now()->month;
                        $thisYear = \Carbon\Carbon::now()->year;
                        $attendanceCount = \App\Models\Attendance::where('user_id', $user->id)
                            ->whereMonth('date', $thisMonth)->whereYear('date', $thisYear)->count();
                        $leaveCount = \App\Models\Leave::where('user_id', $user->id)->count();
                        $logbookCount = \App\Models\Logbook::where('user_id', $user->id)->count();
                    @endphp
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card bg-gradient-primary shadow text-center p-3">
                            <i class="material-icons text-white mb-1">how_to_reg</i>
                            <h4 class="text-white mb-0">{{ $attendanceCount }}</h4>
                            <p class="text-white text-sm opacity-8 mb-0">Hadir Bulan Ini</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card bg-gradient-info shadow text-center p-3">
                            <i class="material-icons text-white mb-1">edit_calendar</i>
                            <h4 class="text-white mb-0">{{ $leaveCount }}</h4>
                            <p class="text-white text-sm opacity-8 mb-0">Total Pengajuan Izin</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-gradient-dark shadow text-center p-3">
                            <i class="material-icons text-white mb-1">menu_book</i>
                            <h4 class="text-white mb-0">{{ $logbookCount }}</h4>
                            <p class="text-white text-sm opacity-8 mb-0">Total Logbook</p>
                        </div>
                    </div>
                </div>

                {{-- Dua Kolom: Info Profil & Ganti Password --}}
                <div class="row">

                    {{-- Form Edit Profil --}}
                    <div class="col-md-6">
                        <div class="card card-plain">
                            <div class="card-header pb-0 px-0">
                                <h6 class="mb-0"><i class="material-icons text-sm align-middle me-1">person</i>
                                    Informasi Profil</h6>
                            </div>
                            <div class="card-body px-0">
                                <form method="POST" action="{{ route('user-profile') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label text-sm font-weight-bold">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control border border-2 px-3"
                                            value="{{ old('name', auth()->user()->name) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-sm font-weight-bold">Email</label>
                                        <input type="email" name="email" class="form-control border border-2 px-3"
                                            value="{{ old('email', auth()->user()->email) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-sm font-weight-bold">Unit Kerja (TPDK)</label>
                                        <input type="text" class="form-control border border-2 px-3 bg-light"
                                            value="{{ auth()->user()->tpdk?->nama ?? 'Belum ditetapkan' }}" readonly>
                                        <small class="text-muted">Unit kerja hanya bisa diubah oleh Admin.</small>
                                    </div>
                                    <button type="submit" class="btn bg-gradient-dark w-100">
                                        <i class="material-icons text-sm align-middle me-1">save</i> Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Ganti Password --}}
                    <div class="col-md-6">
                        <div class="card card-plain">
                            <div class="card-header pb-0 px-0">
                                <h6 class="mb-0"><i class="material-icons text-sm align-middle me-1">lock</i> Ganti
                                    Password</h6>
                            </div>
                            <div class="card-body px-0">
                                <form method="POST" action="{{ route('user-profile.password') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label text-sm font-weight-bold">Password Saat Ini</label>
                                        <input type="password" name="current_password"
                                            class="form-control border border-2 px-3"
                                            placeholder="Masukkan password lama" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-sm font-weight-bold">Password Baru</label>
                                        <input type="password" name="password" class="form-control border border-2 px-3"
                                            placeholder="Minimal 8 karakter" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-sm font-weight-bold">Konfirmasi Password
                                            Baru</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control border border-2 px-3" placeholder="Ulangi password baru"
                                            required>
                                    </div>
                                    <button type="submit" class="btn bg-gradient-primary w-100">
                                        <i class="material-icons text-sm align-middle me-1">vpn_key</i> Ganti Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <x-plugins></x-plugins>
</x-layout>