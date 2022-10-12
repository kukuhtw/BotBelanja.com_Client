<?php

include("db.php");
include("saatini.php");

$mode= isset($_POST['mode']) ? $_POST['mode'] : '';

$sku= isset($_GET['sku']) ? $_GET['sku'] : '';
if ($sku=="") {
  $sku= isset($_POST['sku']) ? $_POST['sku'] : '';

}


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

<h2>KONTEN EDIT DISINI</h2>
<?php

//echo "<br>sku = ".$sku;
include("../test_API/settings.php");

if ($mode=="editproduct") {
    $sku= isset($_POST['sku']) ? $_POST['sku'] : '';
    $category= isset($_POST['category']) ? $_POST['category'] : '';
    $productname= isset($_POST['productname']) ? $_POST['productname'] : '';
    $deskripsi_satuan= isset($_POST['deskripsi_satuan']) ? $_POST['deskripsi_satuan'] : '';
    $harga= isset($_POST['harga']) ? $_POST['harga'] : '';
    $k1= isset($_POST['k1']) ? $_POST['k1'] : '';
    $is_active= isset($_POST['is_active']) ? $_POST['is_active'] : '';



    $mode=mysqli_escape_string($link,$mode);
    $sku=mysqli_escape_string($link,$sku);
    $category=mysqli_escape_string($link,$category);
    $productname=mysqli_escape_string($link,$productname);
    $deskripsi_satuan=mysqli_escape_string($link,$deskripsi_satuan);
    $harga=mysqli_escape_string($link,$harga);
    $k1=mysqli_escape_string($link,$k1);
    $is_active=mysqli_escape_string($link,$is_active);


  $call_api_update_sku_produk = call_api_update_sku_produk($apps_id,$owner_id,$sku,$category,$productname,$deskripsi_satuan,$harga,$k1,$is_active,$Header_ClientID,$Header_PassKey);

  $json_decode = json_decode($call_api_update_sku_produk,true);


}

$call_api_get_sku_produk = call_api_get_sku_produk($apps_id,$owner_id,$sku,$Header_ClientID,$Header_PassKey);

$json_decode = json_decode($call_api_get_sku_produk,true);

$status=$json_decode["status"];
$result=$json_decode["result"];

//echo "<br>call_api_get_sku_produk = ".$call_api_get_sku_produk;
//echo "<br>status = ".$status;
//echo "<br>result = ".$result;


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
 <h1 class="h3 mb-3 font-weight-normal">EDIT Product</h1>
      <label for="inputText" class="sr-only">SKU</label>
      <input type="hidden" name="sku" class="form-control" value="<?php echo $sku ?>">
      <br>SKU : <?php echo $sku ?>
    
      <p>&nbsp;</p>

      <label for="inputText" class="sr-only">Product Category</label>
      <input type="text" name="category" class="form-control" placeholder="Kategori Produk disini" value="<?php echo $category ?>" required autofocus>
       <small>Product Category harus diisi</small>
      <p>&nbsp;</p>

<label for="inputText" class="sr-only">Product Name</label>
      <input type="text" name="productname" class="form-control" placeholder="Nama Produk disini" value="<?php echo $productname ?>" required autofocus>
       <small>Product Name harus diisi</small>
      <p>&nbsp;</p>


<label for="inputText" class="sr-only">Deskripsi Satuan</label>
      <input type="text" name="deskripsi_satuan" class="form-control" placeholder="Deskripsi Satuan Produk disini" value="<?php echo $deskripsi_satuan ?>" required autofocus>
        <small>Deskripsi Satuan harus diisi</small>
      <p>&nbsp;</p>

<label for="inputText" class="sr-only">Harga Satuan</label>
      <input type="text" name="harga" class="form-control" placeholder="Harga Satuan disini" value="<?php echo $harga ?>" required autofocus>
       <small>Harga Satuan harus diisi</small>
      <p>&nbsp;</p>

<label for="inputText" class="sr-only">Status Active</label>
      <input type="text" name="is_active" class="form-control" placeholder="Status Active disini" value="<?php echo $is_active ?>" required autofocus>
       <small>Status Active Isi dengan 1 atau 0</small>
      <p>&nbsp;</p>
      <p>&nbsp;</p>

    <label for="inputQuestion" class="sr-only">Keyword</label>
      <textarea name="k1" rows="5" cols="60" class="form-control" placeholder="Keyword produk disini" value="<?php echo $k1 ?>" required autofocus><?php echo $k1 ?></textarea>
       <small>Keyword harus diisi</small>
      <p>&nbsp;</p>
    
    <input type="hidden" name="mode" value="editproduct">     
      <button class="btn btn-lg btn-primary btn-block" type="submit" value="Tambah Produk" <?php echo $button_info ?>>EDIT Produk</button>
           
      <p class="mt-5 mb-3 text-muted">&copy; 2020</p>
    </form>
  
</form>



      </div>
      <!-- /.content-wrapper -->
<?php




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




function call_api_update_sku_produk($apps_id,$owner_id,$sku,$category,$productname,$deskripsi_satuan,$harga,$k1,$is_active,$Header_ClientID,$Header_PassKey) {
  
 include("../test_API/settings.php");


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
