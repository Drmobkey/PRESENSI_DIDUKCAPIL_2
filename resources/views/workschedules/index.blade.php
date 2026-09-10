<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="workschedules"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Jadwal Kerja"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3 mb-0">Daftar Jadwal Kerja</h6>
                                @can('work_schedules.store')
                                    <button class="btn btn-dark btn-sm mb-0 me-3" data-bs-toggle="modal"
                                        data-bs-target="#createWorkScheduleModal">
                                        <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Tambah Jadwal
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
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Hari</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Jam Mulai</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Jam Selesai</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($schedules as $schedule)
                                            <tr>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="text-dark font-weight-bold">{{ $days[$schedule->day_of_week] ?? '-' }}</span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="text-secondary">{{ $schedule->start_time ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') : 'Libur' }}</span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="text-secondary">{{ $schedule->end_time ? \Carbon\Carbon::parse($schedule->end_time)->format('H:i') : 'Libur' }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @can('work_schedules.update')
                                                        <button type="button" class="btn btn-link text-dark p-2 mb-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editWorkScheduleModal-{{ $schedule->id }}"
                                                            title="Edit">
                                                            <i class="material-icons text-lg">edit</i>
                                                        </button>
                                                    @endcan
                                                    @can('work_schedules.destroy')
                                                        <button type="button" class="btn btn-link text-danger p-2 mb-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteWorkScheduleModal-{{ $schedule->id }}"
                                                            title="Hapus">
                                                            <i class="material-icons text-lg">delete</i>
                                                        </button>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-secondary py-4">
                                                    Belum ada jadwal kerja yang diatur.
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

    <!-- Includes Modals -->
    @include('workschedules.create')
    @include('workschedules.edit')
    @include('workschedules.delete')

</x-layout>