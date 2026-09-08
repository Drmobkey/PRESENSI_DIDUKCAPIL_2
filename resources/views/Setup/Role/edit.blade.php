<!-- Modal Edit Role -->
@foreach ($roles as $role)
    <div class="modal fade" id="editRoleModal-{{ $role->id }}" tabindex="-1"
        aria-labelledby="editRoleModalLabel-{{ $role->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="editRoleModalLabel-{{ $role->id }}">
                        <i class="material-icons align-middle me-1">edit</i> Edit Role: <strong>{{ $role->name }}</strong>
                    </h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('setup.roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-sm">Nama Role <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control border border-2 p-2" required
                                value="{{ old('name', $role->name) }}">
                        </div>
                    </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label font-weight-bold text-sm mb-0">Pilih Permission (Hak Akses)</label>
                                <div class="form-check p-0 m-0">
                                    <input class="form-check-input ms-0 me-2 border border-dark" type="checkbox" id="checkAllEdit{{ $role->id }}">
                                    <label class="form-check-label text-sm mb-0 cursor-pointer font-weight-bold text-primary" for="checkAllEdit{{ $role->id }}">Pilih Semua</label>
                                </div>
                            </div>
                            
                            <div class="accordion" id="accordionEditPermissions{{ $role->id }}">
                                @foreach ($permissions as $group => $perms)
                                    <div class="accordion-item mb-2 border border-gray-200 border-radius-md">
                                        <h2 class="accordion-header" id="headingEdit{{ $role->id }}{{ $group }}">
                                            <button class="accordion-button collapsed py-2 px-3 bg-light font-weight-bold text-capitalize text-dark d-flex justify-content-between align-items-center w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEdit{{ $role->id }}{{ $group }}" aria-expanded="false" aria-controls="collapseEdit{{ $role->id }}{{ $group }}">
                                                <span class="d-flex align-items-center"><i class="material-icons opacity-10 me-2 text-warning">folder</i> {{ Str::title(str_replace('_', ' ', $group)) }}</span>
                                                <i class="material-icons text-sm accordion-icon">expand_more</i>
                                            </button>
                                        </h2>
                                        <div id="collapseEdit{{ $role->id }}{{ $group }}" class="accordion-collapse collapse" aria-labelledby="headingEdit{{ $role->id }}{{ $group }}">
                                            <div class="accordion-body p-3">
                                                <div class="form-check p-0 mb-3 border-bottom pb-2">
                                                    <input class="form-check-input ms-0 me-2 border border-dark check-group-edit-{{ $role->id }}" type="checkbox" id="checkGroupEdit{{ $role->id }}{{ $group }}" data-group="{{ $group }}" data-role="{{ $role->id }}">
                                                    <label class="form-check-label text-sm mb-0 cursor-pointer font-weight-bold" for="checkGroupEdit{{ $role->id }}{{ $group }}">Pilih Semua {{ Str::title(str_replace('_', ' ', $group)) }}</label>
                                                </div>
                                                <div class="row">
                                                    @foreach ($perms as $permission)
                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-check p-0">
                                                                <input class="form-check-input ms-0 me-2 border border-dark perm-edit-checkbox-{{ $role->id }} perm-edit-group-{{ $role->id }}-{{ $group }}" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="edit-perm-{{ $role->id }}-{{ $permission->id }}" 
                                                                {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                                                                <label class="form-check-label text-sm mb-0 cursor-pointer" for="edit-perm-{{ $role->id }}-{{ $permission->id }}">{{ $permission->name }}</label>
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
                        <button type="submit" class="btn bg-gradient-primary mb-0">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Karena ada multiple modal edit (di-looping), kita attach listener pake event delegation atau loop 
        @foreach ($roles as $role)
            (function(roleId) {
                const checkAllEdit = document.getElementById('checkAllEdit' + roleId);
                const checkGroupEditList = document.querySelectorAll('.check-group-edit-' + roleId);
                const permEditCheckboxes = document.querySelectorAll('.perm-edit-checkbox-' + roleId);

                // Initial state update based on pre-checked items
                updateMasterCheckAllEdit();
                checkGroupEditList.forEach(groupCb => {
                    const groupName = groupCb.getAttribute('data-group');
                    const groupCheckboxes = document.querySelectorAll('.perm-edit-group-' + roleId + '-' + groupName);
                    if (groupCheckboxes.length > 0) {
                        groupCb.checked = Array.from(groupCheckboxes).every(c => c.checked);
                    }
                });

                if (checkAllEdit) {
                    checkAllEdit.addEventListener('change', function () {
                        const isChecked = this.checked;
                        permEditCheckboxes.forEach(cb => cb.checked = isChecked);
                        checkGroupEditList.forEach(cb => cb.checked = isChecked);
                    });
                }

                checkGroupEditList.forEach(groupCb => {
                    groupCb.addEventListener('change', function () {
                        const groupName = this.getAttribute('data-group');
                        const isChecked = this.checked;
                        const groupCheckboxes = document.querySelectorAll('.perm-edit-group-' + roleId + '-' + groupName);
                        groupCheckboxes.forEach(cb => cb.checked = isChecked);
                        updateMasterCheckAllEdit();
                    });
                });

                permEditCheckboxes.forEach(cb => {
                    cb.addEventListener('change', function () {
                        const groupName = Array.from(this.classList)
                            .find(cls => cls.startsWith('perm-edit-group-' + roleId + '-'))
                            .replace('perm-edit-group-' + roleId + '-', '');
                        
                        const groupCheckboxes = document.querySelectorAll('.perm-edit-group-' + roleId + '-' + groupName);
                        const groupCb = document.getElementById('checkGroupEdit' + roleId + groupName);
                        
                        const allGroupChecked = Array.from(groupCheckboxes).every(c => c.checked);
                        if(groupCb) groupCb.checked = allGroupChecked;

                        updateMasterCheckAllEdit();
                    });
                });

                function updateMasterCheckAllEdit() {
                    if(checkAllEdit && permEditCheckboxes.length > 0) {
                        checkAllEdit.checked = Array.from(permEditCheckboxes).every(cb => cb.checked);
                    }
                }
            })('{{ $role->id }}');
        @endforeach
    });
</script>