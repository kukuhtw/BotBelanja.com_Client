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

$host="botbelanja.com/botbelanja_client";
$URL_BASE = "https://".$host."/webhook_telegram/".$filehookname;

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


date_default_timezone_set("Asia/Jakarta");
$tanggalhariini = date("Y-m-d");
$jamhariini = date("H:i:sa");
$saatini = $tanggalhariini. " ".$jamhariini;
$saatini = str_replace("am","",$saatini);
$saatini = str_replace("pm","",$saatini);


$telegramusername=$username;

check_telegram_user_exists($telegramid,$telegramusername,$text,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

$lastmessages = check_last_messages($telegramid,$telegramusername,$text,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

 $check_mode_isidata = check_mode_isidata($telegramid,$telegramusername,$text,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


$field="mode_order";
$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


$response_content="Last Messages = ".$lastmessages;
//file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");

$response_content="check_mode_isidata Messages = ".$check_mode_isidata;
 //file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");

if ($text=="ORDER") {

	$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;



 $response_content="ORDER DISINI";
 file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");

	//sample order
	 include("../test_API/settings.php");
	 $call_api_get_produk_all = call_api_get_produk_random($apps_id,$owner_id,$Header_ClientID,$Header_PassKey);
	$json_decode = json_decode($call_api_get_produk_all,true);

	$status=$json_decode["status"];
	$result=$json_decode["result"];

	 if ($status!="200") {
	   

	  }


	$jumlah_product = count($json_decode["product"]);

	$print = "Sample text to order.";
	$print .="%0A";
	for ($i=0;$i<$jumlah_product;$i++) {
	  $nourut=$i+1;
	  $sku = $json_decode["product"][$i]["sku"];
	  $category = $json_decode["product"][$i]["category"];
	  $productname = $json_decode["product"][$i]["productname"];
	  $deskripsi_satuan = $json_decode["product"][$i]["deskripsi_satuan"];
	  $harga = $json_decode["product"][$i]["harga"];
	  $k1 = $json_decode["product"][$i]["k1"];
	  $is_active = $json_decode["product"][$i]["is_active"];
	 
	  $random_jumlah=rand(1,5);
	  $print .= $random_jumlah." ".$productname;
	  $print .="%0A";

	  }

	   file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$print");

	   $value=1;
	   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

}

if ($text=="ISI DATA") {

	$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


 $response_content ="ISI DATA DISINI";
 $response_content .="%0A";
 file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");

$field="nama";
$nama = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

$field="email";
$email = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

$field="whatsapp";
$whatsapp = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


$field="alamat_kirim";
$alamat_kirim = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

$response_content .="Nama : ".$nama;
$response_content .="%0A";
$response_content .="Email : ".$email;
$response_content .="%0A";
$response_content .="Whatsapp : ".$whatsapp;
$response_content .="%0A";
$response_content .="Alamat kirim : ".$alamat_kirim;
$response_content .="%0A";

file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");

	$responsetext="Pilih menu isi data dibawah ini";
	$keyboard = generate_button_isidata();
		$reply_markup = $telegram->replyKeyboardMarkup([
					'keyboard' => $keyboard, 
					'resize_keyboard' => true, 
					'one_time_keyboard' => true
					]);
					$response = $telegram->sendMessage([
					'chat_id' => $chatid, 
					'text' => $responsetext, 
					'reply_markup' => $reply_markup
					]);
					$messageId = $response->getMessageId();
	 		exit;
}

$modemenuisidata=false;
$response_content="modemenuisidata = ".$modemenuisidata;
//file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");


if ($text=="KEMBALI KE MENU UTAMA") {

		$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


	 	//reset value table mode_isidata
	 	$field="";
	 	update_data_telegram_user_setmode_isidata($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	

  $responsetext="Pilih menu dibawah ini";
	$keyboard = generate_button();
		$reply_markup = $telegram->replyKeyboardMarkup([
					'keyboard' => $keyboard, 
					'resize_keyboard' => true, 
					'one_time_keyboard' => true
					]);
					$response = $telegram->sendMessage([
					'chat_id' => $chatid, 
					'text' => $responsetext, 
					'reply_markup' => $reply_markup
					]);
					$messageId = $response->getMessageId();
		exit;
}

if ($lastmessages=="ISI DATA NAMA") {
		$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


	$modemenuisidata=true;
	$guidance="ISI DATA NAMA ANDA DISINI !";
  file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$guidance");
	
	$field="nama";
	$value=$text;
	
	//$response_content="telegramid = ~".$telegramid. "~ field = ~".$field. "~ value = ~".$text."~ URL = ~".$URL."~";
  //file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");
	
	$sql = update_data_telegram_user_setmode_isidata($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	
	//file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$sql");
	
}

if ($check_mode_isidata=="nama") {
		$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


	$modemenuisidata=true;
	$field="nama";
	$value=$text;
	$sql = update_data_telegram_user($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
		//file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$sql");
}


if ($lastmessages=="ISI DATA EMAIL") {
		$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


	$modemenuisidata=true;
	$guidance="ISI DATA EMAIL ANDA DISINI";
  file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$guidance");

	$field="email";
	$value=$text;
	update_data_telegram_user_setmode_isidata($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
}

if ($check_mode_isidata=="email") {
		$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


	$modemenuisidata=true;
	$field="email";
	$value=$text;
	$sql = update_data_telegram_user($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
		//file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$sql");
}


if ($lastmessages=="ISI DATA WHATSAPP") {

		$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


	$modemenuisidata=true;
	$guidance="ISI DATA NOMOR WHATSAPP ANDA DISINI";
  file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$guidance");

	$field="whatsapp";
	$value=$text;
	update_data_telegram_user_setmode_isidata($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
}

if ($check_mode_isidata=="whatsapp") {

		$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


	$modemenuisidata=true;
	$field="whatsapp";
	$value=$text;
	$sql = update_data_telegram_user($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
		//file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$sql");
}



if ($lastmessages=="ISI DATA ALAMAT KIRIM") {

		$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


	$modemenuisidata=true;
	$guidance="ISI DATA NOMOR ALAMAT KIRIM ANDA DISINI";
  file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$guidance");

	$field="alamat_kirim";
	$value=$lastmessages;
	update_data_telegram_user_setmode_isidata($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
}

if ($check_mode_isidata=="alamat_kirim") {

		$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


	$modemenuisidata=true;
	$field="alamat_kirim";
	$value=$text;
	$sql = update_data_telegram_user($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
		//file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$sql");
}

$response_content="modemenuisidata = ".$modemenuisidata;
//file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");

if ($text=="ISI DATA NAMA"
		|| $text=="ISI DATA EMAIL" 
		|| $text=="ISI DATA WHATSAPP" 
		|| $text=="ISI DATA ALAMAT KIRIM" 
		|| $modemenuisidata==true
	
	)

	 {


		$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


		$field="nama";
		$nama = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

		$field="email";
		$email = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

		$field="whatsapp";
		$whatsapp = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


		$field="alamat_kirim";
		$alamat_kirim = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

		$response_content ="Nama : ".$nama;
		$response_content .="%0A";
		$response_content .="Email : ".$email;
		$response_content .="%0A";
		$response_content .="Whatsapp : ".$whatsapp;
		$response_content .="%0A";
		$response_content .="Alamat kirim : ".$alamat_kirim;
		$response_content .="%0A";

		file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");


	 	$responsetext=$guidance." Atau Pilih menu isi data dibawah ini";
	$keyboard = generate_button_isidata();
		$reply_markup = $telegram->replyKeyboardMarkup([
					'keyboard' => $keyboard, 
					'resize_keyboard' => true, 
					'one_time_keyboard' => true
					]);
					$response = $telegram->sendMessage([
					'chat_id' => $chatid, 
					'text' => $responsetext, 
					'reply_markup' => $reply_markup
					]);
					$messageId = $response->getMessageId();
	 		exit;

}


if ($text=="CATALOG") {

		$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


	 $response_content="CATALOG DISINI";
	 file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");

	 include("../test_API/settings.php");
	 $call_api_get_produk_all = call_api_get_produk_all($apps_id,$owner_id,$Header_ClientID,$Header_PassKey);

	$json_decode = json_decode($call_api_get_produk_all,true);

	$status=$json_decode["status"];
	$result=$json_decode["result"];

	// file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$call_api_get_produk_all");
	// file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$status");

	$jumlah_product = count($json_decode["product"]);

	//file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$jumlah_product");

  $bariscolom=0;
  $print ="Catalog Product";
  $print .="%0A";
  $print .="%0A";
  $content_csv="";
		for ($i=0;$i<$jumlah_product;$i++) {
		  $nourut=$i+1;
		   $bariscolom=$bariscolom+1;
		  $sku = $json_decode["product"][$i]["sku"];
		  $category = $json_decode["product"][$i]["category"];
		  $productname = $json_decode["product"][$i]["productname"];
		  $deskripsi_satuan = $json_decode["product"][$i]["deskripsi_satuan"];
		  $harga = $json_decode["product"][$i]["harga"];
		  $k1 = $json_decode["product"][$i]["k1"];
		  $is_active = $json_decode["product"][$i]["is_active"];
	    $content_csv .=$sku.";".$category.";".$productname.";".$deskripsi_satuan.";".$harga.";".$k1.";".$is_active.";\n";
 

			  if ($is_active=="1") {
			    $info_avail = "Available";
			  }
			  else {
			   $info_avail = "NOT Available at this moment"; 
			  }
	  		
	  		$print .= $nourut.". ".$productname;
	  		$print .="%0A";
	      $print .= "Harga Rp ".number_format($harga);
	      $print .="%0A";
	      $print .= "Availability/Ketersediaan:".$info_avail;
	      $print .="%0A";
	      $print .= "Deskripsi Satuan:".$deskripsi_satuan;
	   	  $print .="%0A";
	   	  $print .="%0A";
	  }

	$header_csv="sku;category;productname;deskripsisatuan;harga;keyword;is_active;\n";
$namafile ="files/catalog_product.csv";
$full_csv=$header_csv.$content_csv;
write_File_csv($namafile,$full_csv);

	 file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$print");


	 	if ($namafile!="") {
		 		$response_rich = $telegram->sendDocument([
				'chat_id' => $telegramid, 
				'document' => $namafile, 
				'caption' => 'document catalog',
				]);
		 	}

}

if ($text=="HELP") {
		$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


 $response_content= $HELP;
 file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");
}

if ($text=="ABOUT US") {

	$value=0;
   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;



 $response_content=$ABOUT_US;
 file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");
}





if ($mode_order==1) {

	include("../test_API/settings.php");
	$custom_id = $telegramid."_".$telegramusername;
	$text_list_item = $text;
	$call_api_proses_list_item = call_api_proses_list_item($apps_id,$owner_id,$custom_id,$text_list_item,$Header_ClientID,$Header_PassKey);

	$json_simpan_database =$call_api_proses_list_item ;
	$json_decode = json_decode($call_api_proses_list_item,true);

	$status=$json_decode["status"];
	$result=$json_decode["result"];

		//$response_content=$call_api_proses_list_item;
		//file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");


	if ($status=="200") {

		
			$custom_id=$json_decode["custom_id"];
			$saatini=$json_decode["saatini"];

			$field="nama";
			$namapembeli = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

			$field="email";
			$emailpembeli = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

			$field="whatsapp";
			$wapembeli = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

			$field="alamat_kirim";
			$alamatkirim = check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);




			$j = intval(count($json_decode["list_available_product"]));
			//echo "<br>j : ".$j;

			$jumlah_data_produk_ada =$j;

			//echo "<br>jumlah_data_produk_ada : ".$jumlah_data_produk_ada;


			$jumlah_unavailableproduct=isset($json_decode["list_unavailable_product"][0]["nomorurut"]) ? $json_decode["list_unavailable_product"][0]["nomorurut"] : 0;

			$jumlah_data_produk_tidak_ada = intval(count($json_decode["list_unavailable_product"]));
			$grand_total=$json_decode["grand_total"];
			$grand_total_f=number_format($grand_total);


		//insert to table order
		$sql_insert_1=" insert into `order` 
		(`orderdate`,`telegramid`,`telegramusername`,`namapembeli`,`alamatkirim`,`emailpembeli`,`wapembeli`,`json_item`,`apps_id`,`owner_id`,`grandtotal`,`is_paid`,`paid_date`)
		values
		('$saatini','$telegramid','$telegramusername','$namapembeli','$alamatkirim','$emailpembeli','$wapembeli','$json_simpan_database','$apps_id','$owner_id','$grand_total','0','')

		";

		//echo "<br>sql_insert_1 = ".$sql_insert_1;

		$last_id=0;
		$status=true;
	
	   $conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
	   // set the PDO error mode to exception
	   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	   $conn->exec($sql_insert_1);
	   $last_id = $conn->lastInsertId();
	   $order_id=$last_id;

	} // end if ($status=="200")

	if ($status=="200") {
		$order_detail="";
		$send_messages="";
     $order_detail .="Order Masuk !<br> Invoice ID :".$order_id. "<br>Order Date:".$saatini;
		$order_detail .="<br>Pembeli: ".$namapembeli;
		$order_detail .="<br>Email: ".$emailpembeli;
		$order_detail .="<br>Whatsapp Number: https://wa.me/".$wapembeli;
		$order_detail .="<br>Alamat Kirim: ".$alamatkirim;
		$order_detail .="<br>Grand Total: Rp ".$grand_total_f;
		$order_detail .="<br>";
		$order_detail .="<br>Detail Item Belanja<br>";

    $order_detail=str_replace("<br>","%0A",$order_detail);
		$order_detail=str_replace("\r\n","%0A",$order_detail);
		$response_content=$order_detail;
		file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");



		//$response_content="jumlah_data_produk_ada = ".$jumlah_data_produk_ada;
		//file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");

		$content_csv ="";

		for ($i=0;$i<$jumlah_data_produk_ada;$i++) {
				$nomorurut=$json_decode["list_available_product"][$i]["nomorurut"];
				$SKU=$json_decode["list_available_product"][$i]["SKU"];
				$cartid=$json_decode["list_available_product"][$i]["cartid"];
				$cartdate=$json_decode["list_available_product"][$i]["cartdate"];
				$score=$json_decode["list_available_product"][$i]["score"];
				$productname=$json_decode["list_available_product"][$i]["productname"];
				$hargasatuan=$json_decode["list_available_product"][$i]["hargasatuan"];
				$qty=$json_decode["list_available_product"][$i]["qty"];
				$qty_f=number_format($qty);
			    $deskripsi_satuan=$json_decode["list_available_product"][$i]["deskripsi_satuan"];
				$totalharga=$json_decode["list_available_product"][$i]["totalharga"];
				$user_command=$json_decode["list_available_product"][$i]["user_command"];
				$deskripsi_satuan=$json_decode["list_available_product"][$i]["deskripsi_satuan"];
				$send_messages.="\r\n".$nomorurut.". ".$productname;
				$send_messages.="\r\nHarga Satuan : Rp ".number_format($hargasatuan);
				$send_messages.="\r\nJumlah dibeli: ".number_format($qty);
				$send_messages.="\r\nSatuan: ".$deskripsi_satuan;
				$send_messages.="\r\nTotal Harga: ".number_format($totalharga);
				$send_messages.="\r\n";

				$order_detail.="\r\n".$nomorurut.". ".$productname;
				$order_detail.="\r\nHarga Satuan : Rp ".number_format($hargasatuan);
				$order_detail.="\r\nJumlah dibeli: ".number_format($qty);
				$order_detail.="\r\nSatuan: ".$deskripsi_satuan;
				$order_detail.="\r\nTotal Harga: ".number_format($totalharga);
				$order_detail.="\r\n";
				$orderdate_format=ambil_format_hari($saatini);

				$content_csv.=$order_id.";".$orderdate_format.";".$SKU.";".$productname.";".$hargasatuan.";".$qty_f.";".$totalharga.";"."\n";


				$sql_insert_2="insert 
				into `order_detail` 
				(`order_id`,`sku`,`product_name`,`cartid`,`cartdate`,`score`,`user_command`,`hargasatuan`,`qty`,`totalharga`)
				values 
				('$order_id','$SKU','$productname','$cartid','$cartdate','$score','$user_command','$hargasatuan','$qty','$totalharga')";

				//echo "<br>sql_insert_2 = ".$sql_insert_2;
				$query = mysqli_query($link,$sql_insert_2)or die ('gagal insert transaction_hits '.mysqli_error($link));
				$query=null;	

				
			} // end for ($i=0;$i<$jumlah_data_produk_ada;$i++)

			$content_csv.="\n;".";".";".";".";"."Grand Total;".$grand_total.";"."\n";

			$send_messages.="\r\nGrand Total: Rp ".number_format($grand_total);
		//	echo "<br><br>jumlah_data_produk_tidak_ada : ".$jumlah_data_produk_tidak_ada;

	  
			if ($jumlah_data_produk_tidak_ada>=1) {
				$send_messages.="\r\n\r\nBarang tidak ada.";
			  $order_detail.="\r\n\r\nBarang tidak ada.";
					
			} // end if ($jumlah_data_produk_tidak_ada>=1) {
			if ($jumlah_data_produk_tidak_ada>=0) {
				//$send_messages.="\r\n\r\nSemua Barang yang dibeli ada!";
				$order_detail.="\r\n\r\nSemua Barang yang dibeli ada!";

			} // end if  ($jumlah_data_produk_tidak_ada>=0)
			
			for ($i=0;$i<$jumlah_data_produk_tidak_ada;$i++) {
							    
			    $nomorurut=isset($json_decode["list_unavailable_product"][$i]["nomorurut"]) ? $json_decode["list_unavailable_product"][$i]["nomorurut"] : '';
			    $unavailable_product=isset($json_decode["list_unavailable_product"][$i]["unavailable_product"]) ? $json_decode["list_unavailable_product"][$i]["unavailable_product"] : '';

				$send_messages.="\r\n".$nomorurut.". ".$unavailable_product;
				$order_detail.="\r\n".$nomorurut.". ".$unavailable_product;
				
			} // end for ($i=0;$i<$jumlah_data_produk_tidak_ada;$i++)

		

		}	 // end if ($status=="200") {

		$value=0;
	   update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	  	$send_messages=str_replace("<br>","%0A",$send_messages);
			$send_messages=str_replace("\r\n","%0A",$send_messages);
			$response_content=$send_messages;
			$response_content=strtolower($response_content);
		   file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");

			$response_content=$THANK_YOU_ORDER;
			$order_date_format = ambil_format_hari($saatini);
			$response_content=str_replace("{{ORDER_ID}}",$order_id,$response_content);
			$response_content=str_replace("{{ORDER_DATE}}",$order_date_format,$response_content);
			$response_content=str_replace("{{GRAND_TOTAL}}",$grand_total_f,$response_content);
			
			//	$response_content=strtolower($response_content);
		  file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$response_content");


$header_csv="orderid;orderdate;sku;productname;hargasatuan;qty;total_harga;\n";
$namafile ="files/order_detail_id_".$order_id.".csv";
$full_csv=$header_csv.$content_csv;
write_File_csv($namafile,$full_csv);


	 	if ($namafile!="") {
		 		$response_rich = $telegram->sendDocument([
				'chat_id' => $telegramid, 
				'document' => $namafile, 
				'caption' => 'Order Detail',
				]);
		 	}


 // NOTIFIKASI KE PEMILIK TOKO $TELEGRAM_ADMIN
		if ($namafile!="") {
		 		$response_rich = $telegram->sendDocument([
				'chat_id' => $TELEGRAM_ADMIN, 
				'document' => $namafile, 
				'caption' => 'ada Order masuk, Order ID :'.$order_id,
				]);
		 	}



} // end if ($mode_order==1)  




	$responsetext="Pilih menu dibawah ini";
	$keyboard = generate_button();
		$reply_markup = $telegram->replyKeyboardMarkup([
					'keyboard' => $keyboard, 
					'resize_keyboard' => true, 
					'one_time_keyboard' => true
					]);
					$response = $telegram->sendMessage([
					'chat_id' => $chatid, 
					'text' => $responsetext, 
					'reply_markup' => $reply_markup
					]);
					$messageId = $response->getMessageId();

 		exit;


function write_File_csv($namafile,$contentcsv) {
  $myfile = fopen($namafile, "w") or die("Unable to open file!");
  fwrite($myfile, $contentcsv);
  fclose($myfile);
}

function generate_button() {

		$keyboard = [
			 ["ORDER"],
			 ["ISI DATA","CATALOG"],
		  	 ["ORDER","ABOUT US"],
		  	 ["HELP"],
		 
		 	];
		 return $keyboard;	
		
}

function generate_button_isidata() {

		$keyboard = [
			 ["ISI DATA NAMA","ISI DATA EMAIL"],
		  	 ["ISI DATA WHATSAPP","ISI DATA ALAMAT KIRIM"],
		  	 ["KEMBALI KE MENU UTAMA"],
		 
		 	];
		 return $keyboard;	
		
}


function call_api_proses_list_item($apps_id,$owner_id,$custom_id,$text_list_item,$Header_ClientID,$Header_PassKey) {
    
   include("../test_API/settings.php");

    $BASE_END_POINT = $BASE_END_POINT_SAAS."API_proses_list_item.php";

    $postData = array(
      'apps_id' => $apps_id ,
      'owner_id' => $owner_id ,
      'custom_id' => $custom_id ,
      'text_list_item' => $text_list_item     
      );
    //echo "<br>goint to set ch";
    $ch = curl_init($BASE_END_POINT);
    //echo "<br>ch=".$ch;

    $headers = array(
      'Content-Type: application/json'  ,
      'Accept: application/json'  ,
      "Client-ID: $Header_ClientID",
      "Pass-Key: $Header_PassKey||$Header_ClientID"
    );
    
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    $content = curl_exec($ch);
    $content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
    $json = json_decode($content, true);
    
    //echo "<br>BASE_END_POINT: ".$BASE_END_POINT;
    //echo "<br>headers: ".json_encode($headers);
    //echo "<br>postData: ".json_encode($postData);
    //echo "<br>content: ".$content;
    //echo "<br>json: ".$json;
    
    $content_results = $content;
    curl_close($ch);

    return $content;
}


function call_api_get_produk_random($apps_id,$owner_id,$Header_ClientID,$Header_PassKey) {
 include("../test_API/settings.php");
  $BASE_END_POINT = $BASE_END_POINT_SAAS."API_get_product_random.php";

  $postData = array(
    'apps_id' => $apps_id ,
    'owner_id' => $owner_id 
  
    );
  //echo "<br>goint to set ch";
  $ch = curl_init($BASE_END_POINT);
  //echo "<br>ch=".$ch;

  $headers = array(
    'Content-Type: application/json'  ,
    'Accept: application/json'  ,
    "Client-ID: $Header_ClientID",
    "Pass-Key: $Header_PassKey||$Header_ClientID"
  );
  
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
  $content = curl_exec($ch);
  $content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
  $json = json_decode($content, true);
  
  //echo "<br>BASE_END_POINT: ".$BASE_END_POINT;
  //echo "<br>headers: ".json_encode($headers);
  //echo "<br>postData: ".json_encode($postData);
  //echo "<br>content: ".$content;
  //echo "<br>json: ".$json;
  
  $content_results = $content;
  curl_close($ch);

  return $content;
}

function call_api_get_produk_all($apps_id,$owner_id,$Header_ClientID,$Header_PassKey) {
	include("../test_API/settings.php");
	$BASE_END_POINT = $BASE_END_POINT_SAAS."API_get_product_all.php";

	$postData = array(
	  'apps_id' => $apps_id ,
	  'owner_id' => $owner_id 
	
	  );
	//echo "<br>goint to set ch";
	$ch = curl_init($BASE_END_POINT);
	//echo "<br>ch=".$ch;

	$headers = array(
	  'Content-Type: application/json'  ,
	  'Accept: application/json'  ,
	  "Client-ID: $Header_ClientID",
	  "Pass-Key: $Header_PassKey||$Header_ClientID"
	);
	
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
	$content = curl_exec($ch);
	$content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
	$json = json_decode($content, true);
	
	//echo "<br>BASE_END_POINT: ".$BASE_END_POINT;
	//echo "<br>headers: ".json_encode($headers);
	//echo "<br>postData: ".json_encode($postData);
	//echo "<br>content: ".$content;
	//echo "<br>json: ".$json;
	
	$content_results = $content;
	curl_close($ch);

	return $content;
}

function check_fieldvalue_at_table_telegramuser($telegramid,$telegramusername,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql = " select `$field` as `field` from `telegram_user` where `telegramid`='$telegramid' ";
	 $options = array(
  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
      );

      $conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $field="";
      foreach($conn->query($sql) as $row) {
          $field=$row['field'];
      }

	  return $field;

}


function check_last_messages($telegramid,$telegramusername,$text,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql = " select `lastmessages` from `telegram_user` where `telegramid`='$telegramid' ";
	 $options = array(
  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
      );

      $conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $lastmessages="";
      foreach($conn->query($sql) as $row) {
            $lastmessages=$row['lastmessages'];
      }

	  return $lastmessages;

}

function check_mode_isidata($telegramid,$telegramusername,$text,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql = " select `mode_isidata` from `telegram_user` where `telegramid`='$telegramid' ";
	 $options = array(
  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
      );

      $conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $mode_isidata="";
      foreach($conn->query($sql) as $row) {
          $mode_isidata=$row['mode_isidata'];
      }

	  return $mode_isidata;

}

function check_telegram_user_exists($telegramid,$telegramusername,$text,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql = " select count(`id`) as `total` from `telegram_user` where `telegramid`='$telegramid' ";
	 $options = array(
  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
      );

      $conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $rt=0;
      foreach($conn->query($sql) as $row) {
          $rt=$rt+1;
          $total=$row['total'];
      }

      if ($total<=0) {

      	$sql_insert= "insert into `telegram_user` 
      	(`telegramid`,`telegramusername`,`lastmessages`,`lastupdatedate`,`regdate`) 
      	values 
      	('$telegramid','$telegramusername','$text','$saatini','$saatini') ";
      	$query = mysqli_query($link,$sql_insert)or die ('gagal update data -> '.mysqli_error($link));


      }
      if ($total>=1) {
      	$sql_update = "update `telegram_user` 
      	set `telegramusername`='$telegramusername' ,
      	`lastmessages`='$text' , 
      	`lastupdatedate`='$saatini' 
      	where `telegramid`='$telegramid'
      	";
      	$query = mysqli_query($link,$sql_update)or die ('gagal update data -> '.mysqli_error($link));


      }

}

function update_data_telegram_user_setmode_order($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql_update = "update `telegram_user` 
      	set `lastmessages`='$text' , 
      	`mode_order`='$value' ,
      	`lastupdatedate`='$saatini' 
      	where `telegramid`='$telegramid'
      	";

     // 	file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$sql_update");

      	$query = mysqli_query($link,$sql_update)or die ('gagal update data -> '.mysqli_error($link));

      return $sql_update;	

}
function update_data_telegram_user_setmode_isidata($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql_update = "update `telegram_user` 
      	set `lastmessages`='$text' , 
      	`mode_isidata`='$field' ,
      	`lastupdatedate`='$saatini' 
      	where `telegramid`='$telegramid'
      	";

     // 	file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$sql_update");

      	$query = mysqli_query($link,$sql_update)or die ('gagal update data -> '.mysqli_error($link));

      return $sql_update;	

}

function update_data_telegram_user($URL,$telegramid,$telegramusername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql_update = "update `telegram_user` 
      	set `$field`='$value' ,
      	`lastmessages`='$text' , 
      	`mode_isidata`='' ,
      	`lastupdatedate`='$saatini' 
      	where `telegramid`='$telegramid'
      	";

 //     	file_get_contents($URL."/sendmessage?chat_id=$telegramid&parse_mode=HTML&text=$sql_update");

      	$query = mysqli_query($link,$sql_update)or die ('gagal update data -> '.mysqli_error($link));

      return $sql_update;	

}

function ambil_format_hari($questiondate) {
		$questiondate = str_replace("pm", "", $questiondate);
		$questiondate = str_replace("am", "", $questiondate);

		$jam_menit_detik = substr($questiondate,11,9);
		$dt = strtotime($questiondate);
		$tahun = substr($questiondate,0,4);
		$tanggal = substr($questiondate,8,2);
		$bulan = substr($questiondate,5,2);
		//2020-12-31 12:59:56
		$jam_menit_detik = substr($questiondate,11,9);
		$namahari="";
		$namabulan="";
			if ($bulan=="01") {
					$namabulan="January";
			} else if ($bulan=="02") {
						$namabulan="February";
					} else if ($bulan=="03") {
						$namabulan="Maret";
					} else if ($bulan=="04") {
						$namabulan="April";
					} else if ($bulan=="05") {
						$namabulan="May";
					} else if ($bulan=="06") {
						$namabulan="Juni";
					} else if ($bulan=="07") {
						$namabulan="July";
					} else if ($bulan=="08") {
						$namabulan="Agustus";
					} else if ($bulan=="09") {
						$namabulan="September";
					} else if ($bulan=="10") {
						$namabulan="Oktober";
					} else if ($bulan=="11") {
						$namabulan="November";
					} else if ($bulan=="12") {
						$namabulan="Desember";
					}

									
					$formatwaktu = $tanggal . " ".$namabulan. " " .$tahun." jam ".$jam_menit_detik; ;
					return $formatwaktu;

}

?>