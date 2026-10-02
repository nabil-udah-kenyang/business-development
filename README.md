# Business Development HMPS MI

<p align="center">
  <img src="./public/image/platform-logo-20261002093604-ncjoWI.webp" alt="Business Development HMPS MI" width="180">
</p>

<p align="center">
  Platform marketplace mahasiswa untuk memperkenalkan produk, jasa, toko, dan barang preloved mahasiswa POLMED dalam satu tempat.
</p>

<p align="center">
  <a href="https://www.php.net/"><img alt="PHP" src="https://img.shields.io/badge/Language-PHP_8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white"></a>
  <a href="https://laravel.com/"><img alt="Laravel" src="https://img.shields.io/badge/Framework-Laravel_12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white"></a>
  <a href="https://www.mysql.com/"><img alt="MySQL" src="https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white"></a>
  <a href="https://tailwindcss.com/"><img alt="Tailwind CSS" src="https://img.shields.io/badge/Styling-Tailwind_CSS-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white"></a>
  <a href="https://vite.dev/"><img alt="Vite" src="https://img.shields.io/badge/Build_Vite-7-646CFF?style=for-the-badge&logo=vite&logoColor=white"></a>
  <a href="https://alpinejs.dev/"><img alt="Alpine.js" src="https://img.shields.io/badge/Frontend-Alpine.js-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white"></a>
  <a href="https://pestphp.com/"><img alt="Pest" src="https://img.shields.io/badge/Testing-Pest-111827?style=for-the-badge&logo=php&logoColor=white"></a>
</p>

---

## Overview

`Business Development HMPS MI` adalah platform marketplace mahasiswa yang dirancang untuk membantu mahasiswa POLMED mempromosikan produk, jasa, toko, dan barang preloved.

Project ini dibuat untuk kebutuhan lomba dengan alur bisnis sederhana: pengguna dapat mendaftarkan akun, membuat katalog, mengelola toko, dan menghubungi penjual melalui WhatsApp. Superadmin dapat mengelola katalog, kategori, pengguna, promosi, pengaturan platform, dan statistik pengunjung.

## Features

- Katalog produk dan jasa UMKM mahasiswa.
- Katalog barang preloved.
- Halaman detail produk dan toko.
- Registrasi dan login dengan peran seller atau preloved.
- Dashboard seller untuk mengelola toko dan produk.
- Upload logo toko, foto sampul, dan foto produk.
- Kontak penjual melalui WhatsApp.
- Verifikasi email dan reset password.
- Panel superadmin untuk moderasi produk, kategori, pengguna, promosi, dan pengaturan platform.
- Sitemap, robots.txt, metadata SEO, dan statistik pengunjung.
- Responsive layout dengan dark mode.

## Requirements & Setup

Sebelum menjalankan project, pastikan laptop sudah memiliki:

- PHP 8.2 atau lebih baru.
- Composer.
- Node.js 20.19+ atau 22.12+ dan npm.
- XAMPP atau Laragon dengan MySQL aktif.
- Git.
- Ekstensi PHP `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `tokenizer`, dan `xml` aktif.

### 1. Clone repository

```bash
git clone https://github.com/nabil-udah-kenyang/business-development.git
cd business-development
```

### 2. Install dependency backend

```bash
composer install
```

### 3. Buat file environment

Linux/macOS/Git Bash:

```bash
cp .env.example .env
```

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Pastikan koneksi database di `.env` mengarah ke MySQL lokal:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=business_development
DB_USERNAME=root
DB_PASSWORD=
```

Jika membutuhkan isi `.env` lengkap silakan DM WhatsApp Mas Nabil untuk memintanya. 

### 4. Generate key dan jalankan migration

```bash
php artisan key:generate
php artisan migrate
php artisan storage:link
```

Saat MySQL aktif tetapi database `business_development` belum tersedia, Laravel akan menampilkan pilihan untuk membuat database secara otomatis. Pilih `Yes`. Akun MySQL yang digunakan harus memiliki izin untuk membuat database.

### 5. Install frontend dan jalankan aplikasi

```bash
npm install
composer run dev
```

Buka `http://127.0.0.1:8000` di browser.

### Keunggulan `composer run dev`

Dengan satu perintah, Composer menjalankan beberapa proses development sekaligus:

- `php artisan serve` untuk web server Laravel.
- `php artisan queue:listen` untuk memproses queue.
- `php artisan pail` untuk melihat log secara realtime.
- `npm run dev` untuk Vite dan hot reload asset frontend.

Jadi tidak perlu membuka beberapa terminal secara manual. Hentikan seluruh proses dengan `Ctrl+C`.

## License

Project ini dibuat untuk kebutuhan pembelajaran dan kompetisi Business Development HMPS MI.
