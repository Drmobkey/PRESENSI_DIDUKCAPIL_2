<div class="modal fade" id="checkOutModal" tabindex="-1" aria-labelledby="checkOutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('attendances.check-out') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-warning border-0">
                    <h5 class="modal-title text-white" id="checkOutModalLabel">
                        <i class="material-icons align-middle me-1">logout</i> Check Out Presensi
                    </h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <input type="hidden" name="latitude" id="checkout_latitude">
                    <input type="hidden" name="longitude" id="checkout_longitude">

                    <div class="alert alert-info text-white text-sm py-2 px-3 mb-4 d-flex align-items-center"
                        id="checkout_location_status">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        Mengambil lokasi akurat...
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark font-weight-bold text-sm">Ambil / Unggah Foto Kepulangan</label>
                        
                        <!-- Camera Area -->
                        <div class="mb-2 text-center" id="checkout_camera_area">
                            <video id="checkout_video" class="w-100 rounded shadow-sm border border-2 border-warning" autoplay playsinline style="display: none; max-height: 300px; object-fit: cover;"></video>
                            <button type="button" id="checkout_start_camera_btn" class="btn btn-sm btn-outline-warning w-100 mb-2">
                                <i class="material-icons align-middle me-1">camera_alt</i> Buka Kamera
                            </button>
                            <button type="button" id="checkout_snap_btn" class="btn btn-sm btn-warning w-100 mb-2 text-white" style="display: none;">
                                <i class="material-icons align-middle me-1">camera</i> Ambil Foto
                            </button>
                        </div>

                        <!-- Or File Input -->
                        <div class="text-center text-xs text-secondary mb-3">- ATAU PILIH BERKAS -</div>
                        
                        <label for="checkout_photo_input" class="btn btn-outline-secondary w-100 mb-1" style="border-style: dashed; padding: 12px;">
                            <i class="material-icons align-middle me-2">upload_file</i> 
                            <span id="checkout_file_label">Klik untuk memilih gambar...</span>
                        </label>
                        <input type="file" name="photo_out" id="checkout_photo_input" accept="image/*"
                            capture="environment" class="d-none" required>
                        <small class="text-secondary d-block mt-1 text-xs text-center">Maks. 2MB, format gambar (jpg/png).</small>
                        @error('photo_out')
                            <div class="text-danger text-xs mt-1 text-center">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-center mb-4" id="checkout_photo_preview_wrapper" style="display:none;">
                        <img id="checkout_photo_preview" src="#" alt="Preview"
                            class="rounded shadow border border-2 border-warning"
                            style="max-height: 200px; width: auto; object-fit: cover;">
                        <button type="button" id="checkout_retake_btn" class="btn btn-sm btn-outline-danger mt-2 w-100" style="display: none;">
                            <i class="material-icons align-middle me-1">refresh</i> Ambil Ulang
                        </button>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-dark font-weight-bold text-sm">Logbook / Laporan Kegiatan (Opsional)</label>
                        <textarea name="logbook_description"
                            class="form-control p-2 border border-2 rounded bg-gray-100" rows="3"
                            placeholder="Ceritakan aktivitas kerja Anda hari ini (min. 10 karakter)..."></textarea>
                        <small class="text-secondary d-block mt-2 text-xs">
                            Boleh dikosongkan jika Anda sudah mengisi logbook hari ini sebelumnya.
                        </small>
                        @error('logbook_description')
                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer border-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white" id="checkout_submit_btn" disabled>
                        Simpan Check Out
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let checkoutStream = null;
    const checkoutVideo = document.getElementById('checkout_video');
    const checkoutStartCamBtn = document.getElementById('checkout_start_camera_btn');
    const checkoutSnapBtn = document.getElementById('checkout_snap_btn');
    const checkoutPhotoInput = document.getElementById('checkout_photo_input');
    const checkoutPreviewWrapper = document.getElementById('checkout_photo_preview_wrapper');
    const checkoutPreviewImg = document.getElementById('checkout_photo_preview');
    const checkoutRetakeBtn = document.getElementById('checkout_retake_btn');

    // Start Camera
    checkoutStartCamBtn.addEventListener('click', async function() {
        try {
            checkoutStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
            checkoutVideo.srcObject = checkoutStream;
            checkoutVideo.style.display = 'block';
            checkoutSnapBtn.style.display = 'block';
            checkoutStartCamBtn.style.display = 'none';
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "Tidak dapat mengakses kamera. Pastikan browser memiliki izin kamera.",
            });
        }
    });

    // Snap Photo
    checkoutSnapBtn.addEventListener('click', function() {
        const canvas = document.createElement('canvas');
        canvas.width = checkoutVideo.videoWidth;
        canvas.height = checkoutVideo.videoHeight;
        canvas.getContext('2d').drawImage(checkoutVideo, 0, 0);
        
        // Convert to file
        const dataURL = canvas.toDataURL('image/jpeg');
        const arr = dataURL.split(',');
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);
        while(n--) { u8arr[n] = bstr.charCodeAt(n); }
        const file = new File([u8arr], "kamera_checkout.jpg", { type: mime });

        // Set to input
        const dt = new DataTransfer();
        dt.items.add(file);
        checkoutPhotoInput.files = dt.files;
        
        // Trigger preview
        checkoutPhotoInput.dispatchEvent(new Event('change'));

        // Stop camera
        if (checkoutStream) {
            checkoutStream.getTracks().forEach(track => track.stop());
        }
        checkoutVideo.style.display = 'none';
        checkoutSnapBtn.style.display = 'none';
        checkoutStartCamBtn.style.display = 'block';
        checkoutRetakeBtn.style.display = 'block';
    });

    checkoutRetakeBtn.addEventListener('click', function() {
        checkoutPhotoInput.value = '';
        checkoutPreviewWrapper.style.display = 'none';
        checkoutRetakeBtn.style.display = 'none';
        checkoutStartCamBtn.click();
    });

    // Preview foto sebelum upload
    checkoutPhotoInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('checkout_file_label').textContent = file.name;
            checkoutPreviewImg.src = URL.createObjectURL(file);
            checkoutPreviewWrapper.style.display = 'block';
            // Stop stream if file is chosen manually while cam is on
            if (checkoutStream && checkoutVideo.style.display === 'block') {
                checkoutStream.getTracks().forEach(track => track.stop());
                checkoutVideo.style.display = 'none';
                checkoutSnapBtn.style.display = 'none';
                checkoutStartCamBtn.style.display = 'block';
            }
        } else {
            document.getElementById('checkout_file_label').textContent = 'Klik untuk memilih gambar...';
            checkoutPreviewWrapper.style.display = 'none';
            checkoutRetakeBtn.style.display = 'none';
        }
    });

    // Cleanup when modal closed
    document.getElementById('checkOutModal').addEventListener('hidden.bs.modal', function () {
        if (checkoutStream) {
            checkoutStream.getTracks().forEach(track => track.stop());
        }
        checkoutVideo.style.display = 'none';
        checkoutSnapBtn.style.display = 'none';
        checkoutStartCamBtn.style.display = 'block';
    });
</script>