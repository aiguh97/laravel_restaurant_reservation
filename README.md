# 🍴 RestoGuh - Integrated POS & Restaurant Management System

**RestoGuh** adalah platform manajemen restoran berbasis Laravel 11 yang mencakup sistem Point of Sales (POS), manajemen inventaris, reservasi meja, hingga pelaporan keuangan. Sistem ini dilengkapi dengan keamanan ganda (2FA) dan integrasi penyimpanan cloud MinIO.

---

## 🚀 Fitur Utama
* **Authentication & Security**: Dukungan JWT/Sanctum untuk API, Google OAuth, dan Two-Factor Authentication (2FA) via Email.
* **POS (Point of Sales)**: Manajemen Produk, Kategori, dan Meja.
* **Order Workflow**: Pemisahan alur pesanan untuk Kasir, Pelanggan, dan Dapur (*Kitchen*).
* **Reservation System**: Pengelolaan reservasi meja secara real-time.
* **Reporting**: Summary penjualan harian, produk terlaris, dan laporan tutup kasir.
* **Storage Integration**: Mendukung penyimpanan file S3-Compatible (MinIO).

---

## 🛠️ Dokumentasi API (Endpoints)

Base URL: `http://teguhdev.space/api`

### 1. Authentication
| Method | Endpoint | Deskripsi | Status |
| :--- | :--- | :--- | :--- |
| `POST` | `/login` | Login user & mendapatkan token | Public |
| `POST` | `/register` | Registrasi user baru | Public |
| `POST` | `/auth/google` | Login melalui Google Account | Public |
| `POST` | `/2fa/verify` | Verifikasi kode OTP 2FA | Public |
| `POST` | `/logout` | Menghapus session/token | Auth |

### 2. Product & Category
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/products` | List semua produk |
| `POST` | `/products` | Tambah produk baru |
| `PATCH` | `/products/{id}` | Update data produk |
| `GET` | `/categories` | List semua kategori |
| `GET` | `/list-categories` | List kategori singkat untuk dropdown |

### 3. Orders & Kitchen
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `POST` | `/orders` | Membuat pesanan baru |
| `GET` | `/my-orders` | Riwayat pesanan user saat ini |
| `GET` | `/admin/orders` | Semua data pesanan (Admin) |
| `GET` | `/kitchen/orders` | Monitoring pesanan untuk tim Dapur |
| `PATCH` | `/orders/{id}/status` | Update status pesanan (Pending/Ready/Done) |

### 4. Tables & Reservations
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/tables` | List status ketersediaan meja |
| `POST` | `/reservations` | Membuat reservasi meja baru |

---

## 🖥️ Dokumentasi Web (Admin Dashboard)

Dashboard Admin dapat diakses melalui browser untuk manajemen data master.

### Alur Kerja Utama:
1.  **Login**: User masuk melalui `/login`. Jika 2FA aktif, user diarahkan ke `/2fa-challenge`.
2.  **Dashboard**: Ringkasan performa restoran di `/home`.
3.  **User Management**: Pengelolaan hak akses karyawan melalui `/user`.
4.  **Product Management**: Pengelolaan menu dan stok melalui `/product`.
5.  **Settings**: Pengaturan profil dan aktivasi 2FA melalui `/settings/2fa`.

---

## ☁️ Integrasi MinIO (S3 Storage)

Konfigurasi S3 di file `.env`:

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=ST0ZLWJKZILF0RF0SALD
AWS_SECRET_ACCESS_KEY=ix7cY+E+THMFlYad5VfgG6x+nx9gH4xGjvYEAoEA
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=restoguh
AWS_ENDPOINT=http://minio.teguhdev.space:9000
AWS_URL=http://minio.teguhdev.space:9000/restoguh
AWS_USE_PATH_STYLE_ENDPOINT=true


## 📸 Screenshots Interface
```

Minio
<!-- | :---: | :---: | -->
[Minio](screenshoots/minio.png) 

Dashboard Admin 
<!-- | :---: | :---: | -->
[Dashboard](screenshoots/dashboard.png) 

Dashboard Admin 
<!-- | :---: | :---: | -->
[Dashboard](screenshoots/product.png) 
