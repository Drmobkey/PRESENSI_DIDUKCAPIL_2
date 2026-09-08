<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="logbooks"></x-navbars.sidebar>
    
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Jurnal Harian (Logbook)"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3 mb-0">Daftar Logbook</h6>
                                <button type="button" class="btn btn-success btn-sm mb-0 me-3" data-bs-toggle="modal" data-bs-target="#createLogbookModal">
                                    Isi Logbook Hari Ini
                                </button>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pegawai</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deskripsi</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logbooks as $logbook)
                                            <tr>
                                                <td><p class="text-sm font-weight-bold mb-0 px-3">{{ $logbook->user->name }}</p></td>
                                                <td><p class="text-sm mb-0 px-3">{{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}</p></td>
                                                <td>
                                                    <p class="text-sm mb-0 px-3 text-truncate" style="max-width: 200px;">
                                                        {{ $logbook->description }}
                                                    </p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if($logbook->status == 'approved')
                                                        <span class="badge badge-sm bg-gradient-success">Disetujui</span>
                                                    @elseif($logbook->status == 'revision')
                                                        <span class="badge badge-sm bg-gradient-danger">Revisi</span>
                                                    @else
                                                        <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    <!-- Tombol Detail memanggil Modal Show -->
                                                    <button type="button" class="btn btn-link text-info px-2 mb-0" data-bs-toggle="modal" data-bs-target="#showLogbookModal-{{ $logbook->id }}">Detail</button>

                                                    @if(auth()->user()->can('view_all_data'))
                                                        <!-- Admin: Hanya Detail, Persetujuan/Revisi dilakukan dari dalam Detail Modal -->
                                                    @else
                                                        <!-- Regular User: Bisa Edit jika belum disetujui (pending/revision) -->
                                                        @if(in_array($logbook->status, ['pending', 'revision']))
                                                            <button type="button" class="btn btn-link text-dark px-2 mb-0" data-bs-toggle="modal" data-bs-target="#editLogbookModal-{{ $logbook->id }}">Edit</button>
                                                        @endif
                                                        
                                                        <!-- Regular User: Bisa Hapus hanya jika pending -->
                                                        @if($logbook->status == 'pending')
                                                            <button type="button" class="btn btn-link text-danger px-2 mb-0" data-bs-toggle="modal" data-bs-target="#deleteLogbookModal-{{ $logbook->id }}">Hapus</button>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Include Modals -->
    @include('logbooks.create')
    @include('logbooks.edit')
    @include('logbooks.delete')
    @include('logbooks.show')
</x-layout>