# System Analysis & Database Design — GrowGarden

Dokumen ini memuat spesifikasi analisis kebutuhan sistem, pemodelan alur proses bisnis (Use Case Diagram, Activity Diagram, dan Flowchart), serta arsitektur skema database relasional untuk platform *e-commerce* tanaman hias **GrowGarden**.

---

## 1. Deskripsi & Ruang Lingkup Sistem

**GrowGarden** adalah platform *e-commerce* berbasis **Laravel**, **PHP**, **MySQL**, dan **Tailwind CSS** yang dirancang untuk mempermudah penjualan tanaman hias, bibit, dan pupuk secara daring, sekaligus menyediakan sistem manajemen inventaris, banner promosi, dan verifikasi pembayaran bagi pengelola toko.

### Pembagian Aktor & Hak Akses
* **Customer (Pelanggan):** Dapat melakukan registrasi, login/logout, menjelajahi halaman utama dan katalog tanaman, melihat detail spesifikasi serta panduan perawatan (`care`), mengelola keranjang belanja (`carts`), melakukan *checkout* pesanan (`orders`), mengunggah bukti pembayaran (`payment_proof`), serta memberikan rating dan ulasan produk (`reviews`).
* **Admin (Pengelola Toko):** Memiliki hak akses ke halaman dashboard administratif (`is_admin = 1`) untuk mengelola data pengguna (`users`), kategori dan produk tanaman (`categories`, `products`), banner halaman utama (`sliders`), memverifikasi bukti pembayaran dan status pemesanan (`orders`), serta memantau laporan transaksi penjualan.

---

## 2. Kebutuhan Fungsional (Functional Requirements)

| Kode | Modul Sistem | Spesifikasi Kebutuhan Fungsional |
| :--- | :--- | :--- |
| **FR-01** | Autentikasi & Otorisasi | Sistem menyediakan fitur registrasi, login, dan logout dengan validasi peran menggunakan atribut `is_admin` dan `role`. |
| **FR-02** | Manajemen Katalog & Banner | Admin dapat mengelola data kategori (`categories`), produk tanaman (`products`), dan slider promosi (`sliders`). |
| **FR-03** | Keranjang Belanja | Customer terautentikasi dapat menambahkan produk ke dalam `carts` dan mengatur kuantitas item sebelum transaksi. |
| **FR-04** | Pemrosesan Pesanan (*Checkout*) | Sistem membuat nomor transaksi unik (`order_number`), menyimpan informasi pengiriman pelanggan, dan menghitung `total_price`. |
| **FR-05** | Konfirmasi & Verifikasi Pembayaran | Customer mengunggah bukti pembayaran (`payment_proof`); Admin memvalidasi transaksi dan memperbarui status pesanan (`pending`, `paid`, `shipped`, `completed`). |
| **FR-06** | Ulasan & Rating Produk | Customer dapat memberikan penilaian (`rating` 1–5) dan komentar ulasan (`reviews`) pada produk yang tersedia. |

---

## 3. Pemodelan Sistem (UML & Flowchart)

### 3.1 Use Case Diagram
Memetakan batasan sistem (*system boundary*) serta pembagian fitur antara aktor **Customer**, **Admin**, dan **Akses Bersama** (Login/Logout).

![Use Case Diagram GrowGarden](./diagrams/use-case-diagram.png)

* **Fitur Customer:** Registrasi, Melihat Halaman Utama & Katalog, Memilih Tanaman & Detail Perawatan, Mengelola Keranjang Belanja, Membeli Tanaman / Checkout, Mengunggah Bukti Pembayaran, dan Memberikan Ulasan Produk.
* **Fitur Admin:** Mengelola User, Mengelola Kategori & Produk, Mengelola Slider / Banner, Mengelola Pemesanan & Verifikasi Bayar, dan Mengelola Laporan Transaksi.

---

### 3.2 Activity Diagram — Pengelolaan Produk (Admin)
Menggambarkan alur interaksi antara aktor **Admin** dan **Sistem** saat melakukan autentikasi dashboard hingga proses validasi dan penyimpanan data produk tanaman baru.

![Activity Diagram Kelola Produk](./diagrams/activity-kelola-produk.png)

---

### 3.3 Flowchart Sistem — Alur Belanja Customer
Menjelaskan alur logika prosedural dari titik awal pengguna membuka situs **GrowGarden**, pengecekan kepemilikan akun, validasi ketersediaan stok tanaman, hingga konfirmasi unggah bukti pembayaran.

![Flowchart Sistem GrowGarden](./diagrams/flowchart-sistem.png)

---

## 4. Perancangan Database (Entity Relationship Diagram)

Arsitektur database **GrowGarden** dibangun di atas **MySQL** dengan **8 tabel inti** yang telah dinormalisasi hingga tahap **Third Normal Form (3NF)** untuk menjaga integritas referensial dan mencegah redundansi data.

![Entity Relationship Diagram GrowGarden](./diagrams/erd-database.png)

### Keputusan Arsitektur Database
1. **Resolusi Relasi Many-to-Many (`order_items` & `carts`):** Hubungan antara `orders` dan `products` dipecah menggunakan tabel transaksional `order_items`, sedangkan keranjang pengguna dikelola melalui tabel `carts` dengan *foreign key* `user_id` dan `product_id`.
2. **Preservasi Harga Transaksi (`price` pada `order_items`):** Menyimpan salinan harga satuan saat pesanan dibuat agar perubahan harga katalog pada tabel `products` di masa mendatang tidak memengaruhi riwayat nota transaksi lama.
3. **Fleksibilitas Checkout (`orders`):** Tabel `orders` menyimpan atribut pengiriman secara eksplisit (`customer_name`, `customer_phone`, `customer_address`) beserta kode invoice unik (`order_number`) dan path bukti transfer (`payment_proof`).
4. **Manajemen Konten Dinamis (`sliders` & `reviews`):** Memisahkan entitas promosi halaman depan (`sliders`) dan penilaian pengguna (`reviews`) agar struktur katalog utama (`products`) tetap ramping.

---

## 5. Kamus Data (Data Dictionary)

### 1. Tabel `users`
| Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PK, AUTO_INCREMENT` | ID unik pengguna |
| `name` | `VARCHAR(255)` | `NOT NULL` | Nama lengkap pengguna |
| `email` | `VARCHAR(255)` | `UNIQUE, NOT NULL` | Email unik untuk autentikasi |
| `role` | `VARCHAR(255)` | `DEFAULT 'user'` | Label peran pengguna |
| `email_verified_at` | `TIMESTAMP` | `NULLABLE` | Waktu verifikasi email |
| `password` | `VARCHAR(255)` | `NOT NULL` | Kata sandi terenkripsi (Bcrypt) |
| `is_admin` | `TINYINT(1)` | `DEFAULT 1` | Flag otorisasi administrator (`1` = Admin, `0` = Customer) |

### 2. Tabel `categories`
| Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PK, AUTO_INCREMENT` | ID unik kategori |
| `name` | `VARCHAR(255)` | `NOT NULL` | Nama kategori (Tanaman, Bibit, Pupuk, Tanaman Hias) |
| `slug` | `VARCHAR(255)` | `UNIQUE, NOT NULL` | Slug URL kategori |
| `image` | `VARCHAR(255)` | `NULLABLE` | Path gambar sampul kategori |

### 3. Tabel `products`
| Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PK, AUTO_INCREMENT` | ID unik produk |
| `category_id` | `BIGINT UNSIGNED` | `FK -> categories(id)` | Relasi kategori produk (`ON DELETE CASCADE`) |
| `name` | `VARCHAR(255)` | `NOT NULL` | Nama produk tanaman |
| `slug` | `VARCHAR(255)` | `UNIQUE, NOT NULL` | Slug URL produk |
| `price` | `DECIMAL(12,2)` | `NOT NULL` | Harga satuan produk (IDR) |
| `stock` | `INT` | `NOT NULL` | Jumlah ketersediaan stok |
| `description` | `TEXT` | `NOT NULL` | Deskripsi lengkap produk |
| `care` | `TEXT` | `NULLABLE` | Panduan perawatan tanaman |
| `image` | `VARCHAR(255)` | `NOT NULL` | Path foto utama produk |

### 4. Tabel `carts`
| Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PK, AUTO_INCREMENT` | ID unik item keranjang |
| `user_id` | `BIGINT UNSIGNED` | `FK -> users(id)` | Pemilik keranjang (`ON DELETE CASCADE`) |
| `product_id` | `BIGINT UNSIGNED` | `FK -> products(id)` | Produk yang dipilih (`ON DELETE CASCADE`) |
| `quantity` | `INT` | `DEFAULT 1` | Jumlah kuantitas item |

### 5. Tabel `orders`
| Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PK, AUTO_INCREMENT` | ID unik pesanan |
| `order_number` | `VARCHAR(255)` | `UNIQUE, NOT NULL` | Nomor invoice transaksi (contoh: `INV-BZPNZM`) |
| `customer_name` | `VARCHAR(255)` | `NOT NULL` | Nama penerima pesanan |
| `customer_phone` | `VARCHAR(255)` | `NOT NULL` | Nomor telepon penerima |
| `customer_address` | `TEXT` | `NOT NULL` | Alamat lengkap tujuan pengiriman |
| `total_price` | `DECIMAL(12,2)` | `NOT NULL` | Total nilai transaksi (IDR) |
| `status` | `ENUM` | `DEFAULT 'pending'` | Status pesanan (`pending`, `paid`, `shipped`, `completed`) |
| `payment_proof` | `VARCHAR(255)` | `NULLABLE` | Path file gambar bukti pembayaran |

### 6. Tabel `order_items`
| Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PK, AUTO_INCREMENT` | ID unik detail item pesanan |
| `order_id` | `BIGINT UNSIGNED` | `FK -> orders(id)` | Referensi header pesanan (`ON DELETE CASCADE`) |
| `product_id` | `BIGINT UNSIGNED` | `FK -> products(id)` | Referensi produk yang dibeli (`ON DELETE CASCADE`) |
| `quantity` | `INT` | `NOT NULL` | Jumlah unit yang dibeli |
| `price` | `DECIMAL(12,2)` | `NOT NULL` | Harga satuan saat transaksi tercatat |

### 7. Tabel `reviews`
| Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PK, AUTO_INCREMENT` | ID unik ulasan |
| `user_id` | `BIGINT UNSIGNED` | `FK -> users(id)` | Pengguna pemberi ulasan (`ON DELETE CASCADE`) |
| `product_id` | `BIGINT UNSIGNED` | `FK -> products(id)` | Produk yang diulas (`ON DELETE CASCADE`) |
| `rating` | `INT` | `DEFAULT 5` | Skor penilaian (skala 1–5) |
| `comment` | `TEXT` | `NOT NULL` | Isi komentar ulasan pelanggan |

### 8. Tabel `sliders`
| Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PK, AUTO_INCREMENT` | ID unik banner slider |
| `title` | `VARCHAR(255)` | `NULLABLE` | Judul utama banner |
| `subtitle` | `VARCHAR(255)` | `NULLABLE` | Subjudul atau keterangan promosi |
| `image` | `VARCHAR(255)` | `NOT NULL` | Path file gambar banner |
| `order` | `INT` | `DEFAULT 0` | Urutan tampilan slider |
| `is_active` | `TINYINT(1)` | `DEFAULT 1` | Status aktif banner (`1` = Aktif, `0` = Nonaktif) |