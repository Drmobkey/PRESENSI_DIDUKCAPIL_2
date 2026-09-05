# Panduan Lengkap Template Material Dashboard 2 Laravel
### Sistem Informasi Presensi Disdukcapil

Dokumen ini disusun sebagai panduan belajar dan referensi teknis dalam memahami, menggunakan, serta mengembangkan antarmuka (UI) menggunakan template **Material Dashboard 2 Laravel**.

---

## Daftar Isi
1. [Ringkasan Eksekutif & Identitas Template](#1-ringkasan-eksekutif--identitas-template)
2. [Temuan Kritis: Aset pada Direktori Public](#2-temuan-kritis-aset-pada-direktori-public)
3. [Peta dan Deskripsi Struktur Direktori](#3-peta-dan-deskripsi-struktur-direktori)
4. [Arsitektur & Konsep Blade Component](#4-arsitektur--konsep-blade-component)
5. [Tutorial Praktis: Membuat Halaman UI Baru](#5-tutorial-praktis-membuat-halaman-ui-baru)
6. [Kustomisasi Menu Navigasi (Sidebar)](#6-kustomisasi-menu-navigasi-sidebar)
7. [Cheat Sheet Desain UI (Kamus Kelas CSS)](#7-cheat-sheet-desain-ui-kamus-kelas-css)
8. [Langkah Tindak Lanjut](#8-langkah-tindak-lanjut)

---

## 1. Ringkasan Eksekutif & Identitas Template

* **Nama Template**: Material Dashboard 2 (Laravel Edition)
* **Pengembang**: Creative Tim & UPDIVISION
* **Basis Kerangka**: Bootstrap 5 + Laravel Blade Components
* **Karakteristik Visual**:
  * Sudut membulat (*border-radius* modern: `border-radius-xl`, `border-radius-lg`).
  * Header kartu melayang di luar kontainer (*floating elevated headers* menggunakan `mt-n4`).
  * Bayangan berwarna (*colored drop shadows* seperti `shadow-primary`, `shadow-success`).
  * Aksen gradasi warna (*vibrant gradients*).
  * Sistem ikon: **Google Material Icons** (`<i class="material-icons">...</i>`) dan **Font Awesome**.

---

## 2. Temuan Kritis: Aset pada Direktori Public

> [!CAUTION]
> **Status Kelengkapan Aset**: Belum Lengkap!
> Saat ini, folder `public/assets/` hanya memiliki file CSS dan file JS bawaan kosong (`app.js`, `bootstrap.js`). Script interaktif dan gambar pendukung belum tersalin.

### Kondisi Saat Ini di `public/assets/`:
* `public/assets/css/` : ✅ Lengkap (`material-dashboard.css`, `nucleo-icons.css`, `nucleo-svg.css`).
* `public/assets/js/` : ❌ **Kurang folder `core/` dan `plugins/`**.
* `public/assets/img/` : ❌ **Folder gambar belum ada**.

### File yang Wajib Disalin dari Master Template Asli:
1. **JavaScript Inti (`public/assets/js/`)**:
   * `public/assets/js/core/popper.min.js` *(Untuk positioning dropdown & tooltip)*
   * `public/assets/js/core/bootstrap.min.js` *(Komponen interaktif Bootstrap 5)*
   * `public/assets/js/plugins/perfect-scrollbar.min.js` *(Scrollbar halus sidebar)*
   * `public/assets/js/plugins/smooth-scrollbar.min.js`
   * `public/assets/js/material-dashboard.min.js` *(Script kontrol utama tema)*
2. **Gambar Aset (`public/assets/img/`)**:
   * `logo-ct.png` (Logo default sidebar)
   * `favicon.png` & `apple-icon.png`

*Jika file-file di atas belum disalin, fungsi seperti buka-tutup dropdown profil, toggle menu mobile, dan scrollbar sidebar tidak akan merespons klik pengguna.*

---

## 3. Peta dan Deskripsi Struktur Direktori

### A. Direktori `resources/views/`
```text
resources/views/
├── components/                 # Komponen UI modular yang dapat digunakan berulang
│   ├── layout.blade.php        # Wrapper HTML utama (head, meta, link css, slot body, script js)
│   ├── plugins.blade.php       # Floating settings panel (pengaturan warna sidebar & dark mode)
│   ├── footers/
│   │   ├── auth.blade.php      # Footer di dalam dashboard pengguna
│   │   └── guest.blade.php     # Footer untuk halaman publik / login
│   └── navbars/
│       ├── sidebar.blade.php   # Sidebar menu navigasi vertikal di sisi kiri
│       └── navs/
│           ├── auth.blade.php  # Bar navigasi atas (breadcrumbs, search box, profile & notifikasi)
│           └── guest.blade.php # Bar navigasi atas sederhana untuk halaman tamu
│
├── dashboard/
│   └── index.blade.php         # Halaman utama: kartu statistik (KPI), grafik Chart.js, & tabel ringkas
│
├── pages/                      # Katalog referensi layout halaman
│   ├── tables.blade.php        # Contoh tabel: daftar data dengan status badge & aksi edit
│   ├── billing.blade.php       # Contoh kartu informasi, riwayat invoice, & transaksi
│   ├── notifications.blade.php # Contoh alert, pop-up pesan, dan toast
│   ├── profile.blade.php       # Contoh kartu profil pengguna, foto cover, & daftar proyek
│   ├── rtl.blade.php           # Template tata letak Right-to-Left (opsional)
│   └── laravel-examples/
│       ├── user-management.blade.php # Contoh tabel CRUD pengelolaan user
│       └── user-profile.blade.php    # Contoh form edit profil pengguna
│
├── register/
│   └── create.blade.php        # Form pendaftaran akun baru
│
├── sessions/
│   ├── create.blade.php        # Form login akun
│   └── password/
│       ├── reset.blade.php     # Form request link reset password
│       └── verify.blade.php    # Form verifikasi token reset password
│
└── errors/                     # Halaman status HTTP (401, 403, 404, 419, 429, 500, 503)
```

---

## 4. Arsitektur & Konsep Blade Component

Template ini memanfaatkan paradigma **Laravel Blade Component** modern:

### 1. Tag Komponen `<x-...>`
Alih-alih menggunakan `@extends('layouts.app')` dan `@section('content')`, template membungkus tampilan dengan tag komponen:
```blade
<x-layout bodyClass="...">
    <!-- Seluruh isi halaman diletakkan di sini -->
</x-layout>
```

### 2. Slot (`{{ $slot }}`)
Pada `layout.blade.php`, variabel `{{ $slot }}` berfungsi sebagai penampung konten apa pun yang Anda letakkan di dalam `<x-layout> ... </x-layout>`.

### 3. Props (`@props([...])`)
Komponen dapat menerima parameter dinamis:
* Pada `layout.blade.php`: `@props(['bodyClass'])`
  * Dashboard: `bodyClass="g-sidenav-show bg-gray-200"`
  * Login/Register: `bodyClass="bg-gray-200"`
* Pada `sidebar.blade.php`: `@props(['activePage'])`
  * Menentukan menu mana yang diberi status aktif (gradasi warna menyala):
    `activePage="attendances"`, `activePage="dashboard"`, dll.
* Pada `navs.auth.blade.php`: `@props(['titlePage'])`
  * Menentukan judul halaman pada breadcrumb navigasi atas:
    `titlePage="Presensi Pegawai"`.

### 4. Stack Script (`@push('js')` dan `@stack('js')`)
Jika suatu halaman membutuhkan pustaka JavaScript khusus (misal Chart.js atau Leaflet peta TPDK), script ditaruh di dalam blok `@push('js')`:
```blade
@push('js')
<script>
    console.log("Script ini hanya berjalan pada halaman ini!");
</script>
@endpush
```

---

## 5. Tutorial Praktis: Membuat Halaman UI Baru

Berikut adalah template kode siap pakai untuk membuat halaman baru, misalnya **Daftar Presensi Pegawai** di `resources/views/attendances/index.blade.php`:

```blade
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <!-- 1. Menampilkan Sidebar (aktifkan menu presensi) -->
    <x-navbars.sidebar activePage="attendances"></x-navbars.sidebar>

    <!-- 2. Kontainer Utama -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar Atas -->
        <x-navbars.navs.auth titlePage="Data Presensi Pegawai"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            
            <!-- BAGIAN 1: KARTU REKAPITULASI (METRIC CARDS) -->
            <div class="row mb-4">
                <!-- Kartu Hadir -->
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">check_circle</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Hadir Hari Ini</p>
                                <h4 class="mb-0">128</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">92% </span>Tingkat kehadiran</p>
                        </div>
                    </div>
                </div>

                <!-- Kartu Terlambat -->
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">schedule</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Terlambat</p>
                                <h4 class="mb-0">8</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0 text-secondary text-sm">Toleransi s/d 08:00 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Kartu Izin / Cuti -->
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">flight_takeoff</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Cuti / Izin</p>
                                <h4 class="mb-0">4</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0 text-secondary text-sm">Disetujui atasan</p>
                        </div>
                    </div>
                </div>

                <!-- Kartu Tanpa Keterangan -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">cancel</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Alpha</p>
                                <h4 class="mb-0">0</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0 text-secondary text-sm">Status terkonfirmasi</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BAGIAN 2: TABEL DATA PRESENSI -->
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 px-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3 mb-0">Catatan Kehadiran Harian Pegawai</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-white mb-0">Export Excel</button>
                                    <button class="btn btn-sm btn-white mb-0">+ Input Manual</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pegawai</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jam Masuk</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jam Pulang</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lokasi / TPDK</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-3 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Ahmad Fauzi, S.Kom</h6>
                                                        <p class="text-xs text-secondary mb-0">NIP: 199008122018021002</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">07:42:15 WIB</p>
                                                <span class="text-xxs text-success"><i class="fa fa-check"></i> Tepat Waktu</span>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">16:30:10 WIB</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success">Hadir</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">TPDK Kec. Sukmajaya</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Detail presensi">
                                                    <i class="material-icons text-sm">visibility</i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Halaman -->
            <x-footers.auth></x-footers.auth>
        </div>
    </main>

    <!-- Panel Pengaturan Tema -->
    <x-plugins></x-plugins>
</x-layout>
```

---

## 6. Kustomisasi Menu Navigasi (Sidebar)

File: `resources/views/components/navbars/sidebar.blade.php`

Sesuaikan menu agar selaras dengan route yang sudah ada di `routes/web.php` (Presensi, Cuti, Logbook, TPDK, Pengguna):

```blade
<ul class="navbar-nav">
    <!-- Header Bagian Utama -->
    <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Menu Utama</h6>
    </li>

    <!-- 1. Dashboard -->
    <li class="nav-item">
        <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-primary' : '' }}"
            href="{{ route('dashboard') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
        </a>
    </li>

    <!-- 2. Presensi Pegawai -->
    <li class="nav-item">
        <a class="nav-link text-white {{ $activePage == 'attendances' ? ' active bg-gradient-primary' : '' }}"
            href="{{ route('attendances.index') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">fact_check</i>
            </div>
            <span class="nav-link-text ms-1">Presensi Pegawai</span>
        </a>
    </li>

    <!-- 3. Pengajuan Cuti / Izin -->
    <li class="nav-item">
        <a class="nav-link text-white {{ $activePage == 'leaves' ? ' active bg-gradient-primary' : '' }}"
            href="{{ route('leaves.index') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">event_busy</i>
            </div>
            <span class="nav-link-text ms-1">Pengajuan Cuti</span>
        </a>
    </li>

    <!-- 4. Logbook Harian -->
    <li class="nav-item">
        <a class="nav-link text-white {{ $activePage == 'logbooks' ? ' active bg-gradient-primary' : '' }}"
            href="{{ route('logbooks.index') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">menu_book</i>
            </div>
            <span class="nav-link-text ms-1">Logbook Harian</span>
        </a>
    </li>

    <!-- Header Bagian Master Data -->
    <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Master Data</h6>
    </li>

    <!-- 5. Data TPDK -->
    <li class="nav-item">
        <a class="nav-link text-white {{ $activePage == 'tpdks' ? ' active bg-gradient-primary' : '' }}"
            href="{{ route('tpdks.index') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">location_city</i>
            </div>
            <span class="nav-link-text ms-1">Data TPDK</span>
        </a>
    </li>

    <!-- 6. Manajemen Pengguna -->
    <li class="nav-item">
        <a class="nav-link text-white {{ $activePage == 'users' ? ' active bg-gradient-primary' : '' }}"
            href="{{ route('setup.users.index') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">manage_accounts</i>
            </div>
            <span class="nav-link-text ms-1">Pengguna & Role</span>
        </a>
    </li>
</ul>
```

---

## 7. Cheat Sheet Desain UI (Kamus Kelas CSS)

### A. Palet Gradasi Warna
Gunakan pada header card, tombol, icon shape, atau badge:
* `bg-gradient-primary` : Magenta / Ungu khas Material Design
* `bg-gradient-success` : Hijau (untuk status hadir, simpan, sukses)
* `bg-gradient-warning` : Oranye (untuk status peringatan, terlambat, pending)
* `bg-gradient-danger`  : Merah (untuk hapus, batal, alpha)
* `bg-gradient-info`    : Biru Muda (untuk info, detail, catatan)
* `bg-gradient-dark`    : Hitam Elegan (untuk navigasi dan kartu netral)

### B. Anatomi Header Melayang (*Floating Card Header*)
Ciri khas utama template ini adalah header kartu yang melayang ke atas:
```html
<div class="card">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 px-3">
            <h6 class="text-white mb-0">Judul Card</h6>
        </div>
    </div>
    <div class="card-body">
        <!-- Konten card -->
    </div>
</div>
```
* `mt-n4`: Margin top minus 4 (mengangkat header ke atas melebihi batas body kartu).
* `z-index-2`: Memastikan header berada di lapisan terdepan.
* `border-radius-lg`: Membuat sudut header melengkung serasi dengan kartu.

### C. Badge Status
```html
<span class="badge badge-sm bg-gradient-success">Hadir</span>
<span class="badge badge-sm bg-gradient-warning">Izin</span>
<span class="badge badge-sm bg-gradient-danger">Alpha</span>
```

### D. Ikon Google Material
Cukup panggil nama icon di dalam tag `<i>`:
```html
<i class="material-icons">dashboard</i>
<i class="material-icons">person</i>
<i class="material-icons">schedule</i>
<i class="material-icons">check_circle</i>
<i class="material-icons">location_on</i>
<i class="material-icons">settings</i>
```

---

## 8. Langkah Tindak Lanjut

1. **Lengkapi Aset Script & Gambar**:
   Salin folder `core/` dan `plugins/` ke `public/assets/js/`, serta folder `img/` ke `public/assets/img/`.
2. **Kustomisasi Sidebar**:
   Ganti link dan icon pada `resources/views/components/navbars/sidebar.blade.php`.
3. **Mulai Susun View Presensi**:
   Gunakan struktur contoh di Bab 5 untuk membuat tampilan index, form pengajuan cuti, dan laporan logbook.
