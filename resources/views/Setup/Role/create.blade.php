<!-- Modal Tambah Role -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="createRoleModalLabel">
                    <i class="material-icons align-middle me-1">security</i> Tambah Role Baru
                </h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('setup.roles.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Nama Role <span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control border border-2 p-2"
                            placeholder="Masukkan nama role" required value="{{ old('name') }}">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label font-weight-bold text-sm mb-0">Pilih Permission (Hak Akses)</label>
                        <div class="form-check p-0 m-0">
                            <input class="form-check-input ms-0 me-2 border border-dark" type="checkbox"
                                id="checkAllCreate">
                            <label class="form-check-label text-sm mb-0 cursor-pointer font-weight-bold text-primary"
                                for="checkAllCreate">Pilih Semua</label>
                        </div>
                    </div>

                    <div class="accordion" id="accordionCreatePermissions">
                        @foreach ($permissions as $group => $perms)
                            <div class="accordion-item mb-2 border border-gray-200 border-radius-md">
                                <h2 class="accordion-header" id="headingCreate{{ $group }}">
                                    <button
                                        class="accordion-button collapsed py-2 px-3 bg-light font-weight-bold text-capitalize text-dark d-flex justify-content-between align-items-center w-100"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseCreate{{ $group }}"
                                        aria-expanded="false" aria-controls="collapseCreate{{ $group }}">
                                        <span class="d-flex align-items-center"><i class="material-icons opacity-10 me-2 text-warning">folder</i> {{ Str::title(str_replace('_', ' ', $group)) }}</span>
                                        <i class="material-icons text-sm accordion-icon">expand_more</i>
                                    </button>
                                </h2>
                                <div id="collapseCreate{{ $group }}" class="accordion-collapse collapse"
                                    aria-labelledby="headingCreate{{ $group }}">
                                    <div class="accordion-body p-3">
                                        <div class="form-check p-0 mb-3 border-bottom pb-2">
                                            <input class="form-check-input ms-0 me-2 border border-dark check-group-create"
                                                type="checkbox" id="checkGroupCreate{{ $group }}" data-group="{{ $group }}">
                                            <label class="form-check-label text-sm mb-0 cursor-pointer font-weight-bold"
                                                for="checkGroupCreate{{ $group }}"><i class="material-icons text-sm align-middle me-1">folder</i> Pilih Semua {{ Str::title(str_replace('_', ' ', $group)) }}</label>
                                        </div>
                                        <div class="row">
                                            @foreach ($perms as $permission)
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-check p-0">
                                                        <input
                                                            class="form-check-input ms-0 me-2 border border-dark perm-create-checkbox perm-create-group-{{ $group }}"
                                                            type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                            id="create-perm-{{ $permission->id }}">
                                                        <label class="form-check-label text-sm mb-0 cursor-pointer"
                                                            for="create-perm-{{ $permission->id }}">{{ $permission->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary mb-0">Simpan Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkAllCreate = document.getElementById('checkAllCreate');
        const checkGroupCreateList = document.querySelectorAll('.check-group-create');
        const permCreateCheckboxes = document.querySelectorAll('.perm-create-checkbox');

        // Check All Master
        if (checkAllCreate) {
            checkAllCreate.addEventListener('change', function () {
                const isChecked = this.checked;
                permCreateCheckboxes.forEach(cb => cb.checked = isChecked);
                checkGroupCreateList.forEach(cb => cb.checked = isChecked);
            });
        }

        // Check All Per Group
        checkGroupCreateList.forEach(groupCb => {
            groupCb.addEventListener('change', function () {
                const groupName = this.getAttribute('data-group');
                const isChecked = this.checked;
                const groupCheckboxes = document.querySelectorAll('.perm-create-group-' + groupName);
                groupCheckboxes.forEach(cb => cb.checked = isChecked);
                updateMasterCheckAllCreate();
            });
        });

        // Individual Checkbox changes -> update Group and Master
        permCreateCheckboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const groupName = Array.from(this.classList)
                    .find(cls => cls.startsWith('perm-create-group-'))
                    .replace('perm-create-group-', '');

                const groupCheckboxes = document.querySelectorAll('.perm-create-group-' + groupName);
                const groupCb = document.getElementById('checkGroupCreate' + groupName);

                const allGroupChecked = Array.from(groupCheckboxes).every(c => c.checked);
                if (groupCb) groupCb.checked = allGroupChecked;

                updateMasterCheckAllCreate();
            });
        });

        function updateMasterCheckAllCreate() {
            if (checkAllCreate && permCreateCheckboxes.length > 0) {
                checkAllCreate.checked = Array.from(permCreateCheckboxes).every(cb => cb.checked);
            }
        }
    });
</script>