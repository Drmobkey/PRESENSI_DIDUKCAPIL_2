<!-- Modal Delete TPDK -->
@foreach ($tpdks as $tpdk)
    <div class="modal fade" id="deleteTpdkModal-{{ $tpdk->id }}" tabindex="-1"
        aria-labelledby="deleteTpdkModalLabel-{{ $tpdk->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal text-danger" id="deleteTpdkModalLabel-{{ $tpdk->id }}">
                        <i class="material-icons align-middle me-1">warning</i> Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tpdks.destroy', $tpdk->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body text-center py-4">
                        <p class="mb-0">Apakah Anda yakin ingin menghapus data TPDK:</p>
                        <h5 class="font-weight-bold">{{ $tpdk->name }}?</h5>
                        <p class="text-xs text-danger mt-2">Data tidak bisa dihapus jika masih digunakan oleh Pegawai atau
                            Histori Presensi.</p>
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