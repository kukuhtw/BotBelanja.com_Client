<?php
define('DEBUG', true);
error_reporting(E_ALL);
ini_set("error_log", "errr_content_get_testing.txt");
 ini_set('display_errors', 'Off');
error_reporting(0);
include("db.php");
include("saatini.php");

$mode= isset($_POST['mode']) ? $_POST['mode'] : '';
$mode=mysqli_escape_string($link,$mode);



$isipesan= isset($_POST['isipesan']) ? $_POST['isipesan'] : '';
$isipesan=mysqli_escape_string($link,$isipesan);

$display_result_testing="";
$display_result="";
if ($mode=="Send" && $isipesan !="") {
  //echo "<br>isipesan : ".$isipesan;
  include("../test_API/settings.php");

  $custom_id="DEMO";

  $text_list_item=$isipesan;
  $call_api_proses_list_item = call_api_proses_list_item($apps_id,$owner_id,$custom_id,$text_list_item,$Header_ClientID,$Header_PassKey);

   //echo "<br>text_list_item : ".$text_list_item;

  $json_decode = json_decode($call_api_proses_list_item,true);

  $status=$json_decode["status"];
  $result=$json_decode["result"];
  $custom_id=$json_decode["custom_id"];
  $saatini=$json_decode["saatini"];


  if ($status!="200") {
    $display_result_testing="<p class='bg-warning text-white'>".$result."</p>";
  }
 // echo "<br>status : ".$status;
 // echo "<br>result : ".$result;
 // echo "<br>custom_id : ".$custom_id;
//  echo "<br>saatini : ".$saatini;


//  echo "<br>json_decode list_available_product : ".$json_decode["list_available_product"];


  $j = count($json_decode["list_available_product"]);
 // echo "<h1>j = ".$j. "</h1>";
  $jumlah_data_produk_ada =$j;
  //echo "<h1>jumlah_data_produk_ada = ".$jumlah_data_produk_ada. "</h1>";

//  $nomorurut=isset($json_decode["list_unavailable_product"][$i]["nomorurut"]) ? $json_decode["list_unavailable_product"][$i]["nomorurut"] : '';


 // $j_tidak_ada = is_countable($json_decode["list_unavailable_product"]);
  $j_tidak_ada = count($json_decode["list_unavailable_product"]);

  // echo "<h1>j_tidak_ada = ".$j_tidak_ada. "</h1>";

  $jumlah_data_produk_tidak_ada=$j_tidak_ada;
 //  echo "<h1>jumlah_data_produk_tidak_ada : ".$jumlah_data_produk_tidak_ada. "</h1>";

  $grand_total=$json_decode["grand_total"];

  //echo "<br>grand_total : ".$grand_total;

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
    $user_command=$json_decode["list_available_product"][$i]["user_command"];
    $send_messages.="<Br>".$nomorurut.". ".$productname;
    $send_messages.="<Br>Harga Satuan : Rp ".number_format($hargasatuan);
    $send_messages.="<Br>Jumlah dibeli: ".number_format($qty);
    $send_messages.="<Br>Satuan: ".$deskripsi_satuan;
    $send_messages.="<Br>user_command: ".$user_command;
    $send_messages.="<Br>Total Harga: ".number_format($totalharga);
    $send_messages.="<Br>";
    
  }
  $send_messages.="<Br>Grand Total: Rp ".number_format($grand_total);

 //echo "<br><br>j : ".$j;
 //echo "<br><br>j_tidak_ada : ".$j_tidak_ada;


  if ($jumlah_data_produk_tidak_ada>=1) {
    $send_messages.="<Br><Br>Barang tidak ada.";
    //$send_messages.="<Br><Br>jumlah_data_produk_tidak_ada = ".$jumlah_data_produk_tidak_ada;



  }
  if ($jumlah_data_produk_tidak_ada<=0) {
    $send_messages.="<Br><Br>Semua Barang yang dibeli ada!";
    //$send_messages.="<Br><Br>jumlah_data_produk_tidak_ada = ".$jumlah_data_produk_tidak_ada;

  }


    for ($i=0;$i<$jumlah_data_produk_tidak_ada;$i++) {
      $nomorurut=isset($json_decode["list_unavailable_product"][$i]["nomorurut"]) ? $json_decode["list_unavailable_product"][$i]["nomorurut"] : '';
      $unavailable_product=isset($json_decode["list_unavailable_product"][$i]["unavailable_product"]) ? $json_decode["list_unavailable_product"][$i]["unavailable_product"] : '';
      $send_messages.="<Br>".$nomorurut.". ".$unavailable_product;
    
    }

  $text_list_item_html=$text_list_item;
  //$text_list_item_html=str_replace("\r\n","<br>",$text_list_item_html);

 // echo $send_messages;

  $send_messages=str_replace("\r\n","%0a",$send_messages);
  //$send_messages=nl2br($send_messages);
 // echo "<br><a href='https://wa.me/628129893706?text=".$send_messages."'>Kirim</a>";

  $html = $send_messages;
 



} // end if mode==send

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

<?php
if ($mode=="Send" && $isipesan !="") {
  ?>
<h2>HASIL KONTEN TESTING DISINI</h2>

Hasil Belanja :
<?php

echo $display_result_testing;
echo "<br>".$html;

}

?>
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



$text_list_item = nl2br(stripcslashes($text_list_item));
$text_list_item=str_replace("<br />","",$text_list_item);

?>

<form method="POST">
<br>Daftar Belanja:
<br><textarea name="isipesan" rows="15" cols="50"><?php echo  $text_list_item ?></textarea>
<br>
<input type="hidden" name="mode" value="Send">
<input type="submit" name="submit" value="Send">
</form>
<p>&nbsp;</p>
Catatan : 
<br>1. Setiap pengiriman 1 baris request identifikasi 1 item produk , memerlukan 1 hits saldo.
<br>2. Saldo hits anda akan berkurang untuk setiap 1 item . baris identifikasi request.
<p>&nbsp;</p>
<h2>CATALOG</h2>
<p>&nbsp;</p>

<?php

include("../test_API/settings.php");
$call_api_get_produk_all = call_api_get_produk_all($apps_id,$owner_id,$Header_ClientID,$Header_PassKey);
$json_decode = json_decode($call_api_get_produk_all,true);

$status=$json_decode["status"];
$result=$json_decode["result"];


  if ($status!="200") {
    $display_result="<p class='bg-warning text-white'>".$result."</p>";
    echo $display_result;
  }

$jumlah_product = count($json_decode["product"]);

//echo "<br>jumlah_product : ".$jumlah_product;

//echo "<br>status : ".$status;
//echo "<br>result : ".$result;
$print = "";
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
    $print .= "<br><a href='edit.php?sku=$sku'>sku:".$sku."</a>";
      $print .= "<br><br>";
      $print .= "</div>";

  }

    if ($bariscolom==2) {
      $print .= "<div class='col-sm-8'>";
      $print .= $nourut.". ".$productname;
      $print .= "<br>Harga Rp .".number_format($harga);
       $print .= "<br>Availability/Ketersediaan:".$info_avail;
      $print .= "<br>Deskripsi Satuan :".$deskripsi_satuan;
      $print .= "<br><a href='edit.php?sku=$sku'>sku:".$sku."</a>";
        $print .= "<br><br>";
    
      $print .= "</div>";
            
    }

    
     if ($bariscolom==2) {
        $print .= "</div>";
        $bariscolom=0;
     }
   


  ?>

<?php 

}

echo $print;

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

?>

      </div>
      <!-- /.content-wrapper -->

