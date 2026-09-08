<!-- Modal Show Attendance -->
<div class="modal fade" id="showModal{{ $attendance->id }}" tabindex="-1" role="dialog"
    aria-labelledby="showModalLabel{{ $attendance->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info">
                <h5 class="modal-title text-white" id="showModalLabel{{ $attendance->id }}">Detail Presensi Pegawai</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Informasi Pegawai</h6>
                        <ul class="list-group">
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Nama:</strong> &nbsp; {{ $attendance->user->name ?? '-' }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Email:</strong> &nbsp; {{ $attendance->user->email ?? '-' }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Tanggal:</strong> &nbsp;
                                {{ \Carbon\Carbon::parse($attendance->date)->format('d F Y') }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Status:</strong> &nbsp;
                                @if ($attendance->status === 'hadir')
                                    <span class="badge badge-sm bg-gradient-success">Hadir</span>
                                @elseif ($attendance->status === 'alpa')
                                    <span class="badge badge-sm bg-gradient-danger">Alpa</span>
                                @else
                                    <span
                                        class="badge badge-sm bg-gradient-info text-uppercase">{{ $attendance->status }}</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Informasi Kehadiran</h6>
                        <ul class="list-group">
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Lokasi TPDK:</strong> &nbsp;
                                {{ $attendance->tpdk->name ?? 'Di Luar TPDK / Izin' }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Waktu Masuk:</strong> &nbsp;
                                {{ $attendance->time_in ?? '-' }}
                                @if($attendance->is_late)
                                    <span class="badge badge-sm bg-gradient-danger ms-2">Terlambat</span>
                                @endif
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Waktu Pulang:</strong> &nbsp;
                                {{ $attendance->time_out ?? '-' }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 text-center">
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Foto Bukti Masuk</h6>
                        @if($attendance->photo_in)
                            <img src="{{ asset('storage/' . $attendance->photo_in) }}"
                                class="img-fluid rounded border shadow-sm" alt="Foto Masuk"
                                style="max-height: 250px; object-fit: cover;">
                        @else
                            <div class="p-4 border rounded bg-light text-secondary">Tidak ada foto masuk</div>
                        @endif
                    </div>
                    <div class="col-md-6 text-center mt-4 mt-md-0">
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Foto Bukti Pulang</h6>
                        @if($attendance->photo_out)
                            <img src="{{ asset('storage/' . $attendance->photo_out) }}"
                                class="img-fluid rounded border shadow-sm" alt="Foto Pulang"
                                style="max-height: 250px; object-fit: cover;">
                        @else
                            <div class="p-4 border rounded bg-light text-secondary">Tidak ada foto pulang</div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Catatan Logbook Harian</h6>
                        <div class="p-3 border border-light rounded bg-gray-100">
                            @if($attendance->logbook)
                                <p class="text-sm mb-0 text-dark" style="white-space: pre-line;">
                                    {{ $attendance->logbook->description }}
                                </p>
                            @else
                                <p class="text-sm mb-0 text-secondary font-italic">Pegawai belum mengisi logbook untuk hari
                                    ini.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>