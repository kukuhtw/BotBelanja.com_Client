<?php


include("settings.php");
$sku="TEST_1_AQ002";

$call_delete_sku_produk = call_delete_sku_produk($apps_id,$owner_id,$sku,$Header_ClientID,$Header_PassKey);



function call_delete_sku_produk($apps_id,$owner_id,$sku,$Header_ClientID,$Header_PassKey) {
	
	include("settings.php");
	$BASE_END_POINT = $BASE_END_POINT_SAAS."API_delete_sku_product.php";

	$postData = array(
	  'apps_id' => $apps_id ,
	  'owner_id' => $owner_id ,
	  'sku' => $sku 
	
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