# BotBelanja.com_Client
sample code to show how to utilize API botbelanja.com


BotBelanja.com adalah layanan Software As A services, Membantu identifikasi catatan daftar belanja menjadi invoice,
data invoice berupa nama produk dan harga didapat dari data produk yang anda setorkan kepada kami.

BotBelanja.com menyediakan source code gratis yang dapat anda gunakan untuk memanfaatkan API dari BotBelanja.com
BotBelanja.com mendukung anda pemilik toko untuk memiliki infrastruktur vps hosting sendiri. VPS hosting diperlukan
untuk meletakkan aplikasi backend chatbot, aplikasi back office order management dan database transaksi pelanggan anda.

BotBelanja.com tidak menyimpan data pelanggan anda. BotBelanja.com hanya membantu mengidentifikasi catatan belanja pelanggan anda
mejadi invoice sesuai data inventory produk yang anda jual.

Untuk mendapatkan layanan ini, anda 

1. Memiliki vps cloud hosting sendiri
2. Memiliki akses WA gateway
3. Mendaftar dan memiliki saldo di Saas BotBelanja.com
4. Cloning source code dan database ini ke server vps anda sendiri

Setelah semua ini dijalankan, kini toko anda selangkah lebih maju, anda memiliki whatsapp bot, telegram bot, website
yang dapat menerima order dari pelanggan, hanya dengan melakukan 1,2 atau puluhan entry item daftar belanja.
Kini belanja bisa lebih cepat dan mudah.

Fungsi source code ini.
1. Aplikasi Back Office Order Management
2. Aplikasi backend untuk whatsapp bot
3. Aplikasi backend untuk telegram bot

Fungsi masing-masing folder
1. folder dashboard , adalah apps backoffice order management, disini anda bisa mengelola order yang masuk, memasukkan data produk, update dan edit data produk
2. folder mysql, adalah script mysql yang dapat anda generate di server database mysql anda.
3. folder test_API, adalah tempat belajar untuk menggunakan API dari BotBelanja.com
4. folder webhook_fonnte adalah tempat aplikasi backend whatsapp bot, anda harus memiliki account fonnte agar backend whatsapp bot dapat berfungsi di server anda. daftar fonnte disini https://md.fonnte.com/register?ref=9 
5. folder webhook_telegram adalah tempat aplikasi backend telegram bot, anda harus memiliki telegrambot sendiri.
6. folder website, adalah contoh aplikasi yang menunjukkan bahwa pelanggan anda dapat melakukan pemesanan dari halaman ini. video demo ada di https://www.youtube.com/watch?v=BpOiDStf80M


List To Do:
1. Buka account di botbelanja.com
2. Cloning repository ini ke vps cloud anda sendiri
3. Ganti setting database configuration di file db.php
4. Ganti setting di file test_API/settings.php , isi apps_id, owner_id, header_client_id, header_pass_key sesuai dengan informasi pada dashboard botbelanja.com
5. Ganti setting di file webhook_fonnte/settings.php , daftar ke fonnte melalui link ini https://md.fonnte.com/register?ref=9 untuk mendapatkan bonus.
6, Ganti setting di file website/settings.php , untuk mencegah adanya bot yang menganggu server anda, proteksi dengan recaptcha google, isi dengan recaptcha google anda. dapatkan sitekey dan secret key domain anda disini https://www.google.com/recaptcha
7. ambil mysql script di folder mysql, run script tersebut di server anda
8. buat telegrambot, lalu sesuaikan setting api token dan botname di file webhook_telegram/telegram_settings.php


Catatan Penting :
Anda harus memiliki account di https://botbelanja.com untuk memanfaatkan aplikasi ini.
Saat ini sedang dalam masa development, Layanan Saas botbelanja.com Akan dibuka pada 20 Oktober 2022

Kukuh T Wicaksono
Founder botbelanja.com
