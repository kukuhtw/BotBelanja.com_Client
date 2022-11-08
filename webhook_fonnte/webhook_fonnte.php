<?php
header("Content-Type:application/json;charset=utf-8");
include("../db.php");
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$device = $data['device'];
$sender = $data['sender'];
$message = $data['message'];

ini_set("error_log", "errr_webhook_fonnte.txt");
date_default_timezone_set("Asia/Jakarta");
$tanggalhariini = date("Y-m-d");
$jamhariini = date("H:i:sa");
$saatini = $tanggalhariini. " ".$jamhariini;

$phone=$sender;

$app =$device ;
$target= $sender;

	
$namafile="check_1A.txt";
$contentdebug ="\r\ndevice=".$device;
$contentdebug.="\r\nsender=".$sender;
$contentdebug.="\r\nmessage=".$message;
$contentdebug.="\r\nsaatini=".$saatini;
debug_text($namafile,$contentdebug);


include("settings.php");

$senderid = $target;
$text = $message ;

$field="sendername";
$sendername= check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


check_wa_user_exists($senderid,$sendername,$text,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


$field="mode_isidata";
$mode_isidata = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
$mode_isidata=strtolower($mode_isidata);

$field="mode_order";
$mode_order = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);



$custom_id=$sender;
$text_list_item = $message;



if ($message=="KEMBALI KE MENU UTAMA") {

			$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

}

if ($message=="ISI DATA" || $message=="KEMBALI KE MENU ISI DATA") {


		$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


   $field="sendername";
	$sendername = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="email";
	$email = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="alamat_kirim";
	$alamat_kirim = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

    $response_message ="ISI DATA DISINI";
		$response_message .="\r\n";
		$response_message .="\r\n";
		$response_message .="Nama: ".$sendername;
		$response_message .="\r\n";
		$response_message .="Email: ".$email;
		$response_message .="\r\n";
		$response_message .="Alamat Kirim: ".$alamat_kirim;
		$response_message .="\r\n";



				$buttons[] = array(
			 	"id" => "ISI DATA NAMA DAN EMAIL",
			 	"message" => "ISI DATA NAMA DAN EMAIL"
			 );
			 

	 $buttons[] = array(
			 	"id" => "ISI DATA ALAMAT KIRIM",
			 	"message" => "ISI DATA ALAMAT KIRIM"
			 );

		$buttons[] = array(
			 	"id" => "KEMBALI KE MENU UTAMA",
			 	"message" => "KEMBALI KE MENU UTAMA"
			 );

	$buttonJSON = array(
	 "message" => $response_message,
	  "footer" => $FOOTER_BUTTON,
	  "buttons" => $buttons
	);
	$response = kirimPesan_versiUpdate2022($target, $response_message, json_encode($buttonJSON,1), $Token_Fonnte);
		echo $response;
	exit;

}

if ($message=="ISI DATA NAMA DAN EMAIL") {


		$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


	$field="sendername";
		$sendername = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	  $field="email";
		$email = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	  $field="alamat_kirim";
		$alamat_kirim = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


$response_message="ISI DATA NAMA DAN EMAIL";
 $response_message .="\r\n";
		$response_message .="\r\n";
		$response_message .="Nama: ".$sendername;
		$response_message .="\r\n";
		$response_message .="Email: ".$email;
		$response_message .="\r\n";
		$response_message .="Alamat Kirim: ".$alamat_kirim;
		$response_message .="\r\n";



				$buttons[] = array(
			 	"id" => "ISI DATA NAMA",
			 	"message" => "ISI DATA NAMA"
			 );
			 

	 $buttons[] = array(
			 	"id" => "ISI DATA EMAIL",
			 	"message" => "ISI DATA EMAIL"
			 );

		$buttons[] = array(
			 	"id" => "KEMBALI KE MENU ISI DATA",
			 	"message" => "KEMBALI KE MENU ISI DATA"
			 );

	$buttonJSON = array(
	 "message" => $response_message,
	  "footer" => $FOOTER_BUTTON,
	  "buttons" => $buttons
	);
	$response = kirimPesan_versiUpdate2022($target, $response_message, json_encode($buttonJSON,1), $Token_Fonnte);
		echo $response;
	exit;
}

if ($message=="ISI DATA NAMA") {

		$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


 $field="sendername";
	update_data_wa_user_setmode_isidata($senderid,$sendername,$text,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;

	$field="sendername";
	$sendername = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="email";
	$email = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="alamat_kirim";
	$alamat_kirim = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


	   $response_message="ISI DATA NAMA";
	  $response_message .="\r\n";
	  $response_message .="*Silahkan Isi Data Nama Pembeli*";

		$response_message .="\r\n";
		$response_message .="Nama: ".$sendername;
		$response_message .="\r\n";
		$response_message .="Email: ".$email;
		$response_message .="\r\n";
		$response_message .="Alamat Kirim: ".$alamat_kirim;
		$response_message .="\r\n";

		

 		$buttons[] = array(
			 	"id" => "ISI DATA EMAIL",
			 	"message" => "ISI DATA EMAIL"
			 );

				$buttons[] = array(
			 	"id" => "ISI DATA ALAMAT KIRIM",
			 	"message" => "ISI DATA ALAMAT KIRIM"
			 );
			 
		$buttons[] = array(
			 	"id" => "KEMBALI KE MENU ISI DATA",
			 	"message" => "KEMBALI KE MENU ISI DATA"
			 );

	$buttonJSON = array(
	 "message" => $response_message,
	  "footer" => $FOOTER_BUTTON,
	  "buttons" => $buttons
	);
	$response = kirimPesan_versiUpdate2022($target, $response_message, json_encode($buttonJSON,1), $Token_Fonnte);
		echo $response;
	exit;
}


if ($message=="ISI DATA EMAIL") {


		$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="email";
	update_data_wa_user_setmode_isidata($senderid,$sendername,$text,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;


  $field="sendername";
	$sendername = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="email";
	$email = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="alamat_kirim";
	$alamat_kirim = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	  $response_message="ISI DATA EMAIL";
	  $response_message .="\r\n";
	  $response_message .="*Silahkan Isi Data Email*";
	  $response_message .="\r\n";
		$response_message .="Nama: ".$sendername;
		$response_message .="\r\n";
		$response_message .="Email: ".$email;
		$response_message .="\r\n";
		$response_message .="Alamat Kirim: ".$alamat_kirim;
		$response_message .="\r\n";


 		$buttons[] = array(
			 	"id" => "ISI DATA NAMA",
			 	"message" => "ISI DATA NAMA"
			 );

				$buttons[] = array(
			 	"id" => "ISI DATA ALAMAT KIRIM",
			 	"message" => "ISI DATA ALAMAT KIRIM"
			 );
			 
		$buttons[] = array(
			 	"id" => "KEMBALI KE MENU ISI DATA",
			 	"message" => "KEMBALI KE MENU ISI DATA"
			 );

	$buttonJSON = array(
	 "message" => $response_message,
	  "footer" => $FOOTER_BUTTON,
	  "buttons" => $buttons
	);
	$response = kirimPesan_versiUpdate2022($target, $response_message, json_encode($buttonJSON,1), $Token_Fonnte);
		echo $response;
	exit;
}


if ($message=="ISI DATA ALAMAT KIRIM") {

		$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	$field="alamat_kirim";
	update_data_wa_user_setmode_isidata($senderid,$sendername,$text,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) ;

	 $field="sendername";
	$sendername = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="email";
	$email = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="alamat_kirim";
	$alamat_kirim = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


	  $response_message="ISI DATA ALAMAT KIRIM";
		$response_message .="\r\n";
		 $response_message .="*Silahkan Isi Data Alamat Kirim*";
		$response_message .="\r\n";
		$response_message .="Nama: ".$sendername;
		$response_message .="\r\n";
		$response_message .="Email: ".$email;
		$response_message .="\r\n";
		$response_message .="Alamat Kirim: ".$alamat_kirim;
		$response_message .="\r\n";

 		$buttons[] = array(
			 	"id" => "ISI DATA NAMA",
			 	"message" => "ISI DATA NAMA"
			 );

				$buttons[] = array(
			 	"id" => "ISI DATA ALAMAT KIRIM",
			 	"message" => "ISI DATA ALAMAT KIRIM"
			 );
			 
		$buttons[] = array(
			 	"id" => "KEMBALI KE MENU ISI DATA",
			 	"message" => "KEMBALI KE MENU ISI DATA"
			 );

	$buttonJSON = array(
	 "message" => $response_message,
	  "footer" => $FOOTER_BUTTON,
	  "buttons" => $buttons
	);
	$response = kirimPesan_versiUpdate2022($target, $response_message, json_encode($buttonJSON,1), $Token_Fonnte);
		echo $response;
	exit;
}



if ($message=="CATALOG") {
		 

		$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

		 $response_message="CATALOG DISINI";

			include("../test_API/settings.php");
				 $call_api_get_produk_all = call_api_get_produk_all($apps_id,$owner_id,$Header_ClientID,$Header_PassKey);

				$json_decode = json_decode($call_api_get_produk_all,true);

				$status=$json_decode["status"];
				$result=$json_decode["result"];

				$jumlah_product = count($json_decode["product"]);


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

			$NAMA_TOKO=str_replace(" ","",$NAMA_TOKO);
			$NAMA_TOKO=stripcslashes($NAMA_TOKO);
			$header_csv="sku;category;productname;deskripsisatuan;harga;keyword;is_active;\n";
			$namafile ="files/catalog_product_".$NAMA_TOKO.".csv";
			$full_csv=$header_csv.$content_csv;
			write_File_csv($namafile,$full_csv);

			$print_catalog="";
			if ($namafile!="") {
				$print_catalog .="Download catalog disini ".$URL_FOLDER_WA_FONNTE.$namafile;
				$print_catalog .="\r\n";
				$print_catalog .="\r\n";
			}

			$print= str_replace("%0A","\r\n",$print);
			$response_message=$print_catalog. $print;

				$buttons[] = array(
			 	"id" => "ORDER",
			 	"message" => "ORDER"
			 );
			 

	 $buttons[] = array(
			 	"id" => "ISI DATA",
			 	"message" => "ISI DATA"
			 );

		$buttons[] = array(
			 	"id" => "KEMBALI KE MENU UTAMA",
			 	"message" => "KEMBALI KE MENU UTAMA"
			 );

	$buttonJSON = array(
	 "message" => $response_message,
	  "footer" => $FOOTER_BUTTON,
	  "buttons" => $buttons
	);
	$response = kirimPesan_versiUpdate2022($target, $response_message, json_encode($buttonJSON,1), $Token_Fonnte);
		echo $response;
	exit;
}

if ($message=="HELP") {


		$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	 $response_message=$HELP;

				$buttons[] = array(
			 	"id" => "ORDER",
			 	"message" => "ORDER"
			 );
			 

	 $buttons[] = array(
			 	"id" => "ISI DATA",
			 	"message" => "ISI DATA"
			 );

		$buttons[] = array(
			 	"id" => "KEMBALI KE MENU UTAMA",
			 	"message" => "KEMBALI KE MENU UTAMA"
			 );


	$buttonJSON = array(
	 "message" => $response_message,
	  "footer" => $FOOTER_BUTTON,
	  "buttons" => $buttons
	);
	$response = kirimPesan_versiUpdate2022($target, $response_message, json_encode($buttonJSON,1), $Token_Fonnte);
		echo $response;
	exit;
}

if ($message=="ORDER") {

		$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
			 
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

		  $print = str_replace("%0A","\r\n",$print);
		  }

		   		   $value=1;
		   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);



	 $buttons[] = array(
			 	"id" => "CATALOG",
			 	"message" => "CATALOG"
			 );

	 			$buttons[] = array(
			 	"id" => "ISI DATA",
			 	"message" => "ISI DATA"
			 );


		$buttons[] = array(
			 	"id" => "KEMBALI KE MENU UTAMA",
			 	"message" => "KEMBALI KE MENU UTAMA"
			 );


		  $response_message="ORDER DISINI";
		  $response_message .="\r\n";
		  $response_message .=$print;
		  $response_message .="\r\n";
	
	$buttonJSON = array(
	 "message" =>  $response_message,
	  "footer" => $FOOTER_BUTTON,
	  "buttons" => $buttons
	);
	$response = kirimPesan_versiUpdate2022($target, $response_message, json_encode($buttonJSON,1), $Token_Fonnte);
	echo $response;
	exit;
}




if ($mode_isidata=="email") {

		$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	$field="email";
	$value=$text;
	update_data_wa_user($senderid,$sendername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	$field="sendername";
	$sendername = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="email";
	$email = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="alamat_kirim";
	$alamat_kirim = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	  $response_message="ISI DATA EMAIL";
	  $response_message .="\r\n";
		$response_message .="\r\n";
		$response_message .="Nama: ".$sendername;
		$response_message .="\r\n";
		$response_message .="Email: ".$email;
		$response_message .="\r\n";
		$response_message .="Alamat Kirim: ".$alamat_kirim;
		$response_message .="\r\n";


 		$buttons[] = array(
			 	"id" => "ISI DATA NAMA",
			 	"message" => "ISI DATA NAMA"
			 );

				$buttons[] = array(
			 	"id" => "ISI DATA ALAMAT KIRIM",
			 	"message" => "ISI DATA ALAMAT KIRIM"
			 );
			 
		$buttons[] = array(
			 	"id" => "KEMBALI KE MENU ISI DATA",
			 	"message" => "KEMBALI KE MENU ISI DATA"
			 );

	$buttonJSON = array(
	 "message" => $response_message,
	  "footer" => $FOOTER_BUTTON,
	  "buttons" => $buttons
	);
	$response = kirimPesan_versiUpdate2022($target, $response_message, json_encode($buttonJSON,1), $Token_Fonnte);
		echo $response;
	exit;



}

if ($mode_isidata=="sendername") {

		$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	$field="sendername";
	$value=$text;
	update_data_wa_user($senderid,$sendername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

		$field="sendername";
	$sendername = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="email";
	$email = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="alamat_kirim";
	$alamat_kirim = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	   $response_message="ISI DATA NAMA";
	  $response_message .="\r\n";
		$response_message .="\r\n";
		$response_message .="Nama: ".$sendername;
		$response_message .="\r\n";
		$response_message .="Email: ".$email;
		$response_message .="\r\n";
		$response_message .="Alamat Kirim: ".$alamat_kirim;
		$response_message .="\r\n";

		
 		$buttons[] = array(
			 	"id" => "ISI DATA EMAIL",
			 	"message" => "ISI DATA EMAIL"
			 );

				$buttons[] = array(
			 	"id" => "ISI DATA ALAMAT KIRIM",
			 	"message" => "ISI DATA ALAMAT KIRIM"
			 );
			 
		$buttons[] = array(
			 	"id" => "KEMBALI KE MENU ISI DATA",
			 	"message" => "KEMBALI KE MENU ISI DATA"
			 );

	$buttonJSON = array(
	 "message" => $response_message,
	  "footer" => $FOOTER_BUTTON,
	  "buttons" => $buttons
	);
	$response = kirimPesan_versiUpdate2022($target, $response_message, json_encode($buttonJSON,1), $Token_Fonnte);
		echo $response;

		$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	exit;

}

if ($mode_isidata=="alamat_kirim") {


		$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
	$field="mode_order";
	$mode_order = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

   $field="alamat_kirim";
   $value=$text;
	update_data_wa_user($senderid,$sendername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	 $field="sendername";
	$sendername = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="email";
	$email = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

  $field="alamat_kirim";
	$alamat_kirim = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


	  $response_message="ISI DATA ALAMAT KIRIM";
		$response_message .="\r\n";
		$response_message .="\r\n";
		$response_message .="Nama: ".$sendername;
		$response_message .="\r\n";
		$response_message .="Email: ".$email;
		$response_message .="\r\n";
		$response_message .="Alamat Kirim: ".$alamat_kirim;
		$response_message .="\r\n";

 		$buttons[] = array(
			 	"id" => "ISI DATA NAMA",
			 	"message" => "ISI DATA NAMA"
			 );

				$buttons[] = array(
			 	"id" => "ISI DATA ALAMAT KIRIM",
			 	"message" => "ISI DATA ALAMAT KIRIM"
			 );
			 
		$buttons[] = array(
			 	"id" => "KEMBALI KE MENU ISI DATA",
			 	"message" => "KEMBALI KE MENU ISI DATA"
			 );

	$buttonJSON = array(
	 "message" => $response_message,
	  "footer" => $FOOTER_BUTTON,
	  "buttons" => $buttons
	);
	$response = kirimPesan_versiUpdate2022($target, $response_message, json_encode($buttonJSON,1), $Token_Fonnte);
		echo $response;
	exit;
}




if ($mode_order==1) {

	include("../test_API/settings.php");
	$custom_id = $senderid;
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

			$field="sendername";
			$sendername = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
			$namapembeli=$sendername;

			$field="email";
			$emailpembeli = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

			$wapembeli = $senderid;

			$field="alamat_kirim";
			$alamatkirim = check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);



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
		(`orderdate`,`wapembeli`,`namapembeli`,`alamatkirim`,`emailpembeli`,`json_item`,`apps_id`,`owner_id`,`grandtotal`,`is_paid`,`paid_date`)
		values
		('$saatini','$senderid','$sendername','$alamatkirim','$emailpembeli','$json_simpan_database','$apps_id','$owner_id','$grand_total','0','')

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
				$send_messages .="\r\n\r\nBarang tidak ada.";

			  $order_detail.="\r\n\r\nBarang tidak ada.";
			  	
			} // end if ($jumlah_data_produk_tidak_ada>=1) {
			if ($jumlah_data_produk_tidak_ada>=0) {
				//$send_messages.="\r\n\r\nSemua Barang yang dibeli ada!";
				//$order_detail.="\r\n\r\nSemua Barang yang dibeli ada!";

			} // end if  ($jumlah_data_produk_tidak_ada>=0)
			
			for ($i=0;$i<$jumlah_data_produk_tidak_ada;$i++) {
							    
			    $nomorurut=isset($json_decode["list_unavailable_product"][$i]["nomorurut"]) ? $json_decode["list_unavailable_product"][$i]["nomorurut"] : '';
			    $unavailable_product=isset($json_decode["list_unavailable_product"][$i]["unavailable_product"]) ? $json_decode["list_unavailable_product"][$i]["unavailable_product"] : '';

				$send_messages.="\r\n".$nomorurut.". ".$unavailable_product;
				$order_detail.="\r\n".$nomorurut.". ".$unavailable_product;
				
			} // end for ($i=0;$i<$jumlah_data_produk_tidak_ada;$i++)

				$send_messages.="\r\n";
				$order_detail.="\r\n";
					
		}	 // end if ($status=="200") {

		$value=0;
	   update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

	  	$order_detail=str_replace("<br>","%0A",$order_detail);
			$order_detail=str_replace("\r\n","%0A",$order_detail);
			$response_content=$order_detail;
			$response_content=strtolower($response_content);
		
			$response_content .= "\r\n".$THANK_YOU_ORDER;
			$order_date_format = ambil_format_hari($saatini);
			$response_content=str_replace("{{ORDER_ID}}",$order_id,$response_content);
			$response_content=str_replace("{{ORDER_DATE}}",$order_date_format,$response_content);
			$response_content=str_replace("{{GRAND_TOTAL}}",$grand_total_f,$response_content);
			
		
		$NAMA_TOKO=str_replace(" ","",$NAMA_TOKO);
		$NAMA_TOKO=stripcslashes($NAMA_TOKO);
		$RANDOM_FILE=rand(111111,9999999);

$header_csv="orderid;orderdate;sku;productname;hargasatuan;qty;total_harga;\n";
$namafile ="files/order_detail_id_".$order_id."_".$NAMA_TOKO."_".$RANDOM_FILE.".csv";
$full_csv=$header_csv.$content_csv;
write_File_csv($namafile,$full_csv);
$FULL_URL_DOWNLOAD_ORDER = $URL_FOLDER_WA_FONNTE. $namafile;

 // NOTIFIKASI KE PEMILIK TOKO $TELEGRAM_ADMIN

				$response_content .="\r\n";
				$response_content .="Download Order ID ".$order_id." disini : ".$FULL_URL_DOWNLOAD_ORDER;
			$response_content=str_replace("%0A","\r\n",$response_content);
		$response_content=str_replace("%0a","\r\n",$response_content);
		$response_content = ucwords($response_content);


	 $buttons[] = array(
	 	"id" => "HELP",
	 	"message" => "HELP"
	 );

		$buttons[] = array(
			 	"id" => "CATALOG",
			 	"message" => "CATALOG"
			 );

		$buttons[] = array(
			 	"id" => "ORDER",
			 	"message" => "ORDER"
			 );
			 
		$buttonJSON = array(
			 "message" => $response_content,
			  "footer" => $FOOTER_BUTTON,
			  "buttons" => $buttons
			);

		//notifikasi ke user dan admin toko
		//08123456789|Fonnte|Admin,08123456789|Lili|User
		$target_pembeli_dan_admintoko = $target."|Pembeli|Pembeli,".$WA_ADMIN_TOKO."|Admin Toko|Admin Toko";
			$response = kirimPesan_versiUpdate2022($target_pembeli_dan_admintoko, $response_content, json_encode($buttonJSON,1), $Token_Fonnte);
			echo $response;

		exit;


} // end if ($mode_order==1)  


 $buttons[] = array(
	 	"id" => "HELP",
	 	"message" => "HELP"
	 );

$buttons[] = array(
	 	"id" => "CATALOG",
	 	"message" => "CATALOG"
	 );

$buttons[] = array(
	 	"id" => "ORDER",
	 	"message" => "ORDER"
	 );
	 
$buttonJSON = array(
	 "message" => $GREETING,
	  "footer" => $FOOTER_BUTTON,
	  "buttons" => $buttons
	);
	$response = kirimPesan_versiUpdate2022($target, $GREETING, json_encode($buttonJSON,1), $Token_Fonnte);

echo $response;


exit;


function kirimPesan_versiUpdate2022($target, $message, $buttonJSON, $Token_Fonnte) {
		include("settings.php");
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.fonnte.com/send',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array(
        'target' => $target,
        'message' => $message,
        'schedule' => '0',
        'url' => 'https://md.fonnte.com/images/wa-logo.png',
        'filename' => 'filenamehere',
        'buttonJSON' => $buttonJSON
        ),
      CURLOPT_HTTPHEADER => array(
        'Authorization: '.$Token_Fonnte
      ),
     
    ));

     $response = curl_exec($curl);

    curl_close($curl);
   // echo $response;
    return $response;

}

function kirimPesan_versibaru($phone, $data, $Token_Fonnte) {
	include("settings.php");
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://md.fonnte.com/api/send_message.php",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => array(
        'phone' => $phone,
        'type' => $data['type'],
        'text' => $data['pesan'],
        'caption' => $data['pesan'],
        'url' => (($data['type'] == "text") ? "" : $data['url_file']),
        'delay' => '1',
        'schedule' => '0'),
      CURLOPT_HTTPHEADER => array(
        "Authorization: $Token_Fonnte"
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

$namafile="check_2.txt";
$contentdebug="data=".$data;
$contentdebug.="\r\nphone=".$phone;
$contentdebug.="\r\nToken_Fonnte=".$Token_Fonnte;
debug_text($namafile,$contentdebug);



    echo $response;
    return $response;
}


function check_fieldvalue_at_table_wa_user($senderid,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql = " select `$field` as `field` from `wa_user` where `senderid`='$senderid' ";
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

    $field=ucwords($field);  
	  return $field;

}


function update_data_wa_user($senderid,$sendername,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql_update = "update `wa_user` 
      	set `$field`='$value' ,
      	`lastmessages`='$text' , 
      	`mode_isidata`='' ,
      	`lastupdatedate`='$saatini' 
      	where `senderid`='$senderid'
      	";

    	$query = mysqli_query($link,$sql_update)or die ('gagal update data 820-> '.mysqli_error($link));
    	$query = null;
      return $query;	

}

function update_data_wa_user_setmode_isidata($senderid,$sendername,$text,$field,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql_update = "update `wa_user` 
      	set `lastmessages`='$text' , 
      	`mode_isidata`='$field' ,
      	`lastupdatedate`='$saatini' 
      	where `senderid`='$senderid'
      	";

    $query = mysqli_query($link,$sql_update)or die ('gagal update data 835 -> '.mysqli_error($link));
		$query=null;
      return $query;	

}


function check_wa_user_exists($senderid,$sendername,$text,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql = " select count(`id`) as `total` from `wa_user` where `senderid`='$senderid' ";
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

      	$sql_insert= "insert into `wa_user` 
      	(`senderid`,`sendername`,`lastmessages`,`lastupdatedate`,`regdate`) 
      	values 
      	('$senderid','$sendername','$text','$saatini','$saatini') ";
      	$query = mysqli_query($link,$sql_insert)or die ('gagal update data 864 -> '.mysqli_error($link));


      }
      if ($total>=1) {
      	$sql_update = "update `wa_user` 
      	set `sendername`='$sendername' ,
      	`lastmessages`='$text' , 
      	`lastupdatedate`='$saatini' 
      	where `senderid`='$senderid'
      	";
      	$query = mysqli_query($link,$sql_update)or die ('gagal update data 875 -> '.mysqli_error($link));


      }

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


function call_api_proses_list_item($apps_id,$owner_id,$custom_id,$text_list_item,$Header_ClientID,$Header_PassKey) {
	
	include("../test_API/settings.php");

	$BASE_END_POINT = $BASE_END_POINT_SAAS."API_proses_list_item.php";
	//data 0

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

	$namafile="check_3.txt";
$contentdebug="BASE_END_POINT=".$BASE_END_POINT;
$contentdebug.="\r\napps_id=".$apps_id;
$contentdebug.="\r\njson_encode posdata=".json_encode($postData);
$contentdebug.="\r\ncontent_results=".$content_results;
$contentdebug.="\r\nowner_id=".$owner_id;
$contentdebug.="\r\ncustom_id=".$custom_id;

debug_text($namafile,$contentdebug);



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



function update_data_wa_user_setmode_order($senderid,$text,$field,$value,$saatini,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql_update = "update `wa_user` 
      	set `lastmessages`='$text' , 
      	`mode_order`='$value' ,
      	`lastupdatedate`='$saatini' 
      	where `senderid`='$senderid'
      	";
     	$query = mysqli_query($link,$sql_update)or die ('gagal update data -> '.mysqli_error($link));
     	$query = null;
      return $query;	

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


function debug_text($namafile,$contentdebug) {
	$myfile = fopen($namafile, "w") or die("Unable to open file!");
	fwrite($myfile, $contentdebug);
	fclose($myfile);
}


function write_File_csv($namafile,$contentcsv) {
  $myfile = fopen($namafile, "w") or die("Unable to open file!");
  fwrite($myfile, $contentcsv);
  fclose($myfile);
}
?>