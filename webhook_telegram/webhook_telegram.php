<?php
header('Content-type: text/html; charset=utf-8');
ini_set('display_errors', 1); //unset bila sedang debug
ini_set('display_startup_errors', 1); //unset bila sedang debug
error_reporting(E_ALL); //unset bila sedang debug


include("../db.php");
include("vendor/autoload.php");
include("telegram_settings.php");


//echo "<br>BOT_NAME ! : ".$BOT_NAME;

$URL="https://api.telegram.org/bot".$API_KEY;

//echo "<br>URL BASE : ".$URL_BASE;

use Telegram\Bot\Api;
$telegram = new Api($API_KEY);
$response = $telegram->setWebhook(['url' => $URL_BASE]);

$update = file_get_contents("php://input");
$updatearray = json_decode($update, TRUE);

$username = $updatearray["message"]["chat"]["username"];


if ($username=="") {
	$username = "".$updatearray["message"]["chat"]["id"]."";
}
$chatid = $updatearray["message"]["chat"]["id"];
$telegramid = $chatid;
$message_id = $updatearray["message"]["message_id"];
$text = $updatearray["message"]["text"];
$text = str_replace("'","",$text);
$text = str_replace("\"","",$text);
$text_lower = strtolower($text);

$fromid = $updatearray["message"]["from"]["id"];
$fromusername = $updatearray["message"]["from"]["username"];
$telegramusername = $fromusername;


date_default_timezone_set("Asia/Jakarta");
$tanggalhariini = date("Y-m-d");
$jamhariini = date("H:i:sa");
$saatini = $tanggalhariini. " ".$jamhariini;


?>