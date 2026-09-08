<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="permission-management"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Permission Management"></x-navbars.navs.auth>
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

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible text-white fade show mb-4" role="alert">
                    <span class="text-sm font-weight-bold"><i class="material-icons align-middle text-sm me-1">warning</i>
                        Terdapat kesalahan pengisian data:</span>
                    <ul class="mb-0 text-sm ps-3 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
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
                                <h6 class="text-white text-capitalize ps-3 mb-0"><strong>Tabel Permission
                                        Management</strong></h6>
                                @can('setup.permissions.store')
                                    <div class="pe-3">
                                        <button type="button" class="btn bg-gradient-dark btn-sm mb-0 shadow-sm"
                                            data-bs-toggle="modal" data-bs-target="#createPermissionModal">
                                            <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Tambah Permission
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
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                style="width: 5%;">
                                                NO
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                NAMA PERMISSION
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                GUARD NAME
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                TANGGAL DIBUAT
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                style="width: 15%;">
                                                AKSI
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($permissions as $index => $permission)
                                            <tr>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ ($permissions->currentPage() - 1) * $permissions->perPage() + $loop->iteration }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="d-flex px-3 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm font-weight-bold">
                                                                {{ $permission->name }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm border border-dark text-dark font-weight-bold bg-transparent">
                                                        {{ $permission->guard_name }}
                                                    </span>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ $permission->created_at ? $permission->created_at->format('d/m/Y') : '-' }}
                                                    </span>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                                        @can('setup.permissions.update')
                                                            <button type="button" class="btn btn-link text-info p-2 mb-0"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editPermissionModal-{{ $permission->id }}"
                                                                title="Edit Permission">
                                                                <i class="material-icons text-lg">edit</i>
                                                            </button>
                                                        @endcan

                                                        @can('setup.permissions.destroy')
                                                            <button type="button" class="btn btn-link text-danger p-2 mb-0"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deletePermissionModal-{{ $permission->id }}"
                                                                title="Hapus Permission">
                                                                <i class="material-icons text-lg">delete</i>
                                                            </button>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-secondary">
                                                    <i class="material-icons align-middle text-sm me-1">info</i> Belum ada
                                                    data permission.
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
                                    Menampilkan <strong>{{ $permissions->firstItem() ?? 0 }}</strong> -
                                    <strong>{{ $permissions->lastItem() ?? 0 }}</strong> dari
                                    <strong>{{ $permissions->total() }}</strong> permission
                                </p>
                                <div>
                                    {{ $permissions->links() }}
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
    @can('setup.permissions.store')
        @include('Setup.Permission.create')
    @endcan

    @can('setup.permissions.update')
        @include('Setup.Permission.edit')
    @endcan

    @can('setup.permissions.destroy')
        @include('Setup.Permission.delete')
    @endcan

</x-layout>