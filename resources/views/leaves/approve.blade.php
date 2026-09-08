@foreach ($leaves as $leave)
    {{-- Tampilkan modal hanya jika status pending dan user memiliki wewenang admin --}}
    @if($leave->status === 'pending' && (auth()->user()->can('leaves.manage_all') || auth()->user()->can('leaves.manage_branch')))
        <div class="modal fade" id="approveLeaveModal-{{ $leave->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-normal text-success">
                            <i class="material-icons align-middle me-1">check_circle</i> Konfirmasi Persetujuan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('leaves.approve', $leave->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body text-center py-4">
                            <p class="mb-0">Apakah Anda yakin ingin menyetujui pengajuan izin ini?</p>
                            <h5 class="font-weight-bold mt-2">{{ $leave->user->name }}</h5>
                            <p class="text-sm font-weight-bold mb-0 text-capitalize">
                                Jenis: {{ str_replace('_', ' ', $leave->type) }}
                            </p>
                            <p class="text-xs text-muted mt-3 mb-0">
                                Sistem akan otomatis membuat rekam presensi "<strong>{{ $leave->type }}</strong>" <br>
                                dari tanggal {{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }} s/d
                                {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}.
                            </p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn bg-gradient-success mb-0">Ya, Setujui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach