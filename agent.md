# AGENTS.md
# PROJECT: VIRTUAL LABORATORY – LABORATORIUM KELAS VIRTUAL

## 1. PROJECT OVERVIEW

Project ini adalah website Laboratorium Kelas Virtual berbasis Laravel yang bertujuan menyediakan media pembelajaran dan simulasi praktikum sains secara digital.

Website memiliki tiga laboratorium utama:
1. Laboratorium Fisika
2. Laboratorium Kimia
3. Laboratorium Biologi

Pengguna dapat mempelajari materi, melakukan eksperimen virtual, mengikuti panduan praktikum, mengerjakan evaluasi, dan melihat hasil pembelajaran melalui website.

AI Agent harus mengembangkan project ini sebagai aplikasi web yang modern, interaktif, responsif, mudah digunakan, dan memiliki struktur kode yang rapi.

## 2. TECHNOLOGY STACK

Gunakan teknologi berikut:

- Backend: Laravel (gunakan versi yang sudah terpasang di project).
- Programming Language: PHP.
- Frontend: Blade Template.
- Styling: Tailwind CSS atau Bootstrap (ikuti teknologi yang sudah digunakan).
- JavaScript: Vanilla JavaScript.
- Database: MySQL.
- Authentication: Laravel Authentication.
- ORM: Eloquent ORM.
- Architecture: Model-View-Controller (MVC).

Jangan mengganti teknologi utama project tanpa alasan teknis yang kuat.

## 3. USER ROLES

Aplikasi memiliki dua jenis pengguna utama:

### A. Administrator
Administrator bertanggung jawab mengelola seluruh sistem.

Fitur:
- Login administrator.
- Dashboard administrator.
- Mengelola data pengguna.
- Mengelola kelas laboratorium.
- Mengelola materi pembelajaran.
- Mengelola eksperimen virtual.
- Mengelola panduan praktikum.
- Mengelola soal dan kuis.
- Melihat hasil praktikum dan nilai siswa.

### B. Siswa
Siswa merupakan pengguna utama laboratorium virtual.

Fitur:
- Registrasi dan login.
- Melihat dashboard siswa.
- Memilih laboratorium.
- Membaca materi pembelajaran.
- Melakukan eksperimen virtual.
- Mengikuti instruksi praktikum.
- Mengerjakan kuis atau evaluasi.
- Melihat hasil praktikum.
- Melihat riwayat aktivitas pembelajaran.

## 4. MAIN MODULES

Website wajib memiliki tiga modul utama.

### A. LABORATORIUM FISIKA

Fokus pembelajaran:
- Gerak dan gaya.
- Hukum Newton.
- Energi dan usaha.
- Listrik dan magnet.
- Gelombang dan bunyi.
- Optik.

Contoh simulasi:
- Simulasi gerak benda.
- Simulasi hukum Newton.
- Simulasi rangkaian listrik.
- Simulasi bandul sederhana.
- Simulasi pemantulan cahaya.

Fitur:
- Materi teori.
- Tujuan praktikum.
- Alat dan bahan virtual.
- Langkah eksperimen.
- Area simulasi interaktif.
- Hasil pengamatan.
- Kesimpulan praktikum.

### B. LABORATORIUM KIMIA

Fokus pembelajaran:
- Struktur atom.
- Tabel periodik.
- Ikatan kimia.
- Larutan dan konsentrasi.
- Asam dan basa.
- Reaksi kimia.

Contoh simulasi:
- Simulasi pencampuran larutan.
- Simulasi indikator asam dan basa.
- Simulasi reaksi kimia.
- Simulasi pengukuran pH.
- Simulasi perubahan warna zat.

Fitur:
- Materi teori.
- Pengenalan alat laboratorium.
- Alat dan bahan virtual.
- Langkah eksperimen.
- Area simulasi interaktif.
- Hasil pengamatan.
- Kesimpulan praktikum.

Catatan keselamatan:
Simulasi kimia harus bersifat edukatif dan virtual. Jangan memberikan instruksi eksperimen berbahaya atau penggunaan bahan kimia berisiko tanpa prosedur keselamatan yang sesuai.

### C. LABORATORIUM BIOLOGI

Fokus pembelajaran:
- Struktur sel.
- Jaringan tumbuhan dan hewan.
- Sistem organ manusia.
- Mikroorganisme.
- Ekosistem.
- Genetika.

Contoh simulasi:
- Pengamatan sel menggunakan mikroskop virtual.
- Identifikasi organel sel.
- Pengamatan jaringan tumbuhan.
- Simulasi sistem pencernaan.
- Simulasi ekosistem.

Fitur:
- Materi teori.
- Gambar dan ilustrasi biologi.
- Alat laboratorium virtual.
- Langkah pengamatan.
- Area simulasi interaktif.
- Hasil pengamatan.
- Kesimpulan praktikum.

## 5. WEBSITE FEATURES

### A. Landing Page
Halaman utama harus memiliki:
- Navbar.
- Hero section.
- Deskripsi platform.
- Pengenalan tiga laboratorium.
- Keunggulan website.
- Cara menggunakan laboratorium.
- Call to action.
- Footer.

### B. Authentication
- Register siswa.
- Login siswa.
- Login administrator.
- Logout.
- Validasi form.
- Proteksi halaman berdasarkan role.

### C. Dashboard Siswa
Menampilkan:
- Selamat datang.
- Ringkasan aktivitas belajar.
- Daftar laboratorium.
- Praktikum yang tersedia.
- Riwayat praktikum.
- Progress pembelajaran.

### D. Dashboard Administrator
Menampilkan:
- Total pengguna.
- Total materi.
- Total eksperimen.
- Total praktikum yang diselesaikan.
- Statistik aktivitas siswa.
- Menu pengelolaan data.

### E. Modul Praktikum
Setiap praktikum harus memiliki:
- Judul praktikum.
- Kategori laboratorium.
- Deskripsi.
- Tujuan praktikum.
- Materi teori.
- Alat dan bahan virtual.
- Langkah-langkah praktikum.
- Simulasi interaktif.
- Form hasil pengamatan.
- Kesimpulan.
- Tombol selesai praktikum.

### F. Evaluasi
- Kuis pilihan ganda.
- Pertanyaan berdasarkan materi.
- Penilaian otomatis.
- Penyimpanan nilai.
- Riwayat hasil evaluasi.

## 6. DATABASE STRUCTURE

Rancang database menggunakan migration Laravel.

Tabel utama yang direkomendasikan:

### users
- id
- name
- email
- password
- role
- created_at
- updated_at

### laboratories
- id
- name
- slug
- description
- image
- created_at
- updated_at

### materials
- id
- laboratory_id
- title
- description
- content
- image
- created_at
- updated_at

### experiments
- id
- laboratory_id
- material_id
- title
- description
- objectives
- instructions
- simulation_type
- created_at
- updated_at

### experiment_results
- id
- user_id
- experiment_id
- observation
- conclusion
- score
- status
- completed_at
- created_at
- updated_at

### quizzes
- id
- laboratory_id
- title
- description
- created_at
- updated_at

### questions
- id
- quiz_id
- question
- option_a
- option_b
- option_c
- option_d
- correct_answer
- created_at
- updated_at

### quiz_results
- id
- user_id
- quiz_id
- score
- created_at
- updated_at

Buat foreign key, relationship Eloquent, validasi, dan indexing yang sesuai.

Jangan menyimpan password dalam bentuk teks biasa.

## 7. UI/UX DESIGN GUIDELINES

Gunakan desain modern, bersih, profesional, dan bertema teknologi pendidikan.

Panduan desain:
- Responsive untuk desktop, tablet, dan mobile.
- Navigasi sederhana dan intuitif.
- Layout konsisten.
- Card dengan sudut membulat.
- Shadow yang halus.
- Typography mudah dibaca.
- Ikon yang konsisten.
- Animasi sederhana.
- Loading state dan empty state.
- Notifikasi sukses dan error.

Warna identitas setiap laboratorium:

Fisika:
- Biru sebagai warna utama.
- Menggambarkan teknologi, energi, dan sains.

Kimia:
- Ungu atau hijau sebagai warna utama.
- Menggambarkan reaksi dan eksperimen.

Biologi:
- Hijau sebagai warna utama.
- Menggambarkan kehidupan dan alam.

Jangan membuat tampilan terlalu ramai.

Prioritaskan pengalaman pengguna dan kemudahan navigasi.

## 8. CODING STANDARDS

Ikuti standar berikut:

1. Gunakan struktur MVC Laravel.
2. Gunakan migration untuk pengelolaan database.
3. Gunakan Eloquent ORM.
4. Gunakan route yang terorganisasi.
5. Gunakan Controller untuk mengelola logika aplikasi.
6. Gunakan Blade Components untuk komponen yang berulang.
7. Pisahkan frontend dan backend dengan struktur yang jelas.
8. Gunakan validasi Laravel pada setiap form.
9. Gunakan middleware untuk proteksi akses.
10. Hindari duplikasi kode.
11. Gunakan nama variabel dan fungsi yang mudah dipahami.
12. Gunakan CSRF protection.
13. Terapkan authorization berdasarkan role.
14. Jangan menaruh password, API key, atau credential di dalam source code.

Jangan menulis seluruh aplikasi dalam satu file.

## 9. PROJECT FOLDER STRUCTURE

Ikuti struktur standar Laravel dan organisasikan file sebagai berikut:

app/
  Models/
    User.php
    Laboratory.php
    Material.php
    Experiment.php
    ExperimentResult.php
    Quiz.php
    Question.php
    QuizResult.php

  Http/
    Controllers/
      Admin/
      Student/
      LaboratoryController.php
      ExperimentController.php
      QuizController.php

    Middleware/

resources/
  views/
    layouts/
    components/
    landing/
    auth/
    admin/
    student/
    laboratories/
      physics/
      chemistry/
      biology/
    experiments/
    quizzes/

routes/
  web.php

database/
  migrations/
  seeders/

public/
  images/
  assets/

Catatan: Sesuaikan struktur dengan standar Laravel dan kondisi project yang sudah tersedia.

## 10. SIMULATION DEVELOPMENT

Simulasi merupakan fitur utama website.

Ketentuan:
- Simulasi harus dapat digunakan langsung melalui browser.
- Gunakan JavaScript untuk interaksi.
- Tampilan simulasi harus responsif.
- Berikan instruksi penggunaan.
- Tampilkan hasil eksperimen secara jelas.
- Gunakan visualisasi, animasi, grafik, atau objek interaktif jika diperlukan.
- Pastikan hasil simulasi konsisten dengan konsep ilmiah yang diajarkan.
- Jangan membuat tombol simulasi yang hanya menjadi dekorasi.

Setiap simulasi minimal memiliki:
1. Area simulasi.
2. Kontrol interaksi.
3. Instruksi penggunaan.
4. Hasil atau output simulasi.
5. Tombol reset.

## 11. SECURITY

Keamanan aplikasi wajib diperhatikan.

- Gunakan Laravel Authentication.
- Gunakan password hashing.
- Terapkan CSRF protection.
- Validasi semua input.
- Batasi akses halaman administrator.
- Gunakan authorization untuk data pengguna.
- Hindari SQL Injection.
- Hindari XSS.
- Jangan memperlihatkan data pribadi siswa kepada pengguna lain.
- Lindungi endpoint dan operasi CRUD.

## 12. DEVELOPMENT WORKFLOW

AI Agent wajib mengikuti tahapan berikut:

PHASE 1 — PROJECT ANALYSIS
- Periksa struktur project.
- Identifikasi versi Laravel.
- Periksa dependency.
- Periksa database.
- Jangan menghapus file existing tanpa alasan.

PHASE 2 — FOUNDATION
- Siapkan struktur database.
- Buat migration.
- Buat model dan relationship.
- Buat authentication.
- Buat role administrator dan siswa.

PHASE 3 — UI DEVELOPMENT
- Buat landing page.
- Buat dashboard siswa.
- Buat dashboard administrator.
- Buat halaman laboratorium.

PHASE 4 — CORE FEATURES
- Implementasikan materi pembelajaran.
- Implementasikan praktikum.
- Implementasikan simulasi.
- Implementasikan evaluasi.
- Implementasikan penyimpanan hasil.

PHASE 5 — TESTING
- Uji registrasi dan login.
- Uji hak akses.
- Uji CRUD.
- Uji seluruh simulasi.
- Uji penyimpanan database.
- Uji responsive design.
- Perbaiki bug yang ditemukan.

PHASE 6 — FINALIZATION
- Pastikan semua fitur berfungsi.
- Pastikan tidak ada halaman kosong.
- Pastikan tidak ada tombol yang tidak berfungsi.
- Pastikan tampilan konsisten.
- Dokumentasikan cara instalasi dan menjalankan project.

## 13. AI AGENT RULES

Ketika mengerjakan project ini, AI Agent wajib:

1. Memahami struktur project sebelum melakukan perubahan.
2. Tidak mengubah teknologi utama tanpa persetujuan.
3. Tidak menghapus fitur yang sudah berfungsi.
4. Tidak membuat fitur hanya sebagai tampilan tanpa fungsi backend.
5. Tidak menggunakan data dummy sebagai pengganti fitur database permanen.
6. Membuat kode yang bersih dan mudah dikembangkan.
7. Menggunakan komponen yang dapat digunakan kembali.
8. Menjaga konsistensi desain seluruh halaman.
9. Memastikan setiap fitur dapat diuji.
10. Memperbaiki error sebelum melanjutkan ke fitur berikutnya.
11. Memberikan penjelasan singkat setiap perubahan penting.
12. Tidak mengklaim fitur selesai sebelum benar-benar diuji.
13. Mengutamakan implementasi yang realistis dan dapat dijalankan.

Jika terdapat informasi yang belum ditentukan, gunakan keputusan teknis yang paling sederhana, aman, dan sesuai tujuan project.

## 14. FINAL PROJECT GOAL

Hasil akhir project harus berupa website Laboratorium Kelas Virtual berbasis Laravel yang memiliki:

- Landing page profesional.
- Authentication siswa dan administrator.
- Dashboard sesuai role.
- Laboratorium Fisika.
- Laboratorium Kimia.
- Laboratorium Biologi.
- Materi pembelajaran.
- Simulasi praktikum interaktif.
- Hasil pengamatan praktikum.
- Kuis dan evaluasi.
- Penyimpanan data menggunakan MySQL.
- Tampilan responsive.
- Sistem yang aman dan mudah dikembangkan.

PRIORITAS UTAMA:

Bangun aplikasi yang benar-benar berfungsi, bukan sekadar prototype tampilan.

Fokus pada pengalaman belajar interaktif, simulasi eksperimen yang edukatif, dan kemudahan penggunaan bagi siswa.

Project harus memiliki kualitas yang layak untuk didemonstrasikan dalam kompetisi Hackathon.
