<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="leaves"></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Pengajuan Izin"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3 mb-0">Daftar Pengajuan Izin</h6>
                                <button type="button" class="btn btn-success btn-sm mb-0 me-3" data-bs-toggle="modal"
                                    data-bs-target="#createLeaveModal">
                                    Ajukan Izin Baru
                                </button>
                            </div>
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
                                                Jenis & Tanggal</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Alasan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leaves as $leave)
                                            <tr>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0 px-3">{{ $leave->user->name }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0 px-3 text-capitalize">
                                                        {{ str_replace('_', ' ', $leave->type) }}
                                                    </p>
                                                    <p class="text-xs text-secondary mb-0 px-3">
                                                        {{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }} -
                                                        {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm mb-0 px-3 text-truncate" style="max-width: 150px;">
                                                        {{ $leave->reason }}
                                                    </p>
                                                    @if($leave->attachment)
                                                        <a href="{{ asset('storage/' . $leave->attachment) }}" target="_blank"
                                                            class="text-xs text-info px-3">Lihat Lampiran</a>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if($leave->status === 'pending')
                                                        <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                                    @elseif($leave->status === 'approved')
                                                        <span class="badge badge-sm bg-gradient-success">Disetujui</span>
                                                    @else
                                                        <span class="badge badge-sm bg-gradient-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    {{-- Sesuai aturan: User/Admin bisa edit jika status pending. Superadmin
                                                    (bypass_status) bebas[cite: 9] --}}
                                                    @if($leave->status === 'pending' || auth()->user()->can('leaves.bypass_status'))
                                                        <button type="button" class="btn btn-link text-dark px-2 mb-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editLeaveModal-{{ $leave->id }}">Edit</button>
                                                        <button type="button" class="btn btn-link text-danger px-2 mb-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteLeaveModal-{{ $leave->id }}">Hapus</button>
                                                        @if($leave->status === 'pending' && (auth()->user()->can('leaves.manage_all') || auth()->user()->can('leaves.manage_branch')))
                                                            <button type="button" class="btn btn-link text-success px-2 mb-0"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approveLeaveModal-{{ $leave->id }}">Setujui</button>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="px-4 mt-4">
                                {{ $leaves->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Include Modals -->
    @include('leaves.create')
    @include('leaves.edit')
    @include('leaves.delete')
    @include('leaves.show')
    @include('leaves.approve')
</x-layout>