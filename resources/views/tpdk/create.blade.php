<!-- Modal Tambah TPDK -->
<div class="modal fade" id="createTpdkModal" tabindex="-1" aria-labelledby="createTpdkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="createTpdkModalLabel">
                    <i class="material-icons align-middle me-1">add_location_alt</i> Tambah Titik TPDK
                </h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tpdks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Tempat untuk Peta Nanti (Bisa disisipkan div map di sini nantinya) -->
                    <div id="map_create" style="height: 300px; width: 100%; border-radius: 8px; z-index: 1;"></div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Nama Cabang / TPDK <span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control border border-2 p-2"
                            placeholder="Contoh: TPDK Kecamatan A" required value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat_create" class="form-control border border-2 p-2" rows="2" placeholder="Alamat lengkap TPDK" required>{{ old('alamat') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold text-sm">Latitude <span
                                    class="text-danger">*</span></label>
                            <input type="number" step="any" name="latitude" id="lat_create"
                                class="form-control border border-2 p-2" placeholder="-6.9xxx" required
                                value="{{ old('latitude') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold text-sm">Longitude <span
                                    class="text-danger">*</span></label>
                            <input type="number" step="any" name="longitude" id="long_create"
                                class="form-control border border-2 p-2" placeholder="110.4xxx" required
                                value="{{ old('longitude') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-sm">Radius Presensi (Meter) <span
                                class="text-danger">*</span></label>
                        <input type="number" name="radius" class="form-control border border-2 p-2"
                            placeholder="Contoh: 50" required value="{{ old('radius', 50) }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary mb-0">Simpan TPDK</button>
                </div>
            </form>
        </div>
    </div>
</div>