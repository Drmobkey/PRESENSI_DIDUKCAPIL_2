@foreach($schedules as $schedule)
    <!-- Modal Edit Jadwal -->
    <div class="modal fade" id="editWorkScheduleModal-{{ $schedule->id }}" tabindex="-1" aria-labelledby="editWorkScheduleModalLabel-{{ $schedule->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editWorkScheduleModalLabel-{{ $schedule->id }}">Edit Jadwal Kerja</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('workschedules.update', $schedule->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="day_of_week_{{ $schedule->id }}" class="form-label font-weight-bold">Hari</label>
                            <select name="day_of_week" id="day_of_week_{{ $schedule->id }}" class="form-select border px-2" required>
                                @foreach($days as $key => $day)
                                    <option value="{{ $key }}" {{ $schedule->day_of_week == $key ? 'selected' : '' }}>{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="start_time_{{ $schedule->id }}" class="form-label font-weight-bold">Jam Mulai</label>
                                <input type="time" name="start_time" id="start_time_{{ $schedule->id }}" class="form-control border px-2" value="{{ $schedule->start_time ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') : '' }}">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="end_time_{{ $schedule->id }}" class="form-label font-weight-bold">Jam Selesai</label>
                                <input type="time" name="end_time" id="end_time_{{ $schedule->id }}" class="form-control border px-2" value="{{ $schedule->end_time ? \Carbon\Carbon::parse($schedule->end_time)->format('H:i') : '' }}">
                            </div>
                        </div>
                        <small class="text-muted">Biarkan jam mulai & jam selesai kosong jika hari tersebut dihitung libur.</small>
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
