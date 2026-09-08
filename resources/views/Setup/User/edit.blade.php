<!-- Modal Edit Pengguna -->
@foreach ($users as $user)
<div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="editUserModalLabel-{{ $user->id }}">
                    <i class="material-icons align-middle me-1">edit</i> Edit Pengguna: <strong>{{ $user->name }}</strong>
                </h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('setup.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control border border-2 p-2" required value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control border border-2 p-2" required value="{{ old('email', $user->email) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Password Baru</label>
                        <input type="password" name="password" class="form-control border border-2 p-2" placeholder="Kosongkan jika tidak ingin mengubah password" minlength="8">
                        <small class="text-xs text-muted">Biarkan kosong jika tidak ingin mengganti kata sandi.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Role Pengguna <span class="text-danger">*</span></label>
                        <select name="role" class="form-select border border-2 p-2" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">TPDK Utama</label>
                        <select name="tpdk_id" class="form-select border border-2 p-2">
                            <option value="">-- Pilih TPDK (Opsional) --</option>
                            @foreach ($tpdks as $tpdk)
                                <option value="{{ $tpdk->id }}" {{ $user->tpdk_id == $tpdk->id ? 'selected' : '' }}>
                                    {{ $tpdk->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Status Akun <span class="text-danger">*</span></label>
                        <select name="status" class="form-select border border-2 p-2" required>
                            <option value="approved" {{ $user->status === 'approved' ? 'selected' : '' }}>Approved (Aktif)</option>
                            <option value="pending" {{ $user->status === 'pending' ? 'selected' : '' }}>Pending (Menunggu Persetujuan)</option>
                            <option value="rejected" {{ $user->status === 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                        </select>
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
