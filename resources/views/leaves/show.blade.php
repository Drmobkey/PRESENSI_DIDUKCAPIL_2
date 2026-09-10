@foreach ($leaves as $leave)
    <div class="modal fade" id="showLeaveModal-{{ $leave->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal">Detail Izin -
                        <strong>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</strong>
                    </h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th width="30%">Pegawai</th>
                            <td>: {{ $leave->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Izin</th>
                            <td class="text-capitalize">: {{ str_replace('_', ' ', $leave->type) }}</td>
                        </tr>
                        <tr>
                            <th>Rentang Waktu</th>
                            <td>: {{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }} s/d
                                {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>:
                                @if($leave->status == 'approved')
                                    <span class="badge badge-sm bg-gradient-success">Disetujui</span>
                                @elseif($leave->status == 'rejected')
                                    <span class="badge badge-sm bg-gradient-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @if($leave->attachment)
                            <tr>
                                <th>Lampiran</th>
                                <td>: <a href="#" data-bs-toggle="modal" data-bs-target="#attachmentModal-{{ $leave->id }}"
                                        class="text-info text-sm text-decoration-underline">Lihat Lampiran</a></td>
                            </tr>
                        @endif
                        @if($leave->status == 'rejected' && $leave->rejection_note)
                            <tr>
                                <th>Catatan Penolakan</th>
                                <td class="text-danger">: {{ $leave->rejection_note }}</td>
                            </tr>
                        @endif
                    </table>

                    <div class="mt-3">
                        <label class="form-label text-sm font-weight-bold">Alasan / Keterangan:</label>
                        <div class="p-3 bg-gray-100 rounded text-sm text-dark"
                            style="white-space: pre-wrap; min-height: 80px;">{{ $leave->reason }}</div>
                    </div>

                    @if($leave->status == 'pending' && (auth()->user()->can('leaves.manage_all') || auth()->user()->can('leaves.manage_branch')))
                        <hr class="horizontal dark mt-4 mb-4">
                        <form action="{{ route('leaves.updateStatus', $leave->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label class="form-label text-sm font-weight-bold">Tindakan Admin <span
                                        class="text-danger">*</span></label>
                                <select name="status" class="form-select px-2 border" id="leaveStatusSelect-{{ $leave->id }}"
                                    onchange="toggleLeaveRejectionNote('{{ $leave->id }}')" required>
                                    <option value="" disabled selected>-- Pilih Tindakan --</option>
                                    <option value="approved">Setujui</option>
                                    <option value="rejected">Tolak</option>
                                </select>
                            </div>

                            <div class="form-group mb-3" id="leaveRejectionNoteGroup-{{ $leave->id }}" style="display: none;">
                                <label class="form-label text-sm font-weight-bold">Catatan Penolakan (Wajib jika
                                    menolak)</label>
                                <textarea name="rejection_note" class="form-control border px-2" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn bg-gradient-primary w-100">Simpan Tindakan</button>
                        </form>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @if($leave->attachment)
    <!-- Attachment Modal -->
    <div class="modal fade" id="attachmentModal-{{ $leave->id }}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal">Lampiran Izin</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center p-0">
                    @php
                        $ext = pathinfo($leave->attachment, PATHINFO_EXTENSION);
                    @endphp
                    @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{ asset('storage/' . $leave->attachment) }}" class="img-fluid rounded" alt="Lampiran" style="max-height: 80vh; object-fit: contain;">
                    @elseif(strtolower($ext) == 'pdf')
                        <iframe src="{{ asset('storage/' . $leave->attachment) }}" width="100%" height="600px" style="border: none;"></iframe>
                    @else
                        <div class="p-5">
                            <p>File tidak dapat dipratinjau di browser.</p>
                            <a href="{{ asset('storage/' . $leave->attachment) }}" target="_blank" class="btn btn-primary">Unduh / Buka File</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

<script>
    function toggleLeaveRejectionNote(id) {
        var select = document.getElementById('leaveStatusSelect-' + id);
        var group = document.getElementById('leaveRejectionNoteGroup-' + id);
        if (select.value === 'rejected') {
            group.style.display = 'block';
            group.querySelector('textarea').setAttribute('required', 'required');
        } else {
            group.style.display = 'none';
            group.querySelector('textarea').removeAttribute('required');
        }
    }
</script>