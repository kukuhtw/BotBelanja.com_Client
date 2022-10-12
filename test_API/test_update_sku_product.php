<?php


include("settings.php");

$sku = "AQ002";

$category="AMDK";
$productname="box AQUA Botol 600 ml (isi 24 botol)";
$deskripsi_satuan="per box isi 24 botol 600 ml";
$harga=56000;
$k1="aqua 600 ml,air mineral, AQUA Botol 600 ml (isi 24 botol), air mineral 600 ml";
$is_active=1;

$call_api_update_sku_produk = call_api_update_sku_produk($apps_id,$owner_id,$sku,$category,$productname,$deskripsi_satuan,$harga,$k1,$is_active,$Header_ClientID,$Header_PassKey);

$json_decode = json_decode($call_api_update_sku_produk,true);



function call_api_update_sku_produk($apps_id,$owner_id,$sku,$category,$productname,$deskripsi_satuan,$harga,$k1,$is_active,$Header_ClientID,$Header_PassKey) {
	
	include("settings.php");

	$BASE_END_POINT = $BASE_END_POINT_SAAS."API_update_sku_product.php";

	$postData = array(
	  'apps_id' => $apps_id ,
	  'owner_id' => $owner_id ,
	  'sku' => $sku ,
	'category' => $category ,
	  'productname' => $productname ,
	  'deskripsi_satuan' => $deskripsi_satuan ,
	  'harga' => $harga ,
	  'k1' => $k1 ,
	  'is_active' => $is_active
	    
	
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
	
	echo "<br>BASE_END_POINT: ".$BASE_END_POINT;
	echo "<br>headers: ".json_encode($headers);
	echo "<br>postData: ".json_encode($postData);
	echo "<br>content: ".$content;
	//echo "<br>json: ".$json;
	
	$content_results = $content;
	curl_close($ch);

	return $content;
}


?>