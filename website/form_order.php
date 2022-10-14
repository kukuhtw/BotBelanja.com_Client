<?php
define('DEBUG', true);
error_reporting(E_ALL);
ini_set("error_log", "form_order_error.txt");
 ini_set('display_errors', 'On');

include("../test_API/settings.php");
include("../db.php");

$send_messages="";
$mode= isset($_POST['mode']) ? $_POST['mode'] : '';
$name= isset($_POST['name']) ? $_POST['name'] : '';
$email= isset($_POST['email']) ? $_POST['email'] : '';
$wanumber= isset($_POST['wanumber']) ? $_POST['wanumber'] : '';
$daftar_belanja= isset($_POST['daftar_belanja']) ? $_POST['daftar_belanja'] : '';

$alamatkirim= isset($_POST['alamatkirim']) ? $_POST['alamatkirim'] : '';


$mode=mysqli_escape_string($link,$mode);
$name=mysqli_escape_string($link,$name);
$email=mysqli_escape_string($link,$email);
$wanumber=mysqli_escape_string($link,$wanumber);
$daftar_belanja=mysqli_escape_string($link,$daftar_belanja);
$alamatkirim=mysqli_escape_string($link,$alamatkirim);


 $send_messages="";
if ($mode=="ORDER" && $alamatkirim!="" && $daftar_belanja!="" ) {
	include("../test_API/settings.php");

	//proses here
	echo "<br>name : ".$name;
	echo "<br>email : ".$email;
	echo "<br>wanumber : ".$wanumber;
	echo "<br>daftar_belanja : ".$daftar_belanja;

	$custom_id = $email. " ".$wanumber." ".$name;
	$text_list_item = $daftar_belanja;
	$call_api_proses_list_item = call_api_proses_list_item($apps_id,$owner_id,$custom_id,$text_list_item,$Header_ClientID,$Header_PassKey);

	$json_simpan_database =$call_api_proses_list_item ;
	$json_decode = json_decode($call_api_proses_list_item,true);

	$status=$json_decode["status"];
	$result=$json_decode["result"];
	$custom_id=$json_decode["custom_id"];
	$saatini=$json_decode["saatini"];

	echo "<br>status : ".$status;
	echo "<br>result : ".$result;
	echo "<br>custom_id : ".$custom_id;
	echo "<br>saatini : ".$saatini;
	//echo "<br>call_api_proses_list_item : ".$call_api_proses_list_item;




	$j = intval(count($json_decode["list_available_product"]));
	//echo "<br>j : ".$j;

	$jumlah_data_produk_ada =$j;

	echo "<br>jumlah_data_produk_ada : ".$jumlah_data_produk_ada;


	$jumlah_unavailableproduct=isset($json_decode["list_unavailable_product"][0]["nomorurut"]) ? $json_decode["list_unavailable_product"][0]["nomorurut"] : 0;

	$jumlah_data_produk_tidak_ada = intval(count($json_decode["list_unavailable_product"]));
	$grand_total=$json_decode["grand_total"];
	$grand_total_f=number_format($grand_total);

	if ($status=="200") {
		//insert to table order
		$sql_insert_1=" insert into `order` 
		(`orderdate`,`namapembeli`,`alamatkirim`,`emailpembeli`,`wapembeli`,`json_item`,`apps_id`,`owner_id`,`grandtotal`,`is_paid`,`paid_date`)
		values
		('$saatini','$name','$alamatkirim','$email','$wanumber','$json_simpan_database','$apps_id','$owner_id','$grand_total','0','')

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
		
		for ($i=0;$i<$jumlah_data_produk_ada;$i++) {
			$nomorurut=$json_decode["list_available_product"][$i]["nomorurut"];
			$SKU=$json_decode["list_available_product"][$i]["SKU"];
			$cartid=$json_decode["list_available_product"][$i]["cartid"];
			$cartdate=$json_decode["list_available_product"][$i]["cartdate"];
			$score=$json_decode["list_available_product"][$i]["score"];
			$productname=$json_decode["list_available_product"][$i]["productname"];
			$hargasatuan=$json_decode["list_available_product"][$i]["hargasatuan"];
			$qty=$json_decode["list_available_product"][$i]["qty"];
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

			$sql_insert_2="insert 
			into `order_detail` 
			(`order_id`,`sku`,`product_name`,`cartid`,`cartdate`,`score`,`user_command`,`hargasatuan`,`qty`,`totalharga`)
			values 
			('$order_id','$SKU','$productname','$cartid','$cartdate','$score','$user_command','$hargasatuan','$qty','$totalharga')";

			//echo "<br>sql_insert_2 = ".$sql_insert_2;
			$query = mysqli_query($link,$sql_insert_2)or die ('gagal insert transaction_hits '.mysqli_error($link));
			$query=null;	

			
			} // end for ($i=0;$i<$jumlah_data_produk_ada;$i++)


			$send_messages.="\r\nGrand Total: Rp ".number_format($grand_total);
		//	echo "<br><br>jumlah_data_produk_tidak_ada : ".$jumlah_data_produk_tidak_ada;

			if ($jumlah_data_produk_tidak_ada>=1) {
				$send_messages.="\r\n\r\nBarang tidak ada.";
			}
			if ($jumlah_data_produk_tidak_ada>=0) {
				$send_messages.="\r\n\r\nSemua Barang yang dibeli ada!";

			}
			for ($i=0;$i<$jumlah_data_produk_tidak_ada;$i++) {
				
			    
			    $nomorurut=isset($json_decode["list_unavailable_product"][$i]["nomorurut"]) ? $json_decode["list_unavailable_product"][$i]["nomorurut"] : '';

			    	

			    $unavailable_product=isset($json_decode["list_unavailable_product"][$i]["unavailable_product"]) ? $json_decode["list_unavailable_product"][$i]["unavailable_product"] : '';


				$send_messages.="\r\n".$nomorurut.". ".$unavailable_product;
				
			}

			$text_list_item_html=$text_list_item;
			$text_list_item_html=str_replace("\r\n","<br>",$text_list_item_html);

			$send_messages=str_replace("\r\n","<br>",$send_messages);

			//	echo $send_messages;



		   //Notifikasi ke Telegram
			$send_messages_telegram ="Order Masuk !<br> Invoice ID :".$order_id. "<br>Order Date:".$saatini;
			$send_messages_telegram .="<br>Pembeli: ".$name;
			$send_messages_telegram .="<br>Email: ".$email;
			$send_messages_telegram .="<br>Whatsapp Number: https://wa.me/".$wanumber;
			$send_messages_telegram .="<br>Alamat Kirim: ".$alamatkirim;
			$send_messages_telegram .="<br>Grand Total: Rp ".$grand_total_f;
			$send_messages_telegram .="<br>";
			$send_messages_telegram .="<br>Detail Item Belanja<br>";
			$send_messages_telegram = str_replace("<br>","\n",$send_messages_telegram);
			
			$send_messages_telegram .="<br>";
			$send_messages_telegram .= str_replace("<br>","\n",$send_messages);
			$send_messages_telegram .="<br>Terima Kasih sudah berbelanja di MiniMarket Kukuh TW.";
			$send_messages_telegram .="<br>";
			$send_messages_telegram = str_replace("<br>","\n",$send_messages_telegram);
		
			$send_messages_whatsapp = $send_messages_telegram;
			$send_messages_telegram = rawurlencode($send_messages_telegram);
				include("../webhook_telegram/vendor/autoload.php");
				include("../webhook_telegram/telegram_settings.php");
			   file_get_contents($URL."/sendmessage?chat_id=".$TELEGRAM_ADMIN."&text=$send_messages_telegram");


			//Notifikasi ke whatsapp menggunakan Fonnte
			include("../webhook_fonnte/settings.php");
					$data = [
	        "type" => "text",
	         "pesan" => $send_messages_whatsapp,
	     ];

       $phone=$WA_ADMIN_TOKO;

			Fonnte_kirimPesan_versibaru($phone, $data, $Token_Fonnte);


		} // end if ($status=="200")

		//BILA TERJADI GAGAL
		if ($status!="200") {
			$send_messages=$result;
		
		}

			
} // end if mode order

?>
<?php
include("../test_API/settings.php");
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Form Order</title>

    <!-- Bootstrap core CSS-->
    <link href="../dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="../dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="../dashboard/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../dashboard/css/sb-admin.css" rel="stylesheet">
     <script src="../dashboard/js/jquery-3.3.1.min.js"></script>
     <script src="../dashboard/js/jquery-ui.min.js"></script>


    <link rel="stylesheet" href="../dashboard/css/multi-select.css" type="text/css">
    <script type="text/javascript" src="../dashboard/js/jquery.multi-select.js"></script>    


  </head>
  <body id="page-top">
  	  <div id="content-wrapper">

        <div class="container-fluid">
        	<h1>Form Order</h1>
<?php

include("menu.php");

	echo $send_messages;
?>

<form method="POST">
<br>Nama :
<br><input type="text" name="name" value="<?php echo $name ?>" required >
<br>Email :
<br><input type="email" name="email" value="<?php echo $email ?>" required>
<br>Whatsapp : Tulis dengan format kode negara, sebagai contoh 6281xxxxxxx untuk negara Indonesia
<br><input type="text" name="wanumber" value="<?php echo $wanumber ?>" required>
<br>Daftar Belanja:
<br><textarea name="daftar_belanja" rows="5" cols="80" required></textarea>
<br>Alamat Pengiriman: Tulis lengkap disertai kodepos
<br><textarea name="alamatkirim" rows="5" cols="80" required><?php echo $alamatkirim ?></textarea>

<input type="hidden" name="mode" value="ORDER">
<br><input type="submit" name="" value="Order">

</form>
<p>&nbsp;</p>
<h2>CONTOH DAFTAR BELANJA</h2>

<?php

include("../test_API/settings.php");
$call_api_get_produk_all = call_api_get_produk_random($apps_id,$owner_id,$Header_ClientID,$Header_PassKey);
$json_decode = json_decode($call_api_get_produk_all,true);

$status=$json_decode["status"];
$result=$json_decode["result"];

 if ($status!="200") {
    $display_result="<p class='bg-warning text-white'>".$result."</p>";
    echo $display_result;
  }


$jumlah_product = count($json_decode["product"]);

$print = "<br>";
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
  $print .= "<br>";

  }

  echo $print;

//$text_list_item = nl2br(stripcslashes($text_list_item));
//$text_list_item=str_replace("<br />","",$text_list_item);


include("footer.php");




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
	
//	echo "<br>BASE_END_POINT: ".$BASE_END_POINT;
	//echo "<br>headers: ".json_encode($headers);
///	echo "<br>postData: ".json_encode($postData);
//	echo "<br>content: ".$content;
	//echo "<br>json: ".$json;
	
	$content_results = $content;
	curl_close($ch);

	return $content;
}

function Fonnte_kirimPesan_versibaru($phone, $data, $Token_Fonnte) {
	include("../webhook_fonnte/settings.php");
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

 //   echo $response;
    return $response;
}


?>
