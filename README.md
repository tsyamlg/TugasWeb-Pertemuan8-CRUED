# TugasWeb-Pertemuan8-CRUD — Aplikasi CRUD Inventaris

Aplikasi CRUD Inventaris Barang menggunakan **PHP Native + PDO + MySQL**.

## Fitur
- Create, Read, Update, Delete data barang
- JOIN tabel `barang` dengan `kategori`
- Pencarian barang (nama / kode)
- Keamanan: prepared statements, sanitasi output (`htmlspecialchars`), validasi input, token CSRF
- Desain database ter-normalisasi (3NF) dengan Foreign Key

## Screenshot
| Daftar Barang | Tambah Barang | Edit Barang |
|---|---|---|
| ![index](screenshots/index.png) | ![create](screenshots/create.png) | ![edit](screenshots/edit.png) |

## Langkah Import Database
1. Jalankan **XAMPP/Laragon**, aktifkan **Apache** dan **MySQL**.
2. Buka `http://localhost/phpmyadmin`.
3. Klik tab **Import** → pilih file `schema.sql` → klik **Go**.
   (Database `db_inventaris` beserta tabel & data contoh akan dibuat otomatis.)
4. Sesuaikan user/password MySQL di `config/database.php` bila perlu.

## Cara Menjalankan
1. Salin folder proyek ke `htdocs` (XAMPP) atau `www` (Laragon).
2. Buka `http://localhost/TugasWeb-Pertemuan8-CRUD/` di browser.

## Struktur Database
- `kategori (id, nama_kategori)`
- `barang (id, kode_barang, nama_barang, kategori_id → kategori.id, jumlah, harga, created_at)`