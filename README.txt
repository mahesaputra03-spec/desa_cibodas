SISTEM DATA KEPENDUDUKAN DESA CIBODAS
======================================

Isi:
- Login perangkat desa
- Dashboard data kependudukan
- Data penduduk: KK, NIK, nama, agama, jenis kelamin, tempat/tanggal lahir, RT/RW,
  pekerjaan, pendidikan, status perkawinan, golongan darah
- Penduduk datang, pindah, meninggal, dan baru lahir
- Tambah/edit/hapus data penduduk
- Pencarian data
- Cetak / Simpan data penduduk sebagai PDF dari browser

LOGIN AWAL
Username: Desa cibodas
Password: sabilulungan2026

CARA MEMASANG DI XAMPP (Windows)
1. Install dan buka XAMPP.
2. Jalankan Apache dan MySQL.
3. Ekstrak folder "desa_cibodas" ke:
   C:\xampp\htdocs\
4. Buka http://localhost/phpmyadmin
5. Klik tab Import, pilih:
   C:\xampp\htdocs\desa_cibodas\database\desa_cibodas.sql
6. Klik Go/Import.
7. Buka:
   http://localhost/desa_cibodas/
8. Login dengan akun di atas.

PDF
Pada halaman Data Penduduk, klik tombol PDF. Browser akan membuka halaman laporan.
Pilih "Print/Cetak", lalu pilih "Save as PDF/Simpan sebagai PDF".

CATATAN PENTING
- Sistem ini memakai MySQL dan PHP.
- Jangan membuka sistem ke internet tanpa HTTPS, firewall, backup, dan kontrol akses.
- Karena NIK/KK adalah data pribadi, gunakan hanya untuk petugas yang berwenang.
- Sebelum dipakai produksi, ganti password akun awal dan buat akun per perangkat desa.
- Jika password database MySQL root Anda memakai password, ubah DB_PASS di config.php.
