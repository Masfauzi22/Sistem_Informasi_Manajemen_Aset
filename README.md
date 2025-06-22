# ✨ Sistem Manajemen Aset (Studi Kasus Pelindo Surabaya) ✨

Selamat datang di repositori **Sistem Manajemen Aset** ini! 👋

Proyek ini adalah bagian dari portofolio saya, sebuah inisiatif digital yang dirancang untuk merevolusi pengelolaan aset, dengan mengambil **studi kasus Pelindo Surabaya**. Saya berupaya menciptakan solusi yang:
🚀 **Terintegrasi:** Menghubungkan berbagai aspek manajemen aset dalam satu platform.
⚡ **Efisien:** Mengoptimalkan alur kerja dan mengurangi beban manual.
🛡️ **Andal:** Memastikan data aset akurat dan sistem berjalan stabil.

---

### 🚀 Cara Menjalankan Proyek Ini (Setup Lokal)

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan pengembangan lokal Anda:

1.  **Clone Repositori:**
    Buka Terminal atau Command Prompt dan unduh proyek ini:
    ```bash
    git clone https://github.com/Masfauzi22/pelindo_asset_management.git
    ```

2.  **Masuk ke Direktori Proyek:**
    ```bash
    cd pelindo_asset_management
    ```

3.  **Install Dependensi PHP (Composer):**
    Pastikan Anda memiliki Composer terinstal.
    ```bash
    composer install
    ```

4.  **Siapkan File Environment (.env):**
    Ini adalah file konfigurasi penting.
    ```bash
    cp .env.example .env
    # Jika di Windows dan 'cp' tidak berfungsi, coba:
    # copy .env.example .env
    ```

5.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

6.  **Konfigurasi Database:**
    * Buka file `.env` yang baru dibuat.
    * Sesuaikan kredensial database ( `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, dll.) agar sesuai dengan pengaturan database lokal Anda (misalnya MySQL).
    * **Penting:** Pastikan Anda sudah membuat database kosong dengan nama yang sesuai di phpMyAdmin atau tool database Anda (contoh: `pelindo_asset_management_db`).

7.  **Jalankan Migrasi Database:**
    Ini akan membuat semua tabel database yang diperlukan.
    ```bash
    php artisan migrate
    ```

8.  **(Opsional) Jalankan Seeder Database:**
    Jika ada data awal atau dummy yang perlu dimasukkan ke database:
    ```bash
    php artisan db:seed
    ```

9.  **Install Dependensi Frontend (Node.js & npm/Yarn):**
    Pastikan Anda memiliki Node.js dan npm terinstal.
    ```bash
    npm install
    # Atau jika menggunakan Yarn: yarn install
    ```

10. **Jalankan Vite (Frontend Assets):**
    Ini akan mengkompilasi aset frontend dan menjalankan server Vite untuk pengembangan.
    ```bash
    npm run dev
    ```

11. **Jalankan Server Pengembangan Laravel:**
    ```bash
    php artisan serve
    ```
    Aplikasi akan tersedia di `http://127.0.0.1:8000` (atau port lain yang ditampilkan).

---

### 💡 Kolaborasi & Manfaat Bersama

> Proyek ini dikembangkan sebagai bentuk portofolio pribadi dan dengan harapan dapat memberikan **manfaat serta inspirasi** bagi siapa saja yang tertarik di bidang manajemen aset atau pengembangan aplikasi, khususnya dengan studi kasus yang relevan dengan industri pelabuhan.
>
> Saya sangat terbuka untuk diskusi, berbagi ide, atau jika Anda memiliki pertanyaan seputar implementasi kode ini. Mari belajar dan berkembang bersama!
>
> **Jika Anda ingin memahami lebih dalam source code ini, berdiskusi, atau berkolaborasi, silakan hubungi saya:**
> 📲 **WhatsApp: 0823-3742-8199**
> *(Atau melalui GitHub issues/discussions di repositori ini)*

---

### 🛠️ Teknologi yang Kami Gunakan:

Proyek ini dibangun dengan fondasi teknologi modern untuk performa dan skalabilitas terbaik:
* **PHP 🐘:** Bahasa pemrograman utama.
* **Laravel 💖:** Framework PHP yang robust dan elegan.
* **MySQL 🗄️:** Sistem manajemen database relasional.
* **Tailwind CSS 🎨:** Framework CSS utility-first untuk desain responsif dan cepat.
* **Vite ⚡:** Modern frontend build tool untuk pengembangan yang cepat.
* **JavaScript 🌐:** Untuk interaktivitas di sisi klien.

---

Terima kasih atas kunjungan Anda dan semoga bermanfaat! 🙏
