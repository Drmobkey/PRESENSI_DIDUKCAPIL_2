<!-- Modal Reject Pengguna -->
@foreach ($users as $user)
<div class="modal fade" id="rejectUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="rejectUserModalLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal text-warning" id="rejectUserModalLabel-{{ $user->id }}">
                    <i class="material-icons align-middle me-1">cancel</i> Konfirmasi Tolak Pengguna
                </h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('setup.users.reject', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body text-center py-4">
                    <div class="mb-3 text-warning">
                        <i class="material-icons" style="font-size: 56px;">block</i>
                    </div>
                    <p class="text-sm mb-1">Apakah Anda yakin ingin menolak pendaftaran pengguna berikut?</p>
                    <h6 class="font-weight-bold mb-1">{{ $user->name }}</h6>
                    <p class="text-xs text-secondary mb-0">{{ $user->email }} &bull; Role: {{ $user->roles->first()->name ?? 'User' }}</p>
                    <p class="text-xs text-danger mt-3 mb-0">Akun dengan status <strong>Ditolak (Rejected)</strong> tidak dapat login atau mengakses sistem.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-warning mb-0 text-white">Ya, Tolak Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
