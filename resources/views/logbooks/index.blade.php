<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="logbooks"></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Jurnal Harian (Logbook)"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3 mb-0">Daftar Logbook</h6>
                                <div class="me-3">
                                    <a href="{{ route('logbooks.export.excel', request()->all()) }}"
                                        class="btn btn-success btn-sm mb-0 shadow-sm me-2">
                                        <i class="material-icons text-sm align-middle">table_view</i> Excel
                                    </a>
                                    <a href="{{ route('logbooks.export.pdf', request()->all()) }}"
                                        class="btn btn-danger btn-sm mb-0 shadow-sm me-2">
                                        <i class="material-icons text-sm align-middle">picture_as_pdf</i> PDF
                                    </a>
                                    @can('logbooks.store')
                                        <button type="button" class="btn btn-white btn-sm mb-0" data-bs-toggle="modal"
                                            data-bs-target="#createLogbookModal">
                                            Isi Logbook Hari Ini
                                        </button>
                                    @endcan
                                </div>
                            </div>
                        </div>

                        <!-- Filter Form -->
                        <div class="card-body px-4 pb-3 mt-3 border-bottom">
                            <form action="{{ route('logbooks.index') }}" method="GET"
                                class="row gx-2 gy-3 align-items-center">
                                @if(auth()->user()->can('logbooks.manage_all'))
                                    <div class="col-md-3 col-sm-6">
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

                                <div class="col-md-3 col-sm-6">
                                    <select name="status"
                                        class="form-select px-3 border border-2 border-light rounded text-sm"
                                        aria-label="Pilih Status">
                                        <option value="">-- Semua Status --</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                            Disetujui
                                        </option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="revision" {{ request('status') == 'revision' ? 'selected' : '' }}>
                                            Revisi
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
                                    @if(request()->hasAny(['user_id', 'status', 'start_date', 'end_date']))
                                        <a href="{{ route('logbooks.index') }}"
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
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Pegawai</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Deskripsi</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logbooks as $logbook)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0 px-3">{{ $logbook->user->name }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm mb-0 px-3">
                                                        {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}
                                                    </p>
                                                </td>
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
                                                    @can('logbooks.show')
                                                        <button type="button" class="btn btn-link text-info p-2 mb-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#showLogbookModal-{{ $logbook->id }}"
                                                            title="Detail">
                                                            <i class="material-icons text-lg">visibility</i>
                                                        </button>
                                                    @endcan

                                                    @if(auth()->user()->can('logbooks.manage_all'))
                                                        <!-- Admin: Hanya Detail, Persetujuan/Revisi dilakukan dari dalam Detail Modal -->
                                                    @else
                                                        <!-- Regular User: Bisa Edit jika belum disetujui (pending/revision) -->
                                                        @if(in_array($logbook->status, ['pending', 'revision']))
                                                            @can('logbooks.update')
                                                                <button type="button" class="btn btn-link text-dark p-2 mb-0"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editLogbookModal-{{ $logbook->id }}" title="Edit">
                                                                    <i class="material-icons text-lg">edit</i>
                                                                </button>
                                                            @endcan
                                                        @endif

                                                        <!-- Regular User: Bisa Hapus hanya jika pending -->
                                                        @if($logbook->status == 'pending')
                                                            @can('logbooks.destroy')
                                                                <button type="button" class="btn btn-link text-danger p-2 mb-0"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteLogbookModal-{{ $logbook->id }}"
                                                                    title="Hapus">
                                                                    <i class="material-icons text-lg">delete</i>
                                                                </button>
                                                            @endcan
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div
                                class="px-4 py-3 d-flex flex-column flex-md-row justify-content-between align-items-center border-top">
                                <p class="text-xs text-secondary mb-2 mb-md-0">
                                    Menampilkan <strong>{{ $logbooks->firstItem() ?? 0 }}</strong> -
                                    <strong>{{ $logbooks->lastItem() ?? 0 }}</strong> dari
                                    <strong>{{ $logbooks->total() }}</strong> logbook
                                </p>
                                <div>
                                    {{ $logbooks->appends(request()->query())->links() }}
                                </div>
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