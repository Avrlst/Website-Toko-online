# 🌱 GrowGarden — Toko Tanaman Online (E-Commerce Web)

Aplikasi web *e-commerce* penjualan tanaman hias dan perlengkapan berkebun yang dirancang dan dibangun secara mandiri menggunakan **Laravel** (arsitektur MVC), **MySQL**, dan **Tailwind CSS**. Proyek ini mencakup alur transaksi pelanggan hingga pengelolaan katalog inventaris oleh administrator.

---

## 🌟 Fitur Utama

- **Sistem Otentikasi Pengguna**: Fitur registrasi dan login yang aman dengan pembagian hak akses (*role*) antara pembeli dan administrator.
- **Katalog & Kategori Tanaman**: Penjelajahan produk berdasarkan pengelompokan kategori tanaman dengan tampilan antarmuka responsif berbasis Tailwind CSS.
- **Keranjang Belanja (*Shopping Cart*)**: Pengelolaan item belanja secara dinamis (tambah produk, ubah kuantitas, hapus item) yang terintegrasi langsung dengan basis data relasional MySQL.
- **Admin Dashboard & Manajemen Inventaris**: Panel kontrol intuitif untuk mengunggah produk baru (*product uploader*), mengatur kategori, memperbarui stok tanaman secara *real-time*, serta memantau pesanan.

---

## 🛠️ Teknologi yang Digunakan

- **Backend Framework**: Laravel (PHP)
- **Database**: MySQL (Relational Database)
- **Frontend Styling**: Tailwind CSS, Blade Templating
- **Tools & Environment**: Composer, Laragon / PHP Local Server, Git

---

## 📁 Struktur Direktori Utama

```text
├── app/
│   ├── Http/Controllers/    # Logika bisnis (Auth, Produk, Keranjang, Admin Dashboard)
│   └── Models/              # Model Eloquent & relasi database (User, Product, Category, Cart)
├── database/
│   ├── migrations/          # Skema tabel relasional MySQL
│   └── seeders/             # Data awal kategori & akun admin
├── resources/
│   └── views/               # Antarmuka pengguna & admin berbasis Blade + Tailwind CSS
└── routes/
    └── web.php              # Definisi routing aplikasi web

🚀 Cara Menjalankan Proyek (Lokal)
 * Clone repositori ini:
   git clone [https://github.com/Avrlst/growgarden.git](https://github.com/Avrlst/growgarden.git)
cd growgarden

 * Instal dependensi PHP dan Frontend:
   composer install
npm install && npm run build

 * Konfigurasi file environment:
   Salin file .env.example menjadi .env, lalu sesuaikan pengaturan koneksi database MySQL kamu (DB_DATABASE, DB_USERNAME, DB_PASSWORD):
   cp .env.example .env
php artisan key:generate

 * Jalankan migrasi database:
   php artisan migrate --seed

 * Jalankan server pengembangan lokal:
   php artisan serve

   Akses aplikasi melalui browser di http://127.0.0.1:8000.
👤 Pengembang
Avrilistianto Ananda Nabil
 * GitHub: @Avrlst
 * Portofolio: avrilistianto-portofolio.vercel.app

---

### Cara Memasang ke Repositori GitHub:

1. Buka repositori **GrowGarden** di akun GitHub `@Avrlst` (atau jalankan melalui terminal di folder proyek Laravel lokal kamu).
2. Jika melalui browser: klik **Add file** > **Create new file** (atau edit file `README.md` yang sudah ada), tempel kode di atas, lalu klik **Commit changes**.
3. Jika melalui terminal PowerShell di folder proyek:
   ```powershell
   git add README.md
   git commit -m "docs: add README.md for GrowGarden e-commerce"
   git push origin main

