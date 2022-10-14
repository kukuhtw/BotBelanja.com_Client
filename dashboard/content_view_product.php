<?php
 error_reporting(error_reporting() & ~E_NOTICE);
 
include("saatini.php");

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

<h2>KONTEN PRODUCT DISINI</h2>


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

<div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table">&nbsp;</i>
              </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>SKU</th>
                      <th>Category</th>
                      
                      <th>ProductName</th>
                      <th>Deskripsi Satuan</th>
                      <th>Harga</th>
                      <th>keywords</th>
                      <th>is Active</th>
                      <th>Edit / Hapus</th>
                      
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                       <th>No</th>
                      <th>SKU</th>
                      <th>Category</th>
                      
                      <th>ProductName</th>
                      <th>Deskripsi Satuan</th>
                      <th>Harga</th>
                      <th>keywords</th>
                      <th>is Active</th>
                        <th>Edit / Hapus</th>
                            </tr>
                  </tfoot>
                  <tbody>


<?php

$display_result="";
include("../test_API/settings.php");
$call_api_get_produk_all = call_api_get_produk_all($apps_id,$owner_id,$Header_ClientID,$Header_PassKey);
$json_decode = json_decode($call_api_get_produk_all,true);

$status=$json_decode["status"];
$result=$json_decode["result"];

//echo "<br>status = ".$status;

if ($status!="200") {
  $display_result="<p class='bg-warning text-white'>".$result."</p>";
  echo $display_result;
}

//$mode= isset($_POST['mode']) ? $_POST['mode'] : '';
$product = isset($json_decode["product"]) ? $json_decode["product"] : '0';

//$jumlah_product = count($json_decode["product"]) ;
// !empty($_POST['value']) ? $_POST['value'] : '';


if(!is_countable($product)) {
  //$your_array = Array();
  $display_result="<p class='bg-warning text-white'>".$result."</p>";
  //echo "<br>yes !";
   $jumlah_product=0;
}
else {
  $jumlah_product = intval(count($product));

}


//$age= isset($age) ? $age: '';

if (isset($jumlah_product) && $jumlah_product =="") {
  //echo $result;
  if ($status=="200") {
    $display_result="<p class='bg-success text-white'>".$result."</p>";
  }
  else {
     $display_result="<p class='bg-warning text-white'>".$result."</p>";
  }
  
   //echo "<br>product = ".$product;
  echo $display_result;
  
}

//echo "<br>jumlah_product : ".$jumlah_product;

//echo "<br>status : ".$status;
//echo "<br>result : ".$result;

for ($i=0;$i<$jumlah_product;$i++) {
  $nourut=$i+1;
  $sku = $json_decode["product"][$i]["sku"];
  $category = $json_decode["product"][$i]["category"];
  $productname = $json_decode["product"][$i]["productname"];
  $deskripsi_satuan = $json_decode["product"][$i]["deskripsi_satuan"];
  $harga = $json_decode["product"][$i]["harga"];
  $k1 = $json_decode["product"][$i]["k1"];
  $is_active = $json_decode["product"][$i]["is_active"];
  
  ?>
    <tr>
                       <td><?php echo $nourut ?></td>
                      <td><?php echo $sku ?></td>
                      <td><?php echo $category ?></td>
                      
                      <td><?php echo $productname ?></td>
                      <td><?php echo $deskripsi_satuan ?></td>
                      <td><?php echo $harga ?></td>
                      <td><?php echo $k1 ?></td>
                      <td><?php echo $is_active ?></td>
                       <td><a href="edit.php?sku=<?php echo $sku ?>">Edit</a> / <a href="hapus.php?sku=<?php echo $sku ?>">Hapus</a></td>

                            </tr>
  <?php

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
  
 // echo "<br>BASE_END_POINT: ".$BASE_END_POINT;
 // echo "<br>headers: ".json_encode($headers);
 // echo "<br>postData: ".json_encode($postData);
 // echo "<br>content: ".$content;
  //echo "<br>json: ".$json;
  
  $content_results = $content;
  curl_close($ch);

  return $content;
}

?>


      </div>
      <!-- /.content-wrapper -->

