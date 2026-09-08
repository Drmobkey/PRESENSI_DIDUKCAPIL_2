@foreach ($logbooks as $logbook)
    <div class="modal fade" id="showLogbookModal-{{ $logbook->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal">Detail Logbook - <strong>{{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}</strong></h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="25%">Pegawai</th>
                            <td>: {{ $logbook->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: 
                                @if($logbook->status == 'approved')
                                    <span class="badge badge-sm bg-gradient-success">Disetujui</span>
                                @elseif($logbook->status == 'revision')
                                    <span class="badge badge-sm bg-gradient-danger">Revisi</span>
                                @else
                                    <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @if($logbook->status == 'revision' && $logbook->rejection_note)
                            <tr>
                                <th>Catatan Revisi</th>
                                <td class="text-danger">: {{ $logbook->rejection_note }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Deskripsi</th>
                            <td style="white-space: pre-wrap;">: {{ $logbook->description }}</td>
                        </tr>
                    </table>

                    @if(auth()->user()->can('view_all_data'))
                        <hr class="horizontal dark mt-4 mb-4">
                        <form action="{{ route('logbooks.updateStatus', $logbook->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group mb-3">
                                <label class="form-label text-sm font-weight-bold">Tindakan Admin <span class="text-danger">*</span></label>
                                <select name="status" class="form-select px-2 border" id="statusSelect-{{ $logbook->id }}" onchange="toggleRejectionNote('{{ $logbook->id }}')">
                                    <option value="approved" {{ $logbook->status == 'approved' ? 'selected' : '' }}>Setujui</option>
                                    <option value="revision" {{ $logbook->status == 'revision' ? 'selected' : '' }}>Minta Revisi</option>
                                </select>
                            </div>
                            
                            <div class="form-group mb-3" id="rejectionNoteGroup-{{ $logbook->id }}" style="display: {{ $logbook->status == 'revision' ? 'block' : 'none' }};">
                                <label class="form-label text-sm font-weight-bold">Catatan Revisi (Opsional)</label>
                                <textarea name="rejection_note" class="form-control border px-2" rows="3">{{ $logbook->rejection_note }}</textarea>
                            </div>
                            
                            <button type="submit" class="btn bg-gradient-primary w-100">Update Status Logbook</button>
                        </form>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    function toggleRejectionNote(id) {
        var select = document.getElementById('statusSelect-' + id);
        var group = document.getElementById('rejectionNoteGroup-' + id);
        if (select.value === 'revision') {
            group.style.display = 'block';
        } else {
            group.style.display = 'none';
        }
    }
</script>
