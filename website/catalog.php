<?php
include("../test_API/settings.php");

$call_api_get_produk_all = call_api_get_produk_all($apps_id,$owner_id,$Header_ClientID,$Header_PassKey);


$json_decode = json_decode($call_api_get_produk_all,true);

$status=$json_decode["status"];
$result=$json_decode["result"];


//echo "<br>status : ".$status;
//echo "<br>result : ".$result;

  if ($status!="200") {
    $display_result="<p class='bg-warning text-white'>".$result."</p>";
    echo $display_result;
  }

$jumlah_product = count($json_decode["product"]);

//echo "<br>jumlah_product : ".$jumlah_product;

//echo "<br>status : ".$status;
//echo "<br>result : ".$result;
$print = "

";
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Catalgo</title>

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
        	<h1>CATALOG</h1>
<?php

include("menu.php");

  $bariscolom=0;
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

  if ($is_active=="1") {
    $info_avail = "Available";
  }
  else {
   $info_avail = "NOT Available at this moment"; 
  }

 
  
    if ($bariscolom==1) {
      $print .= "<div class='row'>";
      $print .= "<div class='col-sm-4'>";
      $print .= $nourut.". ".$productname;
      $print .= "<br>Harga Rp .".number_format($harga);
       $print .= "<br>Availability/Ketersediaan:".$info_avail;
      $print .= "<br>Deskripsi Satuan:".$deskripsi_satuan;
      $print .= "<br><br>";
      $print .= "</div>";

  }

    if ($bariscolom==2) {
      $print .= "<div class='col-sm-8'>";
      $print .= $nourut.". ".$productname;
      $print .= "<br>Harga Rp .".number_format($harga);
       $print .= "<br>Availability/Ketersediaan:".$info_avail;
      $print .= "<br>Deskripsi Satuan :".$deskripsi_satuan;
        $print .= "<br><br>";
    
      $print .= "</div>";
            
    }

    
     if ($bariscolom==2) {
        $print .= "</div>";
        $bariscolom=0;
     }
   }


      $print .= "</div>";
echo $print;



include("footer.php");


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

?>

