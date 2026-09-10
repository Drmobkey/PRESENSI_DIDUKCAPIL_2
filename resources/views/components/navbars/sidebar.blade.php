@props(['activePage'])

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('dashboard') }} ">
            <img src="{{ asset('assets/img/Lambang_Kota_Semarang.png') }}" class="navbar-brand-img h-100"
                alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">Dashboard</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main"
        style="height: calc(100vh - 100px) !important;">
        <ul class="navbar-nav">

            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <!-- 
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Pages</h6>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'tables' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('tables') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">Tables</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'billing' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('billing') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Billing</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'virtual-reality' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('virtual-reality') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">view_in_ar</i>
                    </div>
                    <span class="nav-link-text ms-1">Virtual Reality</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'rtl' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('rtl') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                    </div>
                    <span class="nav-link-text ms-1">RTL</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'notifications' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('notifications') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">notifications</i>
                    </div>
                    <span class="nav-link-text ms-1">Notifications</span>
                </a>
            </li> -->

            <!-- ===================== KATEGORI BARU: AKTIVITAS ===================== -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Aktivitas</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'check-page' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('attendances.check-page') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">fingerprint</i>
                    </div>
                    <span class="nav-link-text ms-1">Presensi Saya</span>
                </a>
            </li>
            @can('attendances.index')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'attendances' ? ' active bg-gradient-primary' : '' }} "
                        href="{{ route('attendances.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">how_to_reg</i>
                        </div>
                        <span class="nav-link-text ms-1">Presensi Pegawai</span>
                    </a>
                </li>
            @endcan

            @can('logbooks.index')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'logbooks' ? ' active bg-gradient-primary' : '' }} "
                        href="{{ route('logbooks.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">menu_book</i>
                        </div>
                        <span class="nav-link-text ms-1">Jurnal / Logbook</span>
                    </a>
                </li>
            @endcan

            @can('leaves.index')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'leaves' ? ' active bg-gradient-primary' : '' }} "
                        href="{{ route('leaves.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">edit_calendar</i>
                        </div>
                        <span class="nav-link-text ms-1">Pengajuan Izin</span>
                    </a>
                </li>
            @endcan
            <!-- =================================================================== -->

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Setup</h6>
            </li>


            @can('work_schedules.index')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'workschedules' ? ' active bg-gradient-primary' : '' }} "
                        href="{{ route('workschedules.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">schedule</i>
                        </div>
                        <span class="nav-link-text ms-1">Jadwal Kerja</span>
                    </a>
                </li>
            @endcan

            @can('tpdks.index')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'tpdk-management' ? ' active bg-gradient-primary' : '' }} "
                        href="{{ route('tpdks.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">apartment</i>
                        </div>
                        <span class="nav-link-text ms-1">Data TPDK</span>
                    </a>
                </li>
            @endcan

            @can('setup.users.index')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'user-management' ? ' active bg-gradient-primary' : '' }} "
                        href="{{ route('setup.users.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">people</i>
                        </div>
                        <span class="nav-link-text ms-1">User Management</span>
                    </a>
                </li>
            @endcan

            @can('setup.roles.index')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'role-management' ? ' active bg-gradient-primary' : '' }} "
                        href="{{ route('setup.roles.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">security</i>
                        </div>
                        <span class="nav-link-text ms-1">Role Management</span>
                    </a>
                </li>
            @endcan

            @can('setup.permissions.index')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'permission-management' ? ' active bg-gradient-primary' : '' }} "
                        href="{{ route('setup.permissions.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">vpn_key</i>
                        </div>
                        <span class="nav-link-text ms-1">Permission Management</span>
                    </a>
                </li>
            @endcan

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Akun</h6>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'profile' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('profile') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'user-profile' ? 'active bg-gradient-primary' : '' }} "
                    href="{{ route('user-profile') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
        </ul>
    </div>
</aside>