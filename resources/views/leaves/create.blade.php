<div class="modal fade" id="createLeaveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajukan Izin Absen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('leaves.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="input-group input-group-static mb-4">
                        <label for="type" class="ms-0">Jenis Izin</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="sakit">Sakit</option>
                            <option value="cuti">Cuti</option>
                            <option value="dinas_luar">Dinas Luar</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label>Tanggal Selesai</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="input-group input-group-outline mb-4 is-filled">
                        <label class="form-label">Alasan Detail</label>
                        <textarea name="reason" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="input-group input-group-static mb-3">
                        <label>Lampiran (Opsional, max 2MB: jpg/png/pdf)</label>
                        <input type="file" name="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>