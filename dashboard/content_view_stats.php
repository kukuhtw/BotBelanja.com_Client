<?php
ini_set('max_execution_time', 30000000);
ini_set("error_log", "content_view_stats.txt");
include("db.php");
include("saatini.php");
include("function_dashboard.php");



$mode= isset($_POST['mode']) ? $_POST['mode'] : '';
$mode=mysqli_escape_string($link,$mode);

$txtreset=isset($_POST['txtreset']) ? $_POST['txtreset'] : '';
$txtreset=mysqli_escape_string($link,$txtreset);


include("../test_API/settings.php");


//echo "<br>mode = ".$mode;
//echo "<br>apps_id = ".$apps_id;
//echo "<br>owner_id = ".$owner_id;

if ($mode=="resetpasskey" && $txtreset=="RESET HEADER PASS KEY") {
  
  $u = update_header_passkey($apps_id,$owner_id,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

}

?>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              Dashboard
            </li>
            <li class="breadcrumb-item active">Overview</li>


          </ol>
          <!-- Icon Cards-->
          <div class="row">


  <div class="container">

<h2>VIEW STATS DISINI</h2>

<div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              Dashboard
            </li>
            <li class="breadcrumb-item active">View Product</li>
          </ol>
          <!-- Icon Cards-->
          <div class="row">


  <div class="container">

<?php


include("../test_API/settings.php");
//echo "<br>Header_ClientID = ".$Header_ClientID;
//echo "<br>Header_PassKey = ".$Header_PassKey;

$call_api_get_stats=call_api_get_stats($apps_id,$owner_id,$Header_ClientID,$Header_PassKey);

//echo "<br>call_api_get_stats = ".$call_api_get_stats;


$json_decode = json_decode($call_api_get_stats,true);


$status=$json_decode["status"];
$result=$json_decode["result"];


if ($status!="200") {
    $display_result="<p class='bg-warning text-white'>".$result."</p>";
    echo $display_result;
    

}

$apps_id=isset($json_decode["apps_id"]) ? $json_decode["apps_id"] : '';
    $owner_id=isset($json_decode["owner_id"]) ? $json_decode["owner_id"] : '';
    $owner_email = isset($json_decode["owner_email"]) ? $json_decode["owner_email"] : '';

    $quota_product=isset($json_decode["quota_product"]) ? $json_decode["quota_product"] : '';

    $quota_request_item=isset($json_decode["quota_request_item"]) ? $json_decode["quota_request_item"] : '';

    $quota_request_item=isset($json_decode["quota_request_item"]) ? $json_decode["quota_request_item"] : '';
    $current_quota_request_item=isset($json_decode["current_quota_request_item"]) ? $json_decode["current_quota_request_item"] : '';
    $available_quota_request_item=isset($json_decode["available_quota_request_item"]) ? $json_decode["available_quota_request_item"] : '';
    $header_client_id=isset($json_decode["header_client_id"]) ? $json_decode["header_client_id"] : '';
    $header_pass_key=isset($json_decode["header_pass_key"]) ? $json_decode["header_pass_key"] : '';
    $BASE_END_POINT_SAAS=isset($json_decode["BASE_END_POINT_SAAS"]) ? $json_decode["BASE_END_POINT_SAAS"] : '';



//echo "<br>call_api_get_stats = ".$call_api_get_stats;
//echo "<br>quota_request_item = ".$quota_request_item;
//echo "<br>current_quota_request_item = ".$current_quota_request_item;
//echo "<br>available_quota_request_item = ".$available_quota_request_item;
//echo "<br>header_client_id = ".$header_client_id;
//echo "<br>header_pass_key = ".$header_pass_key;
?>
<script>
    // Change the type of input to password or text
        function Toggle() {
            var temp = document.getElementById("typepass");
            if (temp.type === "password") {
                temp.type = "text";
            }
            else {
                temp.type = "password";
            }
        }
</script>

<br>Apps ID : <?php echo $apps_id ?>
<br>Owner ID : <?php echo $owner_id ?>
<br>Owner Email : <?php echo $owner_email ?>

<br>Header_ClientID  : <?php echo $Header_ClientID ?>

<br>Header_PassKey</b>: <input type="password"  size="96"
     value="<?php echo $Header_PassKey ?>" id="typepass"> 
  
 <input type="checkbox" onclick="Toggle()">
    <b>Show Header_PassKey, Never share this Header_PassKey to anyone else.</b>

<br>quota_product  : <?php echo $quota_product ?>
<br>quota_request_item  : <?php echo $quota_request_item ?>
<br>current_quota_request_item  : <?php echo $current_quota_request_item ?>
<br>available_quota_request_item  : <?php echo $available_quota_request_item ?>
<br>BASE_END_POINT_SAAS  : <?php echo $BASE_END_POINT_SAAS ?>


<p>&nbsp;</p>



<?php

function call_api_get_stats($apps_id,$owner_id,$Header_ClientID,$Header_PassKey) {
 
include("../test_API/settings.php");

  $BASE_END_POINT = $BASE_END_POINT_SAAS."API_get_stats.php";

  $postData = array(
    'apps_id' => $apps_id ,
    'owner_id' => $owner_id 
  
    );
  //echo "<br>goint to set ch";
  $ch = curl_init($BASE_END_POINT);
  //echo "<br>ch=".$ch;

  $headers = array(
    "Content-Type: application/json"  ,
    "Accept: application/json"  ,
    "Client-ID: $Header_ClientID",
    "Pass-Key: $Header_PassKey||$Header_ClientID",

  );
  
   //echo "<br>headers: ".$Header_ClientID;
   //echo "<br>Header_PassKey: ".$Header_PassKey;
   
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
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



      </div>
      <!-- /.content-wrapper -->

