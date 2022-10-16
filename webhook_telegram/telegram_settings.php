<?php
$filehookname = "webhook_telegram.php";
$API_KEY = ''; // Your Token API telegram bot
$BOT_NAME = ''; // your botname

$URL="https://api.telegram.org/bot".$API_KEY;
$host="yourdomain.com/yourfolder"; //your domain and your folder
$URL_BASE = "https://".$host."/webhook_telegram/".$filehookname;


$TELEGRAM_ADMIN =""; // your id telegram
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
?>
