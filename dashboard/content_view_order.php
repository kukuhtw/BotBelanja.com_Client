<?php
 error_reporting(error_reporting() & ~E_NOTICE);
include("../db.php");
include("saatini.php");


$mode= isset($_POST['mode']) ? $_POST['mode'] : '';
$orderid= isset($_POST['orderid']) ? $_POST['orderid'] : '';
$catatan= isset($_POST['catatan']) ? $_POST['catatan'] : '';
$edit_status_is_paid= isset($_POST['edit_status_is_paid']) ? $_POST['edit_status_is_paid'] : '';


$mode=mysqli_escape_string($link,$mode);
$catatan=mysqli_escape_string($link,$catatan);
$orderid=mysqli_escape_string($link,$orderid);


if ($mode=="setstatusorder") {
  if ($edit_status_is_paid=="1") {
    $paid_date=$saatini;
  $sql = "update `order` 
  set `is_paid`='$edit_status_is_paid' ,
  `paid_date`='$paid_date'
  where `id`='$orderid' ";
  $query = mysqli_query($link,$sql)or die ('gagal insert transaction_hits '.mysqli_error($link));
    $query=null;  
    // echo "<br>sql = ".$sql;


  }
  $sql = "update `order` 
  set `is_paid`='$edit_status_is_paid' ,
  `catatan`='$catatan'
  where `id`='$orderid' ";

  //echo "<br>sql = ".$sql;

  $query = mysqli_query($link,$sql)or die ('gagal insert transaction_hits '.mysqli_error($link));
    $query=null;  

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
                      <th>Order ID</th>
                      <th>Order Date</th>
                      
                      <th>Data Pembeli</th>
                      <th>Grand Total</th>
                      <th>View Detail</th>
                      <th>Sudah Bayar/Belum</th>
                      
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                     <th>No</th>
                      <th>Order ID</th>
                      <th>Order Date</th>
                      
                      <th>Data Pembeli</th>
                      <th>Grand Total</th>
                      <th>View Detail</th>
                      <th>Sudah Bayar/Belum</th>
                            </tr>
                  </tfoot>
                  <tbody>


<?php
include("../test_API/settings.php");

$display_result="";
$sql = "select * from `order` where `apps_id`='$apps_id' and `owner_id`='$owner_id' order by id desc";

//echo "<Br>sql = ".$sql;
 $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            );
            $conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $fieldvalue="";
            $rt=0;
            foreach($conn->query($sql) as $row) {
               $rt=$rt+1;
               $id=$row['id'];
                $orderdate=$row['orderdate'];
                
                 $namapembeli=$row['namapembeli'];
                
                 $alamatkirim=$row['alamatkirim'];
                 $emailpembeli=$row['emailpembeli'];
                $namapembeli=$row['namapembeli'];
                $wapembeli=$row['wapembeli'];
                $grandtotal=$row['grandtotal'];
                $grandtotal_f=number_format($grandtotal);
                $is_paid=$row['is_paid'];
                $paid_date=$row['paid_date'];
                $catatan=$row['catatan'];

               
  ?>
    <tr>
                       <td><?php echo $rt ?></td>
                      <td><?php echo $id ?></td>
                      <td><?php echo $orderdate ?></td>
                      
                      <td>
                        Nama Pembeli :<?php echo $namapembeli ?>
                        <br>Email Pembeli : <?php echo $emailpembeli ?>
                        <br>Wa Pembeli :  <?php echo $wapembeli ?>
                        <br>Alamat Kirim : <?php echo $alamatkirim ?>
                        

                      </td>
                      <td><?php echo $grandtotal_f ?></td>
                      <td><A href="view_order_detail.php?orderid=<?php echo $id ?>">DETAIL DISINI</A></td>
                      <td>
                        <br><?php echo $is_paid ?>
<br><?php echo $paid_date ?>
<br>Status : <?php echo $is_paid ?>

                            <form method="post">
                              <select name="edit_status_is_paid">
                                <option value="-1" <?php echo isoptionselected(-1,$is_paid) ?> > Cancel</option>
                                <option <?php echo isoptionselected(0,$is_paid) ?>  value="0" > Belum Bayar</option>
                                <option value="1" <?php echo isoptionselected(1,$is_paid) ?> > Sudah Bayar</option>
                            </select>
                            <br>catatan:
                            <br><textarea name="catatan"><?php echo $catatan ?></textarea>
                            <br><input type="hidden" name="mode" value="setstatusorder">
                            <br><input type="hidden" name="orderid" value="<?php echo $id ?>">
                            
                            <br><input type="submit" name="Set Order Status">
                            </form>                    

                      </td>

                            </tr>
  <?php

}

?>

</tbody>
</table>
</div>

<?php

function isoptionselected($v1,$v2) {
  //echo "<br>v1 =".$v1. ". ";
  //echo "<br>v2 =".$v2. ". ";;
  
  if ($v1==$v2) {
    //echo "<br>harusnay selected ";
    return "SELECTED";
  }
  else {
    return "";
  }

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

