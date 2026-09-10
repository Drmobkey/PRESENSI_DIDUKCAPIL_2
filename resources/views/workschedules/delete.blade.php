@foreach($schedules as $schedule)
    <!-- Modal Hapus Jadwal -->
    <div class="modal fade" id="deleteWorkScheduleModal-{{ $schedule->id }}" tabindex="-1" aria-labelledby="deleteWorkScheduleModalLabel-{{ $schedule->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal text-danger" id="deleteWorkScheduleModalLabel-{{ $schedule->id }}">Hapus Jadwal Kerja</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="material-icons text-danger" style="font-size: 3rem;">warning</i>
                    <p class="mt-3 mb-0">Apakah Anda yakin ingin menghapus jadwal untuk hari <strong>{{ $days[$schedule->day_of_week] ?? '-' }}</strong>?</p>
                    <p class="text-sm text-secondary">Aksi ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('workschedules.destroy', $schedule->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-gradient-danger mb-0">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
