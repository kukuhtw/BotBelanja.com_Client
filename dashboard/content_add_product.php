<?php

include("db.php");
include("saatini.php");

$mode= isset($_POST['mode']) ? $_POST['mode'] : '';
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

$display_result="";
if ($mode=="addproduct") {
  include("../test_API/settings.php");

/*  
  echo "<br>mode = ".$mode;
  echo "<br>sku = ".$sku;
echo "<br>category = ".$category;
echo "<br>productname = ".$productname;
echo "<br>deskripsi_satuan = ".$deskripsi_satuan;
echo "<br>harga = ".$harga;
echo "<br>k1 = ".$k1;
echo "<br>is_active = ".$is_active;
echo "<br>owner_id = ".$owner_id;
echo "<br>apps_id = ".$apps_id;
*/


  $call_insert_produk = call_insert_produk($apps_id,$owner_id,$sku,$category,$productname,$deskripsi_satuan,$harga,$k1,$is_active,$Header_ClientID,$Header_PassKey) ;

$json_decode = json_decode($call_insert_produk,true);
$status=$json_decode["status"];
$result=$json_decode["result"];

/*
echo "<br>status = ".$status;
echo "<br>result = ".$result;
*/


$display_result="";
 if ($status!="200") {
    $display_result="<p class='bg-warning text-white'>".$result."</p>";
  }

if ($status=="200") {
    $display_result="<p class='bg-success text-white'>".$result."</p>";
  }

  
  
$link_next="view_product.php";
  ?>
   <meta http-equiv="Refresh" content="10; url='<?php echo $link_next ?>'" />
  <?php

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

<h2>KONTEN ADD PRODUCT</h2>
<?php echo $display_result; ?>


<form method="post">
 <h1 class="h3 mb-3 font-weight-normal">Tambah Product</h1>
      <label for="inputText" class="sr-only">SKU</label>
      <input type="text" name="sku" class="form-control" placeholder="SKU disini" value="" required autofocus>
      <small>SKU harus unik, tidak sama dengan produk lain.</small>
      <p>&nbsp;</p>

      <label for="inputText" class="sr-only">Product Category</label>
      <input type="text" name="category" class="form-control" placeholder="Kategori Produk disini" value="" required autofocus>
      <p>&nbsp;</p>

<label for="inputText" class="sr-only">Product Name</label>
      <input type="text" name="productname" class="form-control" placeholder="Nama Produk disini" value="" required autofocus>
      <p>&nbsp;</p>


<label for="inputText" class="sr-only">Deskripsi Satuan</label>
      <input type="text" name="deskripsi_satuan" class="form-control" placeholder="Deskripsi Satuan Produk disini" value="" required autofocus>
      <p>&nbsp;</p>

<label for="inputText" class="sr-only">Harga Satuan</label>
      <input type="text" name="harga" class="form-control" placeholder="Harga Satuan disini" value="" required autofocus>
      <p>&nbsp;</p>

<label for="inputText" class="sr-only">Status Active</label>
      <input type="text" name="is_active" class="form-control" placeholder="Status Active disini" value="" required autofocus>
       <small>Isi dengan 1 atau 0</small>
      <p>&nbsp;</p>
      <p>&nbsp;</p>

    <label for="inputQuestion" class="sr-only">Keyword</label>
      <textarea name="k1" rows="5" cols="60" class="form-control" placeholder="Keyword produk disini" value="" required autofocus></textarea>
      <p>&nbsp;</p>
    
    <input type="hidden" name="mode" value="addproduct">     
      <button class="btn btn-lg btn-primary btn-block" type="submit" value="Tambah Produk">Tambah Produk</button>
           
      <p class="mt-5 mb-3 text-muted">&copy; 2020</p>
    </form>
  
</form>


      </div>
      <!-- /.content-wrapper -->

<?php


function call_insert_produk($apps_id,$owner_id,$sku,$category,$productname,$deskripsi_satuan,$harga,$k1,$is_active,$Header_ClientID,$Header_PassKey) {
  
  include("../test_API/settings.php");

  $BASE_END_POINT = $BASE_END_POINT_SAAS."API_insert_product.php";

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