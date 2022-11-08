<?php
$filehookname = "webhook_telegram.php";
$API_KEY = ''; // Your Token API telegram bot
$BOT_NAME = ''; // your botname
$NAMA_TOKO="Toko Demo"; // Your Store Name Here
$URL="https://api.telegram.org/bot".$API_KEY;
$host="yourdomain.com/yourfolder"; //your domain and your folder
$URL_BASE = "https://".$host."/webhook_telegram/".$filehookname;

$TELEGRAM_ADMIN ="TELEGRAM ID ADMIN TOKO DISINI";
/* 
to know your telegram id, check this
https://t.me/userinfobot, type anything
you will get info like this
@[YOUR_TELEGRAM_USERNAME]
Id: [YOUR_TELEGRAM_ID]
First: [YOUR FIRST NAME]
Last: [YOUR LAST NAME]
Lang: en
*/

$ABOUT_US="Konten ABOUT US disini";
$ABOUT_US.="%0A %0A ";
$ABOUT_US.="Ini adalah demo toko yang menggunakan API botbelanja.com ";
$ABOUT_US.="%0A";
$ABOUT_US.="Silahkan disi content apa saja yang sesuai";
$ABOUT_US.="%0A";

$THANK_YOU_ORDER ="Terima kasih sudah berbelanja di Toko DEMO BOTBELANJA";
$THANK_YOU_ORDER .="%0A";
$THANK_YOU_ORDER .="Order ID: {{ORDER_ID}}";
$THANK_YOU_ORDER .="%0A";
$THANK_YOU_ORDER .="Order Date: {{ORDER_DATE}}";
$THANK_YOU_ORDER .="%0A";
$THANK_YOU_ORDER .="Grand Total Rp {{GRAND_TOTAL}}";
$THANK_YOU_ORDER .="%0A";
$THANK_YOU_ORDER .="Anda Akan dihubungi oleh staff admin kami";
$THANK_YOU_ORDER .="%0A";


$HELP ="<b>HELP/BANTUAN</b>";
$HELP .="%0A";
$HELP .="%0A";
$HELP .="<b>Info Catalog</b>";
$HELP .="%0A";
$HELP .="Dapat diperoleh di menu button CATALOG";
$HELP .="%0A";
$HELP .="%0A";
$HELP .="<b>Info cara melakukan pemesanan</b>";
$HELP .="%0A";
$HELP .="Pilih Menu Order";
$HELP .="%0A";
$HELP .="Lalu Ketik [JUMLAH PRODUK] [NAMA PRODUK]";
$HELP .="%0A";
$HELP .="Setelah semua nama produk diketik, tekan tombol send";
$HELP .="%0A";
$HELP .="Proses Selesai, Pesanan anda akan diproses";
$HELP .="%0A";
$HELP .="%0A";
$HELP .="<b>Info cara melakukan isi data nama,nomor hape dan alamat</b>";
$HELP .="%0A";
$HELP .="Masuk ke menu Isi data";
$HELP .="%0A";
$HELP .="Isi data Nama , Email, Whatsapp dan alamat pengiriman";
$HELP .="%0A";
$HELP .="%0A";
?>
