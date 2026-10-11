# AssetCare - Backend API System

Sistem Manajemen & Perawatan Aset Perusahaan berbasis Laravel 11 dengan autentikasi API (Laravel Sanctum), pengingat servis berkala otomatis, dan analisis statistik pengeluaran.

## 🚀 Fitur Utama

- **F1 - Autentikasi & Proteksi Akun:** Register, Login, Logout, dan User Info (`/me`) berbasis Token Bearer (Sanctum).
- **F2 - Kelola Kategori, Lokasi & Perangkat (Asset CRUD):** Manajemen Master Data kategori, lokasi gedung, serta inventaris aset/kendaraan lengkap dengan nomor seri/plat.
- **F3 - Pencatatan Riwayat Servis:** Logging data perawatan, detail tindakan, teknisi, dan biaya servis.
- **F4 - Indikator & Pengingat Servis Berkala:** Notifikasi otomatis via email log untuk jadwal servis H-3 dan Hari-H melalui Task Scheduler.
- **F5 - Dasbor Ringkasan Pengeluaran:** Ringkasan statistik total aset, sebaran status, total pengeluaran, serta breakdown biaya per kategori.

---

## 🛠️ Tech Stack

- **Framework:** Laravel 11
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **Notification Driver:** Log Driver (`MAIL_MAILER=log`)

---

## ⚙️ Panduan Instalasi & Jalankan Backend

1. **Setup Environment:**
   Pastikan file `.env` sudah terkonfigurasi dengan database MySQL kamu.
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
| **Dashboard** | `GET` | `/api/dashboard` | API Summary Analytics & Agregasi |