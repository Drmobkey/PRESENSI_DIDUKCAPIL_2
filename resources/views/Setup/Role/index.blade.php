<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <style>
        .accordion-button:not(.collapsed) .accordion-icon {
            transform: rotate(180deg);
        }

        .accordion-icon {
            transition: transform 0.2s ease-in-out;
        }

        .accordion-button::after {
            display: none !important;
            /* Hide default bootstrap arrow */
        }

        .accordion-item {
            border: 1px solid #e0e0e0;
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .accordion-button {
            border-radius: 0 !important;
        }
    </style>

    <x-navbars.sidebar activePage="role-management"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Role"></x-navbars.navs.auth>
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
                                <h6 class="text-white text-capitalize ps-3 mb-0"><strong>Tabel Role Management</strong>
                                </h6>
                                @can('setup.roles.store')
                                    <div class="pe-3">
                                        <button type="button" class="btn bg-gradient-dark btn-sm mb-0 shadow-sm"
                                            data-bs-toggle="modal" data-bs-target="#createRoleModal">
                                            <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Tambah Role
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
                                                NAMA ROLE
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                PERMISSIONS
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                GUARD NAME
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                style="width: 15%;">
                                                AKSI
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($roles as $index => $role)
                                            <tr>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="d-flex px-3 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm font-weight-bold">{{ $role->name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-wrap justify-content-center gap-1"
                                                        style="max-width: 250px;">
                                                        @if($role->permissions->count() > 3)
                                                            @foreach ($role->permissions->take(3) as $permission)
                                                                <span
                                                                    class="badge badge-sm border border-info text-info bg-transparent">
                                                                    {{ $permission->name }}
                                                                </span>
                                                            @endforeach
                                                            <span class="badge badge-sm bg-gradient-info text-white">
                                                                +{{ $role->permissions->count() - 3 }} Lainnya
                                                            </span>
                                                        @else
                                                            @forelse ($role->permissions as $permission)
                                                                <span
                                                                    class="badge badge-sm border border-info text-info bg-transparent">
                                                                    {{ $permission->name }}
                                                                </span>
                                                            @empty
                                                                <span class="text-xs text-secondary">Belum ada permission</span>
                                                            @endforelse
                                                        @endif
                                                    </div>
                                                </td>

                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm border border-dark text-dark font-weight-bold bg-transparent">
                                                        {{ $role->guard_name }}
                                                    </span>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                                        <button type="button" class="btn btn-link text-dark p-2 mb-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#showRoleModal-{{ $role->id }}"
                                                            title="Detail Role">
                                                            <i class="material-icons text-lg">visibility</i>
                                                        </button>
                                                        @can('setup.roles.update')
                                                            <!-- Button Edit -->
                                                            <button type="button" class="btn btn-link text-info p-2 mb-0"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editRoleModal-{{ $role->id }}"
                                                                title="Edit Role">
                                                                <i class="material-icons text-lg">edit</i>
                                                            </button>
                                                        @endcan

                                                        @can('setup.roles.destroy')
                                                            <!-- Button Delete -->
                                                            <button type="button" class="btn btn-link text-danger p-2 mb-0"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteRoleModal-{{ $role->id }}"
                                                                title="Hapus Role">
                                                                <i class="material-icons text-lg">delete</i>
                                                            </button>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-secondary">
                                                    <i class="material-icons align-middle text-sm me-1">info</i> Belum ada
                                                    data role yang terdaftar.
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
                                    Menampilkan <strong>{{ $roles->firstItem() ?? 0 }}</strong> -
                                    <strong>{{ $roles->lastItem() ?? 0 }}</strong> dari
                                    <strong>{{ $roles->total() }}</strong> role
                                </p>
                                <div>
                                    {{ $roles->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>

    <!-- Modals -->
    @can('setup.roles.store')
        @include('Setup.Role.create')
    @endcan

    @can('setup.roles.update')
        @include('Setup.Role.edit')
    @endcan

    @can('setup.roles.destroy')
        @include('Setup.Role.delete')
    @endcan

    @include('Setup.Role.show')

</x-layout>