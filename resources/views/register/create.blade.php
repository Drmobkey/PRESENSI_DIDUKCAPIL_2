<x-layout bodyClass="bg-gray-200">
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <!-- Kolon Kiri: Banner Ilustrasi, Logo Semarang & Branding SIMAGA (Desktop) -->
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                            <div class="position-relative h-100 m-3 px-5 border-radius-2xl d-flex flex-column justify-content-center overflow-hidden shadow-2xl"
                                style="background-color: #1a1a2e;">
                                <!-- Layer 1: Background Foto Lawang Sewu yang diperhalus -->
                                <div class="position-absolute top-0 start-0 w-100 h-100" style="
                                    background-image: url('{{ asset('assets/img/Lawang_Sewu.jpg') }}');
                                    background-size: cover;
                                    background-position: center;
                                    filter: blur(4px) brightness(0.6);
                                    transform: scale(1.08);
                                    z-index: 1;">
                                </div>

                                <!-- Layer 2: Gradient Overlay Elegan khas Material Dashboard -->
                                <div class="position-absolute top-0 start-0 w-100 h-100" style="
                                    background: linear-gradient(135deg, rgba(233, 30, 99, 0.78) 0%);
                                    z-index: 2;">
                                </div>

                                <!-- Layer 3: Konten Branding SIMAGA & Pemkot Semarang -->
                                <div class="position-relative text-white py-5 px-4" style="z-index: 3;">
                                    <div class="mb-4">
                                        <img src="{{ asset('assets/img/Lambang_Kota_Semarang.png') }}"
                                            alt="Logo Kota Semarang" class="img-fluid"
                                            style="max-width: 135px; height: auto; filter: drop-shadow(0 10px 18px rgba(0,0,0,0.4));">
                                    </div>
                                    <span
                                        class="badge bg-white text-dark text-uppercase font-weight-bolder px-3 py-2 mb-3 shadow-sm"
                                        style="letter-spacing: 1px; font-size: 0.72rem; border-radius: 50rem;">
                                        Pemerintah Kota Semarang
                                    </span>
                                    <h2 class="text-white font-weight-bolder mb-2" style="letter-spacing: -0.5px;">
                                        SIMAGA</h2>
                                    <h5 class="text-white font-weight-normal mb-3" style="opacity: 0.95;">
                                        Sistem Informasi Magang & Presensi
                                    </h5>
                                    <div class="mx-auto"
                                        style="width: 60px; height: 3px; background: rgba(255,255,255,0.7); border-radius: 2px;">
                                    </div>
                                    <p class="text-white text-sm mt-3 mb-0"
                                        style="opacity: 0.85; max-width: 360px; margin: 0 auto; line-height: 1.5;">
                                        Dinas Kependudukan dan Pencatatan Sipil Kota Semarang
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Kolon Kanan: Form Registrasi -->
                        <div
                            class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5 my-auto py-5">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start bg-transparent">
                                    <!-- Header Logo khusus tampilan Mobile / Layar Kecil -->
                                    <div class="d-lg-none text-center mb-4">
                                        <img src="{{ asset('assets/img/Lambang_Kota_Semarang.png') }}"
                                            alt="Logo Kota Semarang"
                                            style="width: 75px; height: auto; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));"
                                            class="mb-2">
                                        <h3 class="font-weight-bolder text-primary text-gradient mb-0">SIMAGA</h3>
                                        <p class="text-xs text-secondary mb-0">Sistem Informasi Magang dan Presensi</p>
                                    </div>

                                    <h4 class="font-weight-bolder text-dark mb-1">Daftar Akun Baru</h4>
                                    <p class="mb-0 text-sm text-secondary">Lengkapi formulir di bawah ini untuk membuat
                                        akun Anda</p>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('register') }}" role="form">
                                        @csrf

                                        <!-- Nama Lengkap -->
                                        <div
                                            class="input-group input-group-outline mt-3 {{ old('name') ? 'is-filled' : '' }}">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        </div>
                                        @error('name')
                                            <p class='text-danger inputerror text-xs mt-1 mb-0'>{{ $message }}</p>
                                        @enderror

                                        <!-- Alamat Email -->
                                        <div
                                            class="input-group input-group-outline mt-3 {{ old('email') ? 'is-filled' : '' }}">
                                            <label class="form-label">Alamat Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email') }}" required autocomplete="email">
                                        </div>
                                        @error('email')
                                            <p class='text-danger inputerror text-xs mt-1 mb-0'>{{ $message }}</p>
                                        @enderror

                                        <!-- Penempatan TPDK (Required oleh CreateNewUser) -->
                                        <div class="input-group input-group-outline mt-3 is-filled">
                                            <label class="form-label">Unit Kerja / Lokasi TPDK</label>
                                            <select name="tpdk_id" class="form-control" required
                                                style="padding-top: 10px;">
                                                <option value="" disabled {{ old('tpdk_id') ? '' : 'selected' }}>
                                                </option>
                                                @foreach(\App\Models\Tpdk::orderBy('name')->get() as $tpdk)
                                                    <option value="{{ $tpdk->id }}" {{ old('tpdk_id') == $tpdk->id ? 'selected' : '' }}>
                                                        {{ $tpdk->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('tpdk_id')
                                            <p class='text-danger inputerror text-xs mt-1 mb-0'>{{ $message }}</p>
                                        @enderror

                                        <!-- Kata Sandi -->
                                        <div class="input-group input-group-outline mt-3">
                                            <label class="form-label">Kata Sandi</label>
                                            <input type="password" class="form-control" name="password" required
                                                autocomplete="new-password">
                                        </div>
                                        @error('password')
                                            <p class='text-danger inputerror text-xs mt-1 mb-0'>{{ $message }}</p>
                                        @enderror

                                        <!-- Konfirmasi Kata Sandi (Required oleh Fortify) -->
                                        <div class="input-group input-group-outline mt-3">
                                            <label class="form-label">Konfirmasi Kata Sandi</label>
                                            <input type="password" class="form-control" name="password_confirmation"
                                                required autocomplete="new-password">
                                        </div>

                                        <!-- Persetujuan Syarat & Ketentuan -->
                                        <!-- <div class="form-check form-check-info text-start ps-0 mt-3">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                id="flexCheckDefault" checked required>
                                            <label class="form-check-label text-sm text-secondary"
                                                for="flexCheckDefault">
                                                Saya menyetujui <a href="javascript:;"
                                                    class="text-primary font-weight-bolder">Syarat & Ketentuan</a> yang
                                                berlaku
                                            </label>
                                        </div> -->

                                        <!-- Tombol Pendaftaran -->
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn bg-gradient-primary w-100 mt-4 mb-0 py-3 font-weight-bold shadow-primary">
                                                Daftar Sekarang
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-2 text-sm mx-auto text-secondary">
                                        Sudah memiliki akun?
                                        <a href="{{ route('login') }}"
                                            class="text-primary text-gradient font-weight-bold">
                                            Masuk di sini
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('js')
        <script src="{{ asset('assets') }}/js/jquery.min.js"></script>
        <script>
            $(function () {
                // Fungsi untuk mengecek apakah input memiliki nilai
                function checkInputFilled(element) {
                    var val = $(element).val();
                    if (val !== "" && val !== null) {
                        $(element).closest('.input-group').addClass('is-filled');
                    } else {
                        $(element).closest('.input-group').removeClass('is-filled');
                    }
                }

                // Inisialisasi awal saat halaman dimuat
                $(".input-group input, .input-group select").each(function () {
                    checkInputFilled(this);
                });

                // Efek fokus
                $(".input-group input, .input-group select").on('focus', function () {
                    $(this).closest('.input-group').addClass('is-focused');
                });

                // Efek keluar fokus
                $(".input-group input, .input-group select").on('blur change', function () {
                    $(this).closest('.input-group').removeClass('is-focused');
                    checkInputFilled(this);
                });
            });
        </script>
    @endpush
</x-layout>