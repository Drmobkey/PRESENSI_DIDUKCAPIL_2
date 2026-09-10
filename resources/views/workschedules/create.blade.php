<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="createWorkScheduleModal" tabindex="-1" aria-labelledby="createWorkScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createWorkScheduleModalLabel">Tambah Jadwal Kerja</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('workschedules.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="day_of_week" class="form-label font-weight-bold">Hari</label>
                        <select name="day_of_week" id="day_of_week" class="form-select border px-2" required>
                            <option value="" disabled selected>-- Pilih Hari --</option>
                            @foreach($days as $key => $day)
                                <option value="{{ $key }}">{{ $day }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block mt-1">Pastikan hari yang dipilih belum memiliki jadwal.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="start_time" class="form-label font-weight-bold">Jam Mulai</label>
                            <input type="time" name="start_time" id="start_time" class="form-control border px-2">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="end_time" class="form-label font-weight-bold">Jam Selesai</label>
                            <input type="time" name="end_time" id="end_time" class="form-control border px-2">
                        </div>
                    </div>
                    <small class="text-muted">Biarkan jam mulai & jam selesai kosong jika hari tersebut dihitung libur.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary mb-0">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
