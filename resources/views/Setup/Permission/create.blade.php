<!-- Modal Tambah Permission -->
<div class="modal fade" id="createPermissionModal" tabindex="-1" aria-labelledby="createPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="createPermissionModalLabel">
                    <i class="material-icons align-middle me-1">add_box</i> Tambah Permission Baru
                </h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('setup.permissions.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Nama Permission <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control border border-2 p-2" placeholder="Contoh: module.action" required value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Guard Name</label>
                        <input type="text" name="guard_name" class="form-control border border-2 p-2" placeholder="web (Default)" value="{{ old('guard_name', 'web') }}">
                        <small class="text-muted text-xs">Biarkan 'web' kecuali Anda menggunakan guard khusus.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary mb-0">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
