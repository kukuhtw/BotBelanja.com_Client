<?php
header("Content-Type:application/json;charset=utf-8");
//ini_set("allow_url_fopen", true);
date_default_timezone_set("Asia/Jakarta");
$tanggalhariini = date("Y-m-d");
$jamhariini = date("H:i:sa");
$saatini = $tanggalhariini. " ".$jamhariini;

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$device = $data['device'];
$pengirim = $data['pengirim'];
$pesan = $data['pesan'];
$phone=$pengirim;

$app =$device ;
$message = $pesan ;
$sender = $pengirim;

	 $data = [
	   "type" => "text",
	    "pesan" => 'Toko Kelontong Kukuh TW, sudah menerima pesan anda, tunggu sebentar ya.',
	  ];

	include("settings.php");
	 kirimPesan_versibaru($phone, $data, $Token_Fonnte);
	

$custom_id=$sender;
$text_list_item = $message;


 $data = [
	        "type" => "text",
	      "pesan" => 'ini auto reply baris 53',
	       ];

    $phone=$sender;
    include("settings.php");
    //kirimPesan_versibaru($phone, $data, $Token_Fonnte);
	

$namafile="check_1.txt";
$contentdebug="pesan=".$pesan;
$contentdebug.="\r\npengirim=".$pengirim;
$contentdebug.="\r\nsender=".$sender;
$contentdebug.="\r\nphone=".$phone;
$contentdebug.="\r\nToken_Fonnte=".$Token_Fonnte;
$contentdebug.="\r\nword1=".$word1;
$contentdebug.="\r\ntext_list_item=".$text_list_item;

debug_text($namafile,$contentdebug);


// bila ad kata mengandung kata daftar belanja
$word1="daftar belanja";
if (strpos($text_list_item, $word1) !== false)
	{

		$data = [
	        "type" => "text",
	      "pesan" => 'Oke, pesanan kami proses, kami akan hitung total belanja semuanya',
	       ];

    $phone=$sender;
    include("settings.php");
    kirimPesan_versibaru($phone, $data, $Token_Fonnte);


	$text_list_item=str_replace("daftar belanja","",$text_list_item);
	$call_api_proses_list_item = call_api_proses_list_item($apps_id,$owner_id,$custom_id,$text_list_item,$Header_ClientID,$Header_PassKey);

	$json_decode = json_decode($call_api_proses_list_item,true);

	$status=$json_decode["status"];
	$result=$json_decode["result"];
	$custom_id=$json_decode["custom_id"];
	$saatini=$json_decode["saatini"];

	if ($status!="200") {
		$error="Terjadi Error !. Pesan Error :".$result;
			$data = [
	        "type" => "text",
	      "pesan" => $error,
	     ];

    $phone=$sender;
    include("settings.php");
    kirimPesan_versibaru($phone, $data, $Token_Fonnte);
	exit;

	}

	$jumlah_data_produk_ada = count($json_decode["list_available_product"]);
	$jumlah_data_produk_tidak_ada=count($json_decode["list_unavailable_product"]);
	$grand_total=$json_decode["grand_total"];
	$send_messages="";
	for ($i=0;$i<$jumlah_data_produk_ada;$i++) {
		$nomorurut=$json_decode["list_available_product"][$i]["nomorurut"];
		$SKU=$json_decode["list_available_product"][$i]["SKU"];
		$productname=$json_decode["list_available_product"][$i]["productname"];
		$hargasatuan=$json_decode["list_available_product"][$i]["hargasatuan"];
		$qty=$json_decode["list_available_product"][$i]["qty"];
	    $deskripsi_satuan=$json_decode["list_available_product"][$i]["deskripsi_satuan"];
		$totalharga=$json_decode["list_available_product"][$i]["totalharga"];
		$cartdate=$json_decode["list_available_product"][$i]["cartdate"];
		$send_messages.="\r\n".$nomorurut.". *".trim($productname)."*";
		$send_messages.="\r\nHarga Satuan : Rp ".number_format($hargasatuan);
		$send_messages.="\r\nJumlah dibeli: ".number_format($qty);
		$send_messages.="\r\nSatuan: ".$deskripsi_satuan;
		$send_messages.="\r\nTotal Harga: ".number_format($totalharga);
		$send_messages.="\r\n";
		
	}
	$send_messages.="\r\nGrand Total: *Rp ".number_format($grand_total)."*";
	//echo "<br>grand_total : ".$grand_total;


	//echo "<br><br>jumlah_data_produk_tidak_ada : ".$jumlah_data_produk_tidak_ada;

	if ($jumlah_data_produk_tidak_ada>=2) {
		$send_messages.="\r\n\r\nBarang tidak ada.";
	}
	if ($jumlah_data_produk_tidak_ada==1) {
		$send_messages.="\r\n\r\nSemua Barang yang dibeli ada!";
	}
	for ($i=0;$i<$jumlah_data_produk_tidak_ada;$i++) {
		$nomorurut=$json_decode["list_unavailable_product"][$i]["nomorurut"];
		$unavailable_product=$json_decode["list_unavailable_product"][$i]["unavailable_product"];
		if ($i>=1) {
			$send_messages.="\r\n".$nomorurut.". *".trim($unavailable_product)."*";
		}
		
	}

	$text_list_item_html=$text_list_item;
	//$text_list_item_html=str_replace("\r\n","<br>",$text_list_item_html);

	//echo $send_messages;
	//$send_messages=str_replace("\r\n","%0a",$send_messages);

	$html = $send_messages;
	//$html=str_replace("%0a","<br>",$html);

	//echo "<br><br>Pesan : <br>".$text_list_item_html;
	//echo "<br><br>hasil : ".$html;
	 $data = [
	        "type" => "text",
	      "pesan" => $html,
	       ];

    $phone=$sender;
    include("settings.php");
    kirimPesan_versibaru($phone, $data, $Token_Fonnte);
	exit;


} // end if (strpos($text_list_item, $word1) !== false)




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
	  "Pass-Key: $Header_PassKey"
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



function debug_text($namafile,$contentdebug) {
	$myfile = fopen($namafile, "w") or die("Unable to open file!");
	fwrite($myfile, $contentdebug);
	fclose($myfile);
}


?>