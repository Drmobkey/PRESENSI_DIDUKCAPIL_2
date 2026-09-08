<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="createUserModalLabel">
                    <i class="material-icons align-middle me-1">person_add</i> Tambah Pengguna Baru
                </h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('setup.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control border border-2 p-2" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control border border-2 p-2" placeholder="contoh@domain.com" required value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control border border-2 p-2" placeholder="Minimal 8 karakter" required minlength="8">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Role Pengguna <span class="text-danger">*</span></label>
                        <select name="role" class="form-select border border-2 p-2" required>
                            <option value="" disabled selected>-- Pilih Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
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
                                <option value="{{ $tpdk->id }}" {{ old('tpdk_id') == $tpdk->id ? 'selected' : '' }}>
                                    {{ $tpdk->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-xs text-muted">Dapat ditentukan nanti saat akun disetujui (approve).</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Status Akun <span class="text-danger">*</span></label>
                        <select name="status" class="form-select border border-2 p-2" required>
                            <option value="approved" {{ old('status', 'approved') == 'approved' ? 'selected' : '' }}>Approved (Aktif)</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu Persetujuan)</option>
                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary mb-0">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
