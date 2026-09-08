<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="user-management"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="User Management"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <!-- Flash Message Alerts -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible text-white fade show mb-4" role="alert">
                    <span class="text-sm"><i class="material-icons align-middle text-sm me-1">check_circle</i> {{ session('success') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible text-white fade show mb-4" role="alert">
                    <span class="text-sm"><i class="material-icons align-middle text-sm me-1">error</i> {{ session('error') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible text-white fade show mb-4" role="alert">
                    <span class="text-sm font-weight-bold"><i class="material-icons align-middle text-sm me-1">warning</i> Terdapat kesalahan pengisian data:</span>
                    <ul class="mb-0 text-sm ps-3 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3 mb-0"><strong>Tabel User Management</strong></h6>
                                @can('setup.users.store')
                                    <div class="pe-3">
                                        <button type="button" class="btn bg-gradient-dark btn-sm mb-0 shadow-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                                            <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Tambah User
                                        </button>
                                    </div>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 5%;">
                                                NO
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                PENGGUNA
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                ROLE
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                TPDK UTAMA
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                STATUS
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                TANGGAL DAFTAR
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 15%;">
                                                AKSI
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $index => $user)
                                            <tr>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="d-flex px-3 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm font-weight-bold">{{ $user->name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="align-middle text-center text-sm">
                                                    <span class="badge badge-sm border border-info text-info bg-transparent">
                                                        {{ $user->roles->first()->name ?? 'User' }}
                                                    </span>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $user->primary_tpdk->name ?? '-' }}
                                                    </p>
                                                </td>

                                                <td class="align-middle text-center text-sm">
                                                    @if ($user->status === 'approved')
                                                        <span class="badge badge-sm bg-gradient-success">Approved</span>
                                                    @elseif ($user->status === 'pending')
                                                        <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                                    @else
                                                        <span class="badge badge-sm bg-gradient-danger">Rejected</span>
                                                    @endif
                                                </td>

                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}
                                                    </span>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                                        @can('setup.users.update')
                                                            <!-- Button Approve (hanya jika belum approved) -->
                                                            @if ($user->status !== 'approved')
                                                                <button type="button" class="btn btn-link text-success p-2 mb-0" 
                                                                    data-bs-toggle="modal" data-bs-target="#approveUserModal-{{ $user->id }}" 
                                                                    title="Setujui Akun">
                                                                    <i class="material-icons text-lg">check_circle</i>
                                                                </button>
                                                            @endif

                                                            <!-- Button Reject (hanya jika belum rejected) -->
                                                            @if ($user->status !== 'rejected')
                                                                <button type="button" class="btn btn-link text-warning p-2 mb-0" 
                                                                    data-bs-toggle="modal" data-bs-target="#rejectUserModal-{{ $user->id }}" 
                                                                    title="Tolak Akun">
                                                                    <i class="material-icons text-lg">block</i>
                                                                </button>
                                                            @endif

                                                            <!-- Button Edit -->
                                                            <button type="button" class="btn btn-link text-info p-2 mb-0" 
                                                                data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}" 
                                                                title="Edit User">
                                                                <i class="material-icons text-lg">edit</i>
                                                            </button>
                                                        @endcan

                                                        @can('setup.users.destroy')
                                                            <!-- Button Delete -->
                                                            <button type="button" class="btn btn-link text-danger p-2 mb-0" 
                                                                data-bs-toggle="modal" data-bs-target="#deleteUserModal-{{ $user->id }}" 
                                                                title="Hapus User">
                                                                <i class="material-icons text-lg">delete</i>
                                                            </button>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-secondary">
                                                    <i class="material-icons align-middle text-sm me-1">info</i> Belum ada data pengguna yang terdaftar.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="px-4 py-3 d-flex flex-column flex-md-row justify-content-between align-items-center border-top">
                                <p class="text-xs text-secondary mb-2 mb-md-0">
                                    Menampilkan <strong>{{ $users->firstItem() ?? 0 }}</strong> - <strong>{{ $users->lastItem() ?? 0 }}</strong> dari <strong>{{ $users->total() }}</strong> pengguna
                                </p>
                                <div>
                                    {{ $users->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>

    <!-- Modals (Dipisah ke file masing-masing) -->
    @can('setup.users.store')
        @include('Setup.User.create')
    @endcan

    @can('setup.users.update')
        @include('Setup.User.edit')
        @include('Setup.User.approve')
        @include('Setup.User.reject')
    @endcan

    @can('setup.users.destroy')
        @include('Setup.User.delete')
    @endcan

</x-layout>