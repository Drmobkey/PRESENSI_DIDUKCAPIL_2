<!-- Modal Show Role -->
@foreach ($roles as $role)
    <div class="modal fade" id="showRoleModal-{{ $role->id }}" tabindex="-1"
        aria-labelledby="showRoleModalLabel-{{ $role->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title font-weight-normal text-white" id="showRoleModalLabel-{{ $role->id }}">
                        <i class="material-icons align-middle me-1">visibility</i> Detail Role:
                        <strong>{{ $role->name }}</strong>
                    </h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <ul class="list-group mb-4">
                        <li class="list-group-item border-0 d-flex p-4 bg-gray-100 border-radius-lg">
                            <div class="d-flex flex-column w-100">
                                <h5 class="mb-3 text-dark font-weight-bold">{{ $role->name }}</h5>
                                <span class="mb-2 text-xs">Guard Name: <span
                                        class="text-dark font-weight-bold ms-sm-2">{{ $role->guard_name }}</span></span>
                                <span class="mb-2 text-xs">Total Pengguna: <span
                                        class="text-dark font-weight-bold ms-sm-2">{{ $role->users()->count() ?? 0 }}
                                        Pengguna</span></span>
                                <span class="mb-2 text-xs">Total Permission: <span
                                        class="text-dark font-weight-bold ms-sm-2">{{ $role->permissions->count() }} Hak
                                        Akses</span></span>
                            </div>
                        </li>
                    </ul>

                    <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Daftar Hak Akses (Permissions)</h6>
                    <div class="row">
                        @if($role->permissions->isEmpty())
                            <div class="col-12">
                                <p class="text-sm text-secondary font-weight-bold italic">Role ini belum memiliki hak akses
                                    apapun.</p>
                            </div>
                        @else
                            <div class="accordion" id="accordionShowPermissions{{ $role->id }}">
                                @foreach ($permissions as $group => $perms)
                                    @php
                                        $rolePermsInGroup = $perms->filter(function ($p) use ($role) {
                                            return $role->permissions->contains('name', $p->name);
                                        });
                                    @endphp

                                    @if($rolePermsInGroup->isNotEmpty())
                                        <div class="accordion-item mb-2 border border-gray-200 border-radius-md shadow-sm">
                                            <h2 class="accordion-header" id="headingShow{{ $role->id }}{{ $group }}">
                                                <button
                                                    class="accordion-button collapsed py-2 px-3 bg-light font-weight-bold text-capitalize text-dark d-flex justify-content-between align-items-center w-100"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseShow{{ $role->id }}{{ $group }}" aria-expanded="false"
                                                    aria-controls="collapseShow{{ $role->id }}{{ $group }}">
                                                    <span class="text-sm d-flex align-items-center"><i class="material-icons opacity-10 me-2 text-warning">folder</i> {{ Str::title(str_replace('_', ' ', $group)) }}</span>
                                                    <span
                                                        class="badge bg-gradient-primary ms-auto me-2">{{ $rolePermsInGroup->count() }}
                                                        Hak Akses</span>
                                                    <i class="material-icons text-sm accordion-icon">expand_more</i>
                                                </button>
                                            </h2>
                                            <div id="collapseShow{{ $role->id }}{{ $group }}" class="accordion-collapse collapse"
                                                aria-labelledby="headingShow{{ $role->id }}{{ $group }}">
                                                <div class="accordion-body p-3 bg-white">
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach ($rolePermsInGroup as $permission)
                                                            <span class="badge badge-sm border border-success text-success bg-transparent">
                                                                <i class="material-icons text-xxs align-middle me-1">check_circle</i>
                                                                {{ $permission->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach