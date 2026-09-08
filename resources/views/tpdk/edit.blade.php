<!-- Modal Edit TPDK -->
@foreach ($tpdks as $tpdk)
    <div class="modal fade" id="editTpdkModal-{{ $tpdk->id }}" tabindex="-1"
        aria-labelledby="editTpdkModalLabel-{{ $tpdk->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="editTpdkModalLabel-{{ $tpdk->id }}">
                        <i class="material-icons align-middle me-1">edit_location</i> Edit:
                        <strong>{{ $tpdk->name }}</strong>
                    </h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tpdks.update', $tpdk->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div id="map_edit_{{ $tpdk->id }}" class="map-edit" data-id="{{ $tpdk->id }}" data-lat="{{ $tpdk->latitude }}" data-lng="{{ $tpdk->longitude }}" data-rad="{{ $tpdk->radius }}" style="height: 300px; width: 100%; border-radius: 8px; z-index: 1;"></div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-sm">Nama Cabang / TPDK <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control border border-2 p-2" required
                                value="{{ old('name', $tpdk->name) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-sm">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat_edit_{{ $tpdk->id }}" class="form-control border border-2 p-2" rows="2" required>{{ old('alamat', $tpdk->alamat) }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-sm">Latitude <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="any" name="latitude" id="lat_edit_{{ $tpdk->id }}" class="form-control border border-2 p-2"
                                    required value="{{ old('latitude', $tpdk->latitude) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-sm">Longitude <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="any" name="longitude" id="long_edit_{{ $tpdk->id }}" class="form-control border border-2 p-2"
                                    required value="{{ old('longitude', $tpdk->longitude) }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-sm">Radius Presensi (Meter) <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="radius" id="rad_edit_{{ $tpdk->id }}" class="form-control border border-2 p-2" required
                                value="{{ old('radius', $tpdk->radius) }}">
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