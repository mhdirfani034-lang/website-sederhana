# Ruang Kampus

Portal akademik sederhana berbasis Laravel 12 untuk melihat ringkasan kampus dan mengelola data mahasiswa.

## Kebutuhan

- PHP 8.2 atau lebih baru
- Composer 2
- Ekstensi PHP `pdo_sqlite` (atau driver database lain yang dipilih)

## Menjalankan aplikasi

```sh
composer install
```

Salin `.env.example` menjadi `.env`. Dengan PowerShell di Windows:

```powershell
if (!(Test-Path .env)) { Copy-Item .env.example .env }
if (!(Test-Path database/database.sqlite)) { New-Item -ItemType File -Path database/database.sqlite }
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Konfigurasi bawaan menggunakan SQLite. Buka `http://127.0.0.1:8000`. Beranda menampilkan ringkasan langsung dari database. Halaman **Data mahasiswa** menyediakan pencarian berdasarkan NIM/nama/program studi, pagination, tambah, edit, dan hapus data. Formulir memvalidasi NIM serta email unik dan tahun angkatan 2000–2100.

Untuk mengisi ulang data contoh, jalankan `php artisan db:seed`; seeder aman dijalankan berulang kali tanpa membuat data duplikat.

## Pengujian

```sh
php artisan test
```

## Skema data mahasiswa

Migration `create_mahasiswa_table` membuat tabel `mahasiswa` yang menyimpan NIM, nama, program studi, tahun angkatan, email opsional, dan timestamp. Migration dapat dibatalkan dengan `php artisan migrate:rollback`.
