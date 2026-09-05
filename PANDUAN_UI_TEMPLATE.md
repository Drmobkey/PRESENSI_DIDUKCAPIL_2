# Panduan & Dokumentasi UI Template: Material Dashboard 2 (Laravel)
**Aplikasi:** Presensi Disdukcapil  
**Framework:** Laravel Blade + Bootstrap 5 + Material Dashboard 2  

---

## 1. Ringkasan & Identitas Template
Template yang Anda gunakan adalah **Material Dashboard 2 (Laravel Edition)** buatan Creative Tim & UPDIVISION.  
Template ini dibangun di atas **Bootstrap 5** dengan gaya visual modern ala **Google Material Design 3** (sudut membulat, kartu melayang/floating shadows, gradient cerah, dan typography rapi).

---

## 2. Struktur Direktori & Analisis File

### A. Direktori `public/` (Aset Statis Web)
Semua file yang bisa diakses langsung oleh browser publik ditaruh di sini:

```
public/assets/
├── css/
│   ├── material-dashboard.css      # CSS utama tema Material (modifikasi Bootstrap 5)
│   ├── material-dashboard.min.css  # Versi ringkas/minified untuk produksi
│   ├── nucleo-icons.css            # Font icon bawaan tema (Nucleo)
│   └── nucleo-svg.css              # Ikon SVG pelengkap
├── js/
│   ├── core/
│   │   ├── popper.min.js           # Penempatan tooltip & dropdown
│   │   └── bootstrap.min.js        # Komponen interaktif Bootstrap 5 (modal, collapse, dropdown)
│   ├── plugins/
│   │   ├── perfect-scrollbar.min.js# Scrollbar kustom yang halus di sidebar & tabel
│   │   ├── smooth-scrollbar.min.js # Pengatur animasi scroll
│   │   └── chartjs.min.js          # Library grafik untuk dashboard
│   ├── material-dashboard.min.js   # Script inisialisasi ripple effect, navbar blur, dsb.
│   └── datatables.js / flatpickr.js# Library tabel & kalender tambahan
└── img/
    ├── logo-ct.png                 # Logo default pada sidebar
    └── team-*.jpg / marie.jpg      # Contoh gambar avatar pengguna
```

---

### B. Direktori `resources/views/` (Blade Template)
Struktur Blade ini telah dirancang secara modular menggunakan **Laravel Blade Components** (`<x-...>`).

```
resources/views/
├── components/                     # [PENTING] Komponen modular yang dipakai berulang
│   ├── layout.blade.php            # Master Layout (HTML wrapper: <head>, asset CSS/JS, body)
│   ├── plugins.blade.php           # Floating sidebar setting (pengganti warna tema/dark mode)
│   ├── footers/
│   │   ├── auth.blade.php          # Footer halaman setelah login
│   │   └── guest.blade.php         # Footer halaman login/register
│   └── navbars/
│       ├── sidebar.blade.php       # Navigasi samping (menu utama)
│       └── navs/
│           ├── auth.blade.php      # Topbar/Navbar atas saat login (search, profil, logout, breadcrumbs)
│           └── guest.blade.php     # Topbar sederhana untuk halaman login/register
├── dashboard/
│   └── index.blade.php             # Contoh tampilan dashboard (kartu statistik & grafik)
├── pages/                          # Contoh template halaman siap pakai
│   ├── tables.blade.php            # Contoh tabel data list (CRUD)
│   ├── profile.blade.php           # Contoh halaman profil user
│   ├── notifications.blade.php     # Contoh alert & toast notifikasi
│   └── laravel-examples/           # Contoh manajemen user bawaan template
├── sessions/                       # Autentikasi
│   ├── create.blade.php            # Halaman Login
│   └── password/                   # Halaman Lupa & Reset Password
└── register/
    └── create.blade.php            # Halaman Register
```

---

## 3. Cara Kerja Arsitektur Blade Component

Template ini tidak menggunakan `@extends('layouts.app')` konvensional, melainkan fitur modern Laravel yaitu **Blade Component Tag** (`<x-layout>`).

### Cara Kerja `<x-layout>`:
1. File `resources/views/components/layout.blade.php` mendefinisikan kerangka HTML (Head, Tag CSS, Tag JS).
2. Di dalam file tersebut terdapat variabel `{{ $slot }}`.
3. Konten apa pun yang Anda tulis di antara pembuka `<x-layout>` dan penutup `</x-layout>` akan otomatis dimasukkan ke dalam `{{ $slot }}` tersebut.

---

## 4. Pola & Boilerplate Pembuatan Halaman Baru

Saat Anda ingin membuat halaman baru (misalnya halaman data **Presensi**, **Cuti / Leaves**, atau **Pengguna**), gunakan pola standar berikut:

```html
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <!-- 1. Panggil Sidebar (tandai menu yang aktif) -->
    <x-navbars.sidebar activePage="attendances"></x-navbars.sidebar>

    <!-- 2. Konten Utama -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        
        <!-- Topbar Navbar -->
        <x-navbars.navs.auth titlePage="Data Presensi"></x-navbars.navs.auth>

        <!-- Container Isi Halaman -->
        <div class="container-fluid py-4">
            
            <!-- TARUH KONTEN ANDA DI SINI (Card, Tabel, Form, dll) -->
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Daftar Presensi Pegawai</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    ...
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <x-footers.auth></x-footers.auth>
        </div>
    </main>

    <!-- Opsional: Konfigurator tema -->
    <x-plugins></x-plugins>

    <!-- Script khusus untuk halaman ini (jika ada) -->
    @push('js')
    <script>
        // JS khusus halaman ini
    </script>
    @endpush
</x-layout>
```

---

## 5. Cheat Sheet Komponen UI Penting

### A. Kartu Ringkasan / Metrik (Metric Card)
Digunakan untuk menampilkan total hadir, izin, sakit, dsb:
```html
<div class="col-xl-3 col-sm-6 mb-4">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <!-- Icon Melayang (Floating Icon) -->
            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">done_all</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Hadir Hari Ini</p>
                <h4 class="mb-0">128 Pegawai</h4>
            </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">95% </span>tingkat kehadiran</p>
        </div>
    </div>
</div>
```

### B. Input Form (Material Outline Style)
Material Dashboard menggunakan efek floating label khusus.  
*Penting: Tambahkan class `is-filled` jika input sudah ada nilainya (misal saat form edit/old input).*
```html
<div class="input-group input-group-outline my-3 {{ old('name') ? 'is-filled' : '' }}">
    <label class="form-label">Nama Lengkap</label>
    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
</div>
```

### C. Tombol dengan Warna Gradient
Tersedia beragam variasi gradient:
```html
<button class="btn bg-gradient-primary">Simpan (Primary)</button>
<button class="btn bg-gradient-info">Info / Detail</button>
<button class="btn bg-gradient-success">Setujui / Approve</button>
<button class="btn bg-gradient-danger">Tolak / Hapus</button>
<button class="btn bg-gradient-warning">Peringatan</button>
<button class="btn bg-gradient-dark">Kembali / Batal</button>
```

### D. Badge Status
Bagus untuk status absensi atau permohonan cuti:
```html
<span class="badge badge-sm bg-gradient-success">Tepat Waktu</span>
<span class="badge badge-sm bg-gradient-warning">Terlambat</span>
<span class="badge badge-sm bg-gradient-danger">Alpha</span>
<span class="badge badge-sm bg-gradient-info">Izin / Cuti</span>
```

---

## 6. Tips Menyesuaikan Template untuk Presensi Disdukcapil

1. **Ubah Menu Sidebar di `resources/views/components/navbars/sidebar.blade.php`**:
   - Ganti menu contoh ("Tables", "Billing", "Virtual Reality") dengan menu sistem Anda:
     - **Dashboard**: `route('dashboard')`
     - **Presensi Pegawai**: `route('attendances.index')`
     - **Pengajuan Cuti**: `route('leaves.index')`
     - **Logbook Harian**: `route('logbooks.index')`
     - **Kelola Pengguna**: `route('setup.users.index')`
     - **Kelola Role**: `route('setup.roles.index')`
2. **Ganti Logo & Judul Branding**:
   - Buka `resources/views/components/navbars/sidebar.blade.php` baris 9–12.
   - Ganti teks *"Material Dashboard 2"* dengan *"Presensi Disdukcapil"*.
   - Ganti logo `asset('assets/img/logo-ct.png')` dengan logo Kabupaten / Disdukcapil di folder `public/assets/img/`.
3. **Menambahkan CSS/JS Tambahan (misal Peta GPS / Leaflet)**:
   - Gunakan `@push('js')` di bagian bawah file view Anda agar script otomatis dieksekusi setelah Bootstrap & jQuery dimuat.
