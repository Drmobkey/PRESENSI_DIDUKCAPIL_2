<!-- Modal Approve Pengguna -->
@foreach ($users as $user)
<div class="modal fade" id="approveUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="approveUserModalLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal text-success" id="approveUserModalLabel-{{ $user->id }}">
                    <i class="material-icons align-middle me-1">verified_user</i> Persetujuan Pengguna
                </h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('setup.users.approve', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="alert alert-info text-white text-xs mb-3" role="alert">
                        Menyetujui pendaftaran akun akan mengaktifkan akses sistem bagi pengguna ini.
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Nama Pengguna</label>
                        <p class="text-sm font-weight-bold mb-0">{{ $user->name }}</p>
                        <span class="text-xs text-secondary">{{ $user->email }}</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Pilih TPDK Utama <span class="text-danger">*</span></label>
                        <select name="tpdk_id" class="form-select border border-2 p-2" required>
                            <option value="" disabled {{ !$user->tpdk_id ? 'selected' : '' }}>-- Pilih Lokasi TPDK --</option>
                            @foreach ($tpdks as $tpdk)
                                <option value="{{ $tpdk->id }}" {{ $user->tpdk_id == $tpdk->id ? 'selected' : '' }}>
                                    {{ $tpdk->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-xs text-muted">TPDK diperlukan sebagai lokasi penempatan presensi pengguna.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-success mb-0">Setujui Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
