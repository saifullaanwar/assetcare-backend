# AssetCare - Backend API System

Sistem Manajemen & Perawatan Aset Perusahaan berbasis Laravel 12 dengan autentikasi API (Laravel Sanctum), pengingat servis berkala otomatis, dan analisis statistik pengeluaran.

## 🚀 Fitur Utama

- **F1 - Autentikasi & Proteksi Akun:** Register, Login, Logout, dan User Info (`/me`) berbasis Token Bearer (Sanctum).
- **F2 - Kelola Kategori, Lokasi & Perangkat (Asset CRUD):** Manajemen Master Data kategori, lokasi gedung, serta inventaris aset/kendaraan lengkap dengan nomor seri/plat.
- **F3 - Pencatatan Riwayat Servis:** Logging data perawatan, detail tindakan, teknisi, dan biaya servis.
- **F4 - Indikator & Pengingat Servis Berkala:** Notifikasi otomatis via email log untuk jadwal servis H-3 dan Hari-H melalui Task Scheduler.
- **F5 - Dasbor Ringkasan Pengeluaran:** API statistik & analitik ringkasan pengeluaran perawatan aset per kategori.

---

## 🛠️ Tech Stack

- **Framework:** Laravel 12
- **Database:** PostgreSQL
- **Authentication:** Laravel Sanctum
- **Notification Driver:** Log Driver (`MAIL_MAILER=log`)

---

## ⚙️ Panduan Instalasi & Jalankan Backend

1. **Setup Environment:**
   Pastikan file `.env` sudah terkonfigurasi dengan database PostgreSQL kamu.
2. **Install Dependencies & Generate Key:**
   ```bash
   composer install
   php artisan key:generate
   ```
3. **Jalankan Database Migration:**
   ```bash
   php artisan migrate
   ```
4. **Jalankan Development Server:**
   ```bash
   php artisan serve
   ```

---

## ⏰ Menjalankan Fitur Pengingat Service (F4)

Untuk menguji pengiriman notifikasi pengingat service secara manual, jalankan perintah:
```bash
php artisan app:send-service-reminder
```
*Hasil draf email notifikasi akan otomatis tercatat pada file `storage/logs/laravel.log`.*

---

## 📊 Detail Metrik Analytics Dashboard (F5)

Endpoint `GET /api/dashboard` menyajikan data agregasi berikut untuk konsumsi Frontend:
- `total_assets`: Jumlah akumulasi seluruh aset terdaftar.
- `assets_by_status`: Sebaran status aset (`available`, `in_use`, `maintenance`, `disposed`).
- `total_maintenance_cost`: Total pengeluaran biaya perawatan aset.
- `cost_per_category`: Breakdown total biaya perawatan berdasarkan kategori perangkat.
- `recent_maintenances`: 5 transaksi riwayat servis/perawatan terbaru beserta relasi aset, kategori, dan lokasi.

---

## 📡 Ringkasan Endpoint API

| Modul | Method | Endpoint | Deskripsi |
| :--- | :--- | :--- | :--- |
| **Auth** | `POST` | `/api/register` | Registrasi user baru |
| **Auth** | `POST` | `/api/login` | Login & dapatkan Bearer Token |
| **Auth** | `GET` | `/api/me` | Cek info user aktif |
| **Auth** | `POST` | `/api/logout` | Revoke token / Logout |
| **Categories** | `GET/POST/PUT/DELETE` | `/api/categories` | CRUD Master Data Kategori |
| **Locations** | `GET/POST/PUT/DELETE` | `/api/locations` | CRUD Master Data Lokasi |
| **Assets** | `GET/POST/PUT/DELETE` | `/api/assets` | CRUD Data Aset & Perangkat |
| **Maintenances** | `GET/POST/PUT/DELETE` | `/api/maintenances` | CRUD Log Riwayat Perawatan |
| **Dashboard** | `GET` | `/api/dashboard` | API Summary Analytics & Agregasi (F5) |