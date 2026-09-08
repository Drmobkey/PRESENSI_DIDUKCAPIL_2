@foreach ($leaves as $leave)
    <div class="modal fade" id="editLeaveModal-{{ $leave->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pengajuan Izin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('leaves.update', $leave->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="input-group input-group-static mb-4">
                            <label for="type-{{ $leave->id }}" class="ms-0">Jenis Izin</label>
                            <select name="type" id="type-{{ $leave->id }}" class="form-control" required>
                                <option value="sakit" {{ $leave->type === 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="cuti" {{ $leave->type === 'cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="dinas_luar" {{ $leave->type === 'dinas_luar' ? 'selected' : '' }}>Dinas Luar
                                </option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" name="start_date" class="form-control"
                                        value="{{ $leave->start_date }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label>Tanggal Selesai</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ $leave->end_date }}"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="input-group input-group-outline mb-4 is-filled">
                            <label class="form-label">Alasan Detail</label>
                            <textarea name="reason" class="form-control" rows="3" required>{{ $leave->reason }}</textarea>
                        </div>
                        <div class="input-group input-group-static mb-3">
                            <label>Lampiran Baru (Biarkan kosong jika tidak ingin mengubah)</label>
                            <input type="file" name="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-gradient-info">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach