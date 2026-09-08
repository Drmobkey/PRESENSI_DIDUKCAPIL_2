<div class="modal fade" id="createLogbookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Isi Logbook Hari Ini</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('logbooks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="input-group input-group-outline mb-3 is-filled">
                        <label class="form-label">Deskripsi Pekerjaan</label>
                        <textarea name="description" class="form-control" rows="5" required minlength="10"
                            placeholder="Jelaskan pekerjaan Anda hari ini..."></textarea>
                    </div>
                    <p class="text-xs text-muted mb-0">Jika Anda mengisi sekarang, Anda tidak perlu mengisinya lagi saat
                        Check-out sore nanti.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary">Simpan Logbook</button>
                </div>
            </form>
        </div>
    </div>
</div>