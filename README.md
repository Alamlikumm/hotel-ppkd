# Hotel PPKD 🏨

Sistem Informasi Manajemen Hotel berbasis web yang dikembangkan menggunakan **Laravel 13** dan **PHP 8.4**.

## 📋 Persyaratan Sistem (Requirements)

- **PHP** >= 8.4.1
- **Composer**
- **Node.js** & **NPM** (v20+)
- **Database** (MySQL / SQLite / PostgreSQL)

---

## 🚀 Panduan Instalasi Lokal (Local Development)

1. **Clone Repository**
   ```bash
   git clone https://github.com/Alamlikumm/hotel-ppkd.git
   cd hotel-ppkd
   ```

2. **Install Dependencies (PHP & Node.js)**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Buka file `.env` dan sesuaikan koneksi database (DB_DATABASE, DB_USERNAME, dll).*

4. **Jalankan Migrasi Database**
   ```bash
   php artisan migrate
   ```

5. **Build Assets & Jalankan Server Lokal**
   ```bash
   npm run build
   php artisan serve
   ```
   Akses aplikasi di: `http://localhost:8000`

---

## 🌐 Panduan Deployment Otomatis (CI/CD ke cPanel)

Repository ini sudah dikonfigurasi menggunakan **GitHub Actions** untuk melakukan *deployment* (upload) otomatis via FTP ke server Hostdata / cPanel setiap kali ada perubahan yang di-push ke branch `main`.

### Konfigurasi GitHub Secrets
Untuk mengaktifkan auto-deploy, pastikan variabel rahasia ini sudah terisi di repository GitHub (`Settings` > `Secrets and variables` > `Actions`):
- `FTP_SERVER` : Alamat server FTP (contoh: `ftp.domainanda.com` atau IP server).
- `FTP_USERNAME` : Username FTP khusus yang diarahkan ke folder aplikasi.
- `FTP_PASSWORD` : Password FTP.

### ⚠️ PENTING: Langkah Manual di Server
Agar upload FTP via GitHub Actions berjalan super cepat dan stabil (hanya hitungan detik), folder `vendor/` dan `storage/` **dikecualikan** dari upload otomatis. 

Oleh karena itu, di server cPanel Anda harus melakukan hal ini secara manual **(Cukup 1x Saja saat pertama kali deploy)**:

1. **Buat Folder Storage**
   Lewat cPanel File Manager, pastikan folder-folder kosong ini sudah ada di dalam root aplikasi Anda:
   - `storage/app`
   - `storage/framework/cache`
   - `storage/framework/sessions`
   - `storage/framework/views`
   - `storage/logs`
   - `bootstrap/cache`

2. **Install Vendor (Composer)**
   Buka **Terminal** di cPanel Anda, masuk ke direktori website Anda (misal `cd domains/domainanda.com/public_html/hotel`), lalu jalankan:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

Setelah 2 langkah manual di atas dilakukan, maka untuk deploy selanjutnya (setiap kali Anda ngoding dan nge-push) aplikasi akan otomatis ter-update di server tanpa perlu repot lagi! 🚀
