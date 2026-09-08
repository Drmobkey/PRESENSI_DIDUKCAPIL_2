@foreach ($logbooks as $logbook)
    <div class="modal fade" id="editLogbookModal-{{ $logbook->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Logbook</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('logbooks.update', $logbook->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        @if($logbook->status == 'revision')
                            <div class="alert alert-danger text-white mb-3" role="alert">
                                <strong>Logbook ini membutuhkan revisi!</strong><br>
                                Catatan Admin: {{ $logbook->rejection_note ?? 'Tidak ada catatan khusus.' }}
                            </div>
                        @endif

                        <div class="input-group input-group-outline mb-3 is-filled">
                            <label class="form-label">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="5" required
                                minlength="10">{{ $logbook->description }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-gradient-info">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach