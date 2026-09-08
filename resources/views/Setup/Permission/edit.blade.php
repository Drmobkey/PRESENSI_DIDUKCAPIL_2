<!-- Modal Edit Permission -->
@foreach ($permissions as $permission)
<div class="modal fade" id="editPermissionModal-{{ $permission->id }}" tabindex="-1" aria-labelledby="editPermissionModalLabel-{{ $permission->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="editPermissionModalLabel-{{ $permission->id }}">
                    <i class="material-icons align-middle me-1">edit</i> Edit Permission: <strong>{{ $permission->name }}</strong>
                </h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('setup.permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Nama Permission <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control border border-2 p-2" required value="{{ old('name', $permission->name) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Guard Name</label>
                        <input type="text" name="guard_name" class="form-control border border-2 p-2" value="{{ old('guard_name', $permission->guard_name) }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary mb-0">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
