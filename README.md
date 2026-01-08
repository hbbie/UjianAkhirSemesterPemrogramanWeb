# UjianAkhirSemesterPemrogramanWeb
## TugasUjiansemesterAkhirPertemuan16PemrogramanWeb

# Nama : Dhani Naufal Habibie
# Kelas : TI.24.A4
# NIM : 312410300
# Tanggal : 8-01-2026 (Kamis)
# Mata Kuliah : Pemrograman Web 1
# Dosen : Agung Nugroho

<img width="1191" height="676" alt="image" src="https://github.com/user-attachments/assets/ca31a5f5-a5a9-454f-87fe-32c04ff852dd" />


# LAPORAN PRAKTIKUM: PENGEMBANGAN APLIKASI SHOWROOM AUTOPREMIUM
# 1. Deskripsi Umum

Aplikasi AutoPremium adalah sistem manajemen katalog mobil berbasis web yang dibangun menggunakan PHP dan MySQL. Aplikasi ini menerapkan konsep modularitas dan desain responsif menggunakan Framework Bootstrap 5 untuk memenuhi standar aplikasi modern yang ramah perangkat seluler (mobile-first).

# 2. Implementasi Fitur Utama

Berdasarkan persyaratan yang diberikan, berikut adalah fungsionalitas yang berjalan:

    Sistem Login Multi-role: Memisahkan hak akses antara Admin (kendali penuh CRUD) dan User (akses baca katalog) menggunakan session PHP.

    Fungsi CRUD: Admin dapat menambah unit baru (tambah.php), memperbarui data (edit.php), serta menghapus unit (hapus.php).

    Filter Pencarian: Pengguna dapat mencari mobil berdasarkan Merk atau Model secara real-time melalui bar pencarian.

    Pagination: Katalog menampilkan data secara bertahap (2 unit per halaman) untuk mengoptimalkan performa pemuatan data.

    Desain Responsif: Menggunakan Bootstrap 5 untuk memastikan tampilan tetap proporsional di berbagai ukuran layar.

# 3. Analisis Fungsi yang Berjalan
# A. Autentikasi dan Otorisasi (Login)

Fungsi ini memverifikasi kredensial pengguna dari tabel users. Setelah berhasil, sistem menyimpan role ke dalam session untuk mengatur hak akses fitur secara dinamis di halaman utama.
# B. Algoritma Pencarian dan Pagination

Program menangkap input pencarian melalui metode GET dan mengintegrasikannya ke dalam query SQL menggunakan klausa LIKE. Secara bersamaan, sistem menghitung offset berdasarkan halaman yang aktif untuk menampilkan data yang sesuai melalui limitasi SQL.

# C. Pengelolaan Data dan File

Fungsi ini menangani penyimpanan informasi teks dan unggahan gambar mobil ke direktori lokal server. Program memanggil nama file gambar dari database untuk ditampilkan pada elemen kartu katalog.

# 4. Hasil Pengujian

Berdasarkan pengujian yang dilakukan:

    Halaman Index berhasil menampilkan data mobil (contoh: BMW dan Honda) dengan format kartu yang rapi.

    Sistem memberikan pesan error informatif jika terjadi kegagalan koneksi database atau tabel tidak ditemukan.

    Tombol aksi (Edit/Hapus) muncul secara otomatis hanya ketika login sebagai Admin.

# 5. Kesimpulan dan Saran
# Kesimpulan

    Aplikasi berhasil memenuhi seluruh syarat praktikum, termasuk konsep OOP, Modularitas, dan implementasi fitur CRUD yang stabil.

    Penggunaan session terbukti efektif dalam membatasi hak akses antara Admin dan User secara aman.

Saran

    Keamanan: Disarankan menggunakan enkripsi password_hash() untuk keamanan data pengguna yang lebih baik.

    Interaktivitas: Menambahkan library JavaScript (seperti SweetAlert) untuk notifikasi proses CRUD agar tampilan lebih modern.
