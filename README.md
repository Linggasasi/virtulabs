# VirtuLabs

Virtual Laboratory adalah aplikasi Laravel untuk mendukung pembelajaran Fisika, Kimia, dan Biologi melalui katalog laboratorium kelas virtual.

## Teknologi

- Laravel 13 dan PHP 8.3+
- Blade, Tailwind CSS 4, dan JavaScript
- PostgreSQL

## Menyiapkan aplikasi

1. Pasang dependency PHP dan JavaScript:

   ```bash
   composer install
   npm install
   ```

2. Buat konfigurasi lokal dan application key:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Isi konfigurasi PostgreSQL di `.env`. Buat database `virtulabs` dan role aplikasi non-superuser `virtulabs_app` dengan `LOGIN`, hak `CONNECT` pada database, serta hak `USAGE` dan `CREATE` pada schema `public`. Isi password role hanya di `.env`; jangan commit file tersebut.

4. Buat schema dan katalog laboratorium resmi:

   ```bash
   php artisan migrate --seed
   ```

   Seeder hanya menambahkan tiga kategori Fisika, Kimia, dan Biologi jika belum ada. Seeder tidak membuat akun atau aktivitas pembelajaran contoh. Hindari `migrate:fresh` pada database yang berisi data.

5. Build asset dan jalankan aplikasi:

   ```bash
   npm run build
   php artisan serve
   ```

   Untuk pengembangan frontend, jalankan `npm run dev` di terminal terpisah.

## Akun dan role

Registrasi publik membuat akun siswa. Untuk memberi role administrator kepada akun yang sudah terdaftar, jalankan:

```bash
php artisan users:assign-role nama@contoh.com admin
```

Role yang didukung adalah `admin` dan `student`. Perintah ini tidak membuat akun atau mengubah password. Administrator terakhir tidak dapat diturunkan rolenya. Login menggunakan halaman `/login`; dashboard dialihkan sesuai role.

## Dashboard dan konten pembelajaran

Administrator dapat mengelola akun di `/admin/users`, menambah dan memperbarui materi di `/admin/materials`, serta mengelola panduan eksperimen di `/admin/experiments`. Penghapusan konten tidak disediakan agar riwayat pembelajaran yang sudah tercatat tidak hilang. Siswa melihat progres pada dashboard dan dapat membuka materi serta panduan melalui halaman laboratorium.

## Pengujian

```bash
php artisan test
```

Test suite menggunakan database SQLite in-memory agar tidak mengubah data PostgreSQL lokal.
