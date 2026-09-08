<!-- Modal Hapus Pengguna -->
@foreach ($users as $user)
<div class="modal fade" id="deleteUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="deleteUserModalLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal text-danger" id="deleteUserModalLabel-{{ $user->id }}">
                    <i class="material-icons align-middle me-1">warning</i> Konfirmasi Hapus Pengguna
                </h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('setup.users.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center py-4">
                    <div class="mb-3 text-danger">
                        <i class="material-icons" style="font-size: 56px;">delete_forever</i>
                    </div>
                    <p class="text-sm mb-1">Apakah Anda yakin ingin menghapus pengguna berikut?</p>
                    <h6 class="font-weight-bold mb-1">{{ $user->name }}</h6>
                    <p class="text-xs text-secondary mb-0">{{ $user->email }} &bull; Role: {{ $user->roles->first()->name ?? 'User' }}</p>
                    <p class="text-xs text-danger mt-3 mb-0"><strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-danger mb-0">Ya, Hapus Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
