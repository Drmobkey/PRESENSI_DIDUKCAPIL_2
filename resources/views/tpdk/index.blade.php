<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <!-- Memanggil sidebar dengan activePage tpdk-management agar tersorot -->
    <x-navbars.sidebar activePage="tpdk-management"></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Master Data TPDK"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <!-- Flash Message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible text-white fade show mb-4" role="alert">
                    <span class="text-sm"><i class="material-icons align-middle text-sm me-1">check_circle</i>
                        {{ session('success') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible text-white fade show mb-4" role="alert">
                    <span class="text-sm"><i class="material-icons align-middle text-sm me-1">error</i>
                        {{ session('error') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3 mb-0"><strong>Daftar TPDK (Titik
                                        Cabang)</strong></h6>
                                <!-- Tombol Tambah memanggil Modal Create -->
                                @can('tpdks.store')
                                    <button type="button" class="btn btn-success btn-sm mb-0 me-3 shadow-sm"
                                        data-bs-toggle="modal" data-bs-target="#createTpdkModal">
                                        <i class="material-icons text-sm">add</i> Tambah TPDK
                                    </button>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                NO</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                NAMA TPDK</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                ALAMAT</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                KOORDINAT</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                RADIUS (M)</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($tpdks as $tpdk)
                                            <tr>
                                                <td class="align-middle text-center"><span
                                                        class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0 px-3">{{ $tpdk->name }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs mb-0 px-3">{{ $tpdk->alamat ?? '-' }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-xs font-weight-bold text-dark">Lat:
                                                        {{ $tpdk->latitude }}</span><br>
                                                    <span class="text-xs font-weight-bold text-dark">Long:
                                                        {{ $tpdk->longitude }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="badge badge-sm bg-gradient-info">{{ $tpdk->radius }}
                                                        Meter</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <!-- Tombol Detail memanggil Modal Show sesuai ID -->
                                                    <button type="button" class="btn btn-link text-info p-2 mb-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#showTpdkModal-{{ $tpdk->id }}" title="Detail TPDK">
                                                        <i class="material-icons text-lg">visibility</i>
                                                    </button>
                                                    <!-- Tombol Edit memanggil Modal Edit sesuai ID -->
                                                    @can('tpdks.update')
                                                        <button type="button" class="btn btn-link text-dark p-2 mb-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editTpdkModal-{{ $tpdk->id }}" title="Edit TPDK">
                                                            <i class="material-icons text-lg">edit</i>
                                                        </button>
                                                    @endcan
                                                    <!-- Tombol Hapus memanggil Modal Delete sesuai ID -->
                                                    @can('tpdks.destroy')
                                                        <button type="button" class="btn btn-link text-danger p-2 mb-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteTpdkModal-{{ $tpdk->id }}"
                                                            title="Hapus TPDK">
                                                            <i class="material-icons text-lg">delete</i>
                                                        </button>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-secondary">
                                                    <i class="material-icons align-middle text-sm me-1">info</i> Belum ada
                                                    data TPDK.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Memisahkan file modal dengan include -->

    <!-- TAMBAHKAN INI: Library Pencarian (Geocoder) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script
    
    @include('tpdk.create')
    @include('tpdk.edit')
    @include('tpdk.delete')
    @include('tpdk.show')
    @include('tpdk.script-maps')

</x-layout>