<!-- Modal Hapus Role -->
@foreach ($roles as $role)
    <div class="modal fade" id="deleteRoleModal-{{ $role->id }}" tabindex="-1"
        aria-labelledby="deleteRoleModalLabel-{{ $role->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal text-danger" id="deleteRoleModalLabel-{{ $role->id }}">
                        <i class="material-icons align-middle me-1">warning</i> Konfirmasi Hapus Role
                    </h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('setup.roles.destroy', $role->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body text-center py-4">
                        <div class="mb-3 text-danger">
                            <i class="material-icons" style="font-size: 56px;">delete_forever</i>
                        </div>
                        <p class="text-sm mb-1">Apakah Anda yakin ingin menghapus role berikut?</p>
                        <h6 class="font-weight-bold mb-1">{{ $role->name }}</h6>
                        <p class="text-xs text-danger mt-3 mb-0"><strong>Peringatan:</strong> Pengguna yang memiliki role
                            ini mungkin akan kehilangan hak aksesnya.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-gradient-danger mb-0">Ya, Hapus Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach