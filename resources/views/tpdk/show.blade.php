<!-- Modal Show TPDK -->
@foreach ($tpdks as $tpdk)
    <div class="modal fade" id="showTpdkModal-{{ $tpdk->id }}" tabindex="-1"
        aria-labelledby="showTpdkModalLabel-{{ $tpdk->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="showTpdkModalLabel-{{ $tpdk->id }}">
                        <i class="material-icons align-middle me-1">visibility</i> Detail:
                        <strong>{{ $tpdk->name }}</strong>
                    </h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Map untuk melihat lokasi TPDK -->
                    <div id="map_show_{{ $tpdk->id }}" class="map-show" data-lat="{{ $tpdk->latitude }}" data-lng="{{ $tpdk->longitude }}" data-rad="{{ $tpdk->radius }}" style="height: 300px; width: 100%; border-radius: 8px; z-index: 1;"></div>
                    
                    <div class="mt-4">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <th style="width: 30%">Nama TPDK</th>
                                    <td>: {{ $tpdk->name }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>: {{ $tpdk->alamat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Latitude</th>
                                    <td>: {{ $tpdk->latitude }}</td>
                                </tr>
                                <tr>
                                    <th>Longitude</th>
                                    <td>: {{ $tpdk->longitude }}</td>
                                </tr>
                                <tr>
                                    <th>Radius (Meter)</th>
                                    <td>: {{ $tpdk->radius }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
