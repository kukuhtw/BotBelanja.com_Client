<?php
 error_reporting(error_reporting() & ~E_NOTICE);
include("../db.php");
include("saatini.php");



$orderid= isset($_GET['orderid']) ? $_GET['orderid'] : '';
$orderid=mysqli_escape_string($link,$orderid);

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

<h2>KONTEN ORDER MANAGEMENT DISINI</h2>


<div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              Dashboard
            </li>
            <li class="breadcrumb-item active">View Order</li>
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
                      <th>Order ID / Date</th>
                      
                      <th>Produk</th>
                      <th>Harga Satuan</th>
                      <th>Kuantity Detail</th>
                      <th>Total Harga</th>
                      
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                    <th>No</th>
                       <th>Order ID / Date</th>
                      
                      <th>Produk</th>
                      <th>Harga Satuan</th>
                      <th>Kuantity Detail</th>
                      <th>Total Harga</th>
                            </tr>
                  </tfoot>
                  <tbody>


<?php
include("../test_API/settings.php");

$display_result="";
$sql = "select * from `order_detail` where `order_id`='$orderid' order by id desc";

//echo "<Br>sql = ".$sql;
 $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            );
            $conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $fieldvalue="";
            $rt=0;
            $grand_total=0;
            foreach($conn->query($sql) as $row) {
               $rt=$rt+1;
               $id=$row['id'];
                $cartdate=$row['cartdate'];
                
                 $sku=$row['sku'];
                
                 $product_name=$row['product_name'];
                 $score=$row['score'];
                $user_command=$row['user_command'];
                $hargasatuan=$row['hargasatuan'];
                $hargasatuan_f=number_format($hargasatuan);
                $qty=$row['qty'];
                $totalharga=$row['totalharga'];
                $totalharga_f=number_format($totalharga);
                $grand_total = $grand_total+$totalharga;
                $grand_total_f=number_format($grand_total);
                
                           
  ?>
    <tr>
                       <td><?php echo $rt ?></td>
                      <td>
                        <br>Order ID : <?php echo $orderid ?>
                        <br><?php echo $cartdate ?>
                      </td>
                      <td>
                       SKU: <?php echo $sku ?>
                       <br><?php echo $product_name ?>

                    </td>
                      
                      <td>Rp <?php echo $hargasatuan_f ?></td>
                      <td><?php echo $qty ?></td>
                      <td><?php echo $totalharga_f ?></A></td>
                    

                            </tr>
  <?php

}
?>
</tbody>
</table>
Grand Total RP <?php echo $grand_total_f ?>
<br><a href="view_order.php">Kembali ke order management</a>

</div>

<?php


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

