<?php

include("db.php");
include("saatini.php");

$mode= isset($_POST['mode']) ? $_POST['mode'] : '';

$sku= isset($_GET['sku']) ? $_GET['sku'] : '';
if ($sku=="") {
  $sku= isset($_POST['sku']) ? $_POST['sku'] : '';

}

$display_result="";
$sku=mysqli_escape_string($link,$sku);

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

<h2>KONTEN HAPUS DISINI</h2>
<?php

//echo "<br>sku = ".$sku;
include("../test_API/settings.php");

if ($mode=="hapusproduct") {
    $sku= isset($_POST['sku']) ? $_POST['sku'] : '';
  $call_delete_sku_produk = call_delete_sku_produk($apps_id,$owner_id,$sku,$Header_ClientID,$Header_PassKey);
  $link_next="view_product.php";

  $json_decode = json_decode($call_delete_sku_produk,true);

$status=$json_decode["status"];
$result=$json_decode["result"];

$display_result="";
$button_info="";
 if ($status!="200") {
    $display_result="<p class='bg-warning text-white'>".$result."</p>";
    $button_info="disabled";
  }

if ($status=="200") {
    $display_result="<p class='bg-success text-white'>".$result."</p>";
    $button_info="enabled";
  }

 echo $display_result; 


  ?>
   <meta http-equiv="Refresh" content="20; url='<?php echo $link_next ?>'" />
  <?php

}

$call_api_get_sku_produk = call_api_get_sku_produk($apps_id,$owner_id,$sku,$Header_ClientID,$Header_PassKey);

$json_decode = json_decode($call_api_get_sku_produk,true);

$status=$json_decode["status"];
$result=$json_decode["result"];


$display_result="";
$button_info="";
 if ($status!="200") {
    $display_result="<p class='bg-warning text-white'>".$result."</p>";
    $button_info="disabled";
  }

if ($status=="200") {
    $display_result="<p class='bg-success text-white'>".$result."</p>";
    $button_info="enabled";
  }

 echo $display_result; 


$i=0;
$sku =isset($json_decode["product"][$i]["sku"]) ? $json_decode["product"][$i]["sku"] : '' ;
$category = isset($json_decode["product"][$i]["category"]) ? $json_decode["product"][$i]["category"] : '';
$productname = isset($json_decode["product"][$i]["productname"]) ? $json_decode["product"][$i]["productname"] : '';
$deskripsi_satuan = isset($json_decode["product"][$i]["deskripsi_satuan"]) ? $json_decode["product"][$i]["deskripsi_satuan"] : '';
$harga = isset($json_decode["product"][$i]["harga"]) ? $json_decode["product"][$i]["harga"] : '';
$k1 = isset($json_decode["product"][$i]["k1"]) ? $json_decode["product"][$i]["k1"] : '';
$is_active = isset($json_decode["product"][$i]["is_active"]) ? $json_decode["product"][$i]["is_active"] : '';





?>


<form method="post">
 <h1 class="h3 mb-3 font-weight-normal">HAPUS Product</h1>
     <label for="inputText" class="sr-only">SKU</label>
      <input type="hidden" name="sku" class="form-control" value="<?php echo $sku ?>">
      <br>SKU : <?php echo $sku ?>
    
      <p>&nbsp;</p>
      <label for="inputText" class="sr-only">Product Category</label>
      <input type="hidden" name="category">
      <br>category : <?php echo $category ?>
      <p>&nbsp;</p>

<label for="inputText" class="sr-only">Product Name</label>
      <input type="hidden" name="productname" class="form-control" placeholder="Nama Produk disini" value="<?php echo $productname ?>" required autofocus>
      <br>Product Name: <?php echo $productname ?>
      <p>&nbsp;</p>


<label for="inputText" class="sr-only">Deskripsi Satuan</label>
      <input type="hidden" name="deskripsi_satuan">
       <br>Product Name: <?php echo $deskripsi_satuan ?>
      <p>&nbsp;</p>

<label for="inputText" class="sr-only">Harga Satuan</label>
      <input type="hidden" name="harga">
      <br>Harga Satuan: <?php echo $harga ?>
      <p>&nbsp;</p>

<label for="inputText" class="sr-only">Status Active</label>
      <input type="hidden" name="is_active" >
    <br>Status Active: <?php echo $is_active ?>
      <p>&nbsp;</p>

    <label for="inputQuestion" class="sr-only">Keyword</label>
    <input type="hidden" name="k1" >
     <br>Keyword : <?php echo $k1 ?>
       <small>Keyword harus diisi</small>
      <p>&nbsp;</p>
    
    <input type="hidden" name="mode" value="hapusproduct">     
      <button class="btn btn-lg btn-primary btn-block" type="submit" value="Tambah Produk" <?php echo $button_info ?>>Hapus Produk</button>
           
      <p class="mt-5 mb-3 text-muted">&copy; 2020</p>
    </form>
  
</form>



      </div>
      <!-- /.content-wrapper -->
<?php




function call_delete_sku_produk($apps_id,$owner_id,$sku,$Header_ClientID,$Header_PassKey) {
  
  include("../test_API/settings.php");

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
  
  //echo "<br>BASE_END_POINT: ".$BASE_END_POINT;
  //echo "<br>headers: ".json_encode($headers);
  //echo "<br>postData: ".json_encode($postData);
  //echo "<br>content: ".$content;
  //echo "<br>json: ".$json;
  
  $content_results = $content;
  curl_close($ch);

  return $content;
}


function call_api_get_sku_produk($apps_id,$owner_id,$sku,$Header_ClientID,$Header_PassKey) {
  
  
  include("../test_API/settings.php");

  $BASE_END_POINT = $BASE_END_POINT_SAAS."API_get_sku_product.php";

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
