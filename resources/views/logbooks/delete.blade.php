@foreach ($logbooks as $logbook)
    <div class="modal fade" id="deleteLogbookModal-{{ $logbook->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal text-danger">
                        <i class="material-icons align-middle me-1">warning</i> Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('logbooks.destroy', $logbook->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body text-center py-4">
                        <p class="mb-0">Apakah Anda yakin ingin menghapus catatan logbook tanggal</p>
                        <h6 class="font-weight-bold">{{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}?</h6>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-gradient-danger mb-0">Ya, Hapus!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach