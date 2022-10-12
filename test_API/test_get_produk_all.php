<?php

include("settings.php");
$call_api_get_produk_all = call_api_get_produk_all($apps_id,$owner_id,$Header_ClientID,$Header_PassKey);


$json_decode = json_decode($call_api_get_produk_all,true);

$status=$json_decode["status"];
$result=$json_decode["result"];


echo "<br>status : ".$status;
echo "<br>result : ".$result;


function call_api_get_produk_all($apps_id,$owner_id,$Header_ClientID,$Header_PassKey) {
	include("settings.php");
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