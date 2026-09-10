<div class="modal fade" id="checkInModal" tabindex="-1" aria-labelledby="checkInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('attendances.check-in') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-success border-0">
                    <h5 class="modal-title text-white" id="checkInModalLabel">
                        <i class="material-icons align-middle me-1">login</i> Check In Presensi
                    </h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <input type="hidden" name="latitude" id="checkin_latitude">
                    <input type="hidden" name="longitude" id="checkin_longitude">

                    <div class="alert alert-info text-white text-sm py-2 px-3 mb-4 d-flex align-items-center"
                        id="checkin_location_status">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        Mengambil lokasi akurat...
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark font-weight-bold text-sm">Ambil / Unggah Foto Kehadiran</label>
                        
                        <!-- Camera Area -->
                        <div class="mb-2 text-center" id="checkin_camera_area">
                            <video id="checkin_video" class="w-100 rounded shadow-sm border border-2 border-success" autoplay playsinline style="display: none; max-height: 300px; object-fit: cover;"></video>
                            <button type="button" id="checkin_start_camera_btn" class="btn btn-sm btn-outline-success w-100 mb-2">
                                <i class="material-icons align-middle me-1">camera_alt</i> Buka Kamera
                            </button>
                            <button type="button" id="checkin_snap_btn" class="btn btn-sm btn-success w-100 mb-2" style="display: none;">
                                <i class="material-icons align-middle me-1">camera</i> Ambil Foto
                            </button>
                        </div>

                        <!-- Or File Input -->
                        <div class="text-center text-xs text-secondary mb-3">- ATAU PILIH BERKAS -</div>
                        
                        <label for="checkin_photo_input" class="btn btn-outline-secondary w-100 mb-1" style="border-style: dashed; padding: 12px;">
                            <i class="material-icons align-middle me-2">upload_file</i> 
                            <span id="checkin_file_label">Klik untuk memilih gambar...</span>
                        </label>
                        <input type="file" name="photo_in" id="checkin_photo_input" accept="image/*"
                            capture="environment" class="d-none" required>
                        <small class="text-secondary d-block mt-1 text-xs text-center">Maks. 2MB, format gambar (jpg/png).</small>
                        @error('photo_in')
                            <div class="text-danger text-xs mt-1 text-center">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-center mt-3" id="checkin_photo_preview_wrapper" style="display:none;">
                        <img id="checkin_photo_preview" src="#" alt="Preview"
                            class="rounded shadow border border-2 border-success"
                            style="max-height: 200px; width: auto; object-fit: cover;">
                        <button type="button" id="checkin_retake_btn" class="btn btn-sm btn-outline-danger mt-2 w-100" style="display: none;">
                            <i class="material-icons align-middle me-1">refresh</i> Ambil Ulang
                        </button>
                    </div>
                </div>

                <div class="modal-footer border-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" id="checkin_submit_btn" disabled>
                        Simpan Check In
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let checkinStream = null;
    const checkinVideo = document.getElementById('checkin_video');
    const checkinStartCamBtn = document.getElementById('checkin_start_camera_btn');
    const checkinSnapBtn = document.getElementById('checkin_snap_btn');
    const checkinPhotoInput = document.getElementById('checkin_photo_input');
    const checkinPreviewWrapper = document.getElementById('checkin_photo_preview_wrapper');
    const checkinPreviewImg = document.getElementById('checkin_photo_preview');
    const checkinRetakeBtn = document.getElementById('checkin_retake_btn');

    // Start Camera
    checkinStartCamBtn.addEventListener('click', async function() {
        try {
            checkinStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
            checkinVideo.srcObject = checkinStream;
            checkinVideo.style.display = 'block';
            checkinSnapBtn.style.display = 'block';
            checkinStartCamBtn.style.display = 'none';
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "Tidak dapat mengakses kamera. Pastikan browser memiliki izin kamera.",
            });
        }
    });

    // Snap Photo
    checkinSnapBtn.addEventListener('click', function() {
        const canvas = document.createElement('canvas');
        canvas.width = checkinVideo.videoWidth;
        canvas.height = checkinVideo.videoHeight;
        canvas.getContext('2d').drawImage(checkinVideo, 0, 0);
        
        // Convert to file
        const dataURL = canvas.toDataURL('image/jpeg');
        const arr = dataURL.split(',');
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);
        while(n--) { u8arr[n] = bstr.charCodeAt(n); }
        const file = new File([u8arr], "kamera_checkin.jpg", { type: mime });

        // Set to input
        const dt = new DataTransfer();
        dt.items.add(file);
        checkinPhotoInput.files = dt.files;
        
        // Trigger preview
        checkinPhotoInput.dispatchEvent(new Event('change'));

        // Stop camera
        if (checkinStream) {
            checkinStream.getTracks().forEach(track => track.stop());
        }
        checkinVideo.style.display = 'none';
        checkinSnapBtn.style.display = 'none';
        checkinStartCamBtn.style.display = 'block';
        checkinRetakeBtn.style.display = 'block';
    });

    checkinRetakeBtn.addEventListener('click', function() {
        checkinPhotoInput.value = '';
        checkinPreviewWrapper.style.display = 'none';
        checkinRetakeBtn.style.display = 'none';
        checkinStartCamBtn.click();
    });

    // Preview foto sebelum upload
    checkinPhotoInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('checkin_file_label').textContent = file.name;
            checkinPreviewImg.src = URL.createObjectURL(file);
            checkinPreviewWrapper.style.display = 'block';
            // Stop stream if file is chosen manually while cam is on
            if (checkinStream && checkinVideo.style.display === 'block') {
                checkinStream.getTracks().forEach(track => track.stop());
                checkinVideo.style.display = 'none';
                checkinSnapBtn.style.display = 'none';
                checkinStartCamBtn.style.display = 'block';
            }
        } else {
            document.getElementById('checkin_file_label').textContent = 'Klik untuk memilih gambar...';
            checkinPreviewWrapper.style.display = 'none';
            checkinRetakeBtn.style.display = 'none';
        }
    });

    // Cleanup when modal closed
    document.getElementById('checkInModal').addEventListener('hidden.bs.modal', function () {
        if (checkinStream) {
            checkinStream.getTracks().forEach(track => track.stop());
        }
        checkinVideo.style.display = 'none';
        checkinSnapBtn.style.display = 'none';
        checkinStartCamBtn.style.display = 'block';
    });
</script>