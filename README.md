# 📌 SISTEM INFORMASI PEMESANAN MAKANAN - LOKALICIOUS
Aplikasi pemesanan makanan berbasis web menggunakan Laravel + MySQL
Dengan panel admin untuk monitoring dan pengelolaan sistem


# 👥 ROLE PENGGUNA
1. Admin
   - Akses penuh untuk mengatur produk, user, pesanan, dan metode pembayaran
2. User
   - Melakukan pemesanan makanan, melihat status pesanan, dan melakukan pembayaran


# 🔐 FITUR AUTENTIKASI
✔ Login
✔ Register
✔ Logout
✔ Kontrol akses role dengan middleware

-----------------------------------------------------------
# 🔥 Dark Mode
Tersedia toggle tema (dark & light mode)
Disimpan pada localStorage agar tetap konsisten saat reload


# 🍽 FITUR USER (PELANGGAN)
1️⃣ Lihat daftar menu makanan/minuman  
2️⃣ Tambah barang ke keranjang  
3️⃣ Checkout pesanan  
4️⃣ Pilih metode pembayaran  
5️⃣ Lihat status pesanan (Pending / Diproses / Selesai)  

Endpoint utama:
- /products
- /cart
- /orders


# 🛠 FITUR ADMIN PANEL
✔ Dashboard ringkasan data
✔ Kelola produk
✔ Kelola user
✔ Kelola metode pembayaran
✔ Kelola pesanan (ubah status + hapus)

-----------------------------------------------------------
## ➤ Admin - Kelola Produk
- Tambah menu
- Edit menu
- Hapus menu
- Upload gambar menu


-----------------------------------------------------------
## ➤ Admin - Monitoring Pesanan
Admin dapat:
✔ Melihat daftar pesanan beserta itemnya  
✔ Ubah status pesanan  
✔ Hapus pesanan  

Contoh status:
- pending
- processing / diproses
- completed / selesai
- cancelled


-----------------------------------------------------------
## ➤ Admin - Kelola User & Role
Mengatur role:
- admin
- user

Admin dapat menghapus user tertentu

===========================================================
# 💳 Metode Pembayaran
Data dikelola oleh admin

Contoh model:
- transfer_bank
- ewallet_dana
- ewallet_ovo
- cod (cash on delivery)


===========================================================
# 📊 Dashboard Admin
Menampilkan informasi penting:
- Total produk
- Total pesanan
- Total user
- Statistik transaksi terbaru

===========================================================
# 🗂 STRUKTUR TABEL PENTING

Tabel users:
(id, name, email, password, role)

Tabel products:
(id, name, price, description, image)

Tabel orders:
(id, user_id, total_price, status, payment_method_id)

Tabel order_items:
(id, order_id, product_id, quantity, price)

Tabel payment_methods:
(id, name, code)

===========================================================
# ✨ FLOW SISTEM PEMESANAN

User memilih produk ➝ masuk keranjang ➝ checkout ➝  
User pilih metode pembayaran ➝ pesanan tersimpan ➝  
Admin cek & ubah status pesanan ➝ pesanan selesai

===========================================================
# 💻 TEKNOLOGI YANG DIGUNAKAN

Backend:
- Laravel 10

Frontend:
- Blade Template
- TailwindCSS
- Dark Mode (LocalStorage JS)

Database:
- MySQL

Auth:
- Laravel Breeze / UI Auth (disesuaikan)

===========================================================
# 🚀 Cara Menjalankan Proyek

1️⃣ Clone project
git clone https://github.com/aidilsaputrakirsan-classroom/final-project-cloud-computing-a-cc-kelompok-2-esteh.git
cd lokalicious

2️⃣ Install dependencies
composer install
npm install
npm run build

3️⃣ Buat file environment
cp .env.example .env

4️⃣ Generate Key
php artisan key:generate

5️⃣ Migrasi database
php artisan migrate --seed

6️⃣ Jalankan server
php artisan serve

===========================================================
# 👑 AKUN DEFAULT (contoh)
Admin:
email : admin@lokalicious.com
password : admin123

User:
email : user@lokalicious.com
password : user123

===========================================================
# 📌 STATUS
✔ Semua fitur yang diminta sudah selesai
✔ Sistem siap untuk demo dan pengembangan lebih lanjut

===========================================================

**Developed by ESTEH Team for Sistem Informasi Institut Teknologi Kalimantan** *Last updated: November 2025*