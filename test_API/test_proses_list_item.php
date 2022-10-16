<?php


include("settings.php");

$custom_id = "DEMO";
$text_list_item = "3 Aqua 1 Dus is 24 botol 600 ml\n2 LPG 12 Kg\n2 LPG 3 Kg\n5 Aqua Gelas 220 ml\n2 Aqua Botol 600 ml\n";


$call_api_proses_list_item = call_api_proses_list_item($apps_id,$owner_id,$custom_id,$text_list_item,$Header_ClientID,$Header_PassKey);

$json_decode = json_decode($call_api_proses_list_item,true);

$status=$json_decode["status"];
$result=$json_decode["result"];
$custom_id=$json_decode["custom_id"];
$saatini=$json_decode["saatini"];

echo "<br>status : ".$status;
echo "<br>result : ".$result;
echo "<br>custom_id : ".$custom_id;
echo "<br>saatini : ".$saatini;
//echo "<br>call_api_proses_list_item : ".$call_api_proses_list_item;


if ($status!="200") {
    echo "<br>Status :".$status;
    exit;
}

$j = intval(count($json_decode["list_available_product"]));
//echo "<br>j : ".$j;

$jumlah_data_produk_ada =$j;

$jumlah_unavailableproduct=isset($json_decode["list_unavailable_product"][0]["nomorurut"]) ? $json_decode["list_unavailable_product"][0]["nomorurut"] : 0;


$jumlah_data_produk_tidak_ada = intval(count($json_decode["list_unavailable_product"]));




$grand_total=$json_decode["grand_total"];


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
    $send_messages.="\r\n".$nomorurut.". ".$productname;
    $send_messages.="\r\nHarga Satuan : Rp ".number_format($hargasatuan);
    $send_messages.="\r\nJumlah dibeli: ".number_format($qty);
    $send_messages.="\r\nSatuan: ".$deskripsi_satuan;
    $send_messages.="\r\nTotal Harga: ".number_format($totalharga);
    $send_messages.="\r\n";
    
}
$send_messages.="\r\nGrand Total: Rp ".number_format($grand_total);

echo "<br><br>jumlah_data_produk_tidak_ada : ".$jumlah_data_produk_tidak_ada;

if ($jumlah_data_produk_tidak_ada>=2) {
    $send_messages.="\r\n\r\nBarang tidak ada.";
}
if ($jumlah_data_produk_tidak_ada>=1) {
    $send_messages.="\r\n\r\nSemua Barang yang dibeli ada!";

}
for ($i=0;$i<$jumlah_data_produk_tidak_ada;$i++) {
    
    
    $nomorurut=isset($json_decode["list_unavailable_product"][$i]["nomorurut"]) ? $json_decode["list_unavailable_product"][$i]["nomorurut"] : '';

        

    $unavailable_product=isset($json_decode["list_unavailable_product"][$i]["unavailable_product"]) ? $json_decode["list_unavailable_product"][$i]["unavailable_product"] : '';


    $send_messages.="\r\n".$nomorurut.". ".$unavailable_product;
    
}

$text_list_item_html=$text_list_item;
$text_list_item_html=str_replace("\r\n","<br>",$text_list_item_html);

echo $send_messages;
$send_messages=str_replace("\r\n","%0a",$send_messages);
//$send_messages=nl2br($send_messages);

$html = $send_messages;
$html=str_replace("%0a","<br>",$html);

echo "<br><br>Pesan : <br>".$text_list_item_html;
echo "<br><br>hasil : ".$html;



/*
content: {
    "status": "200",
    "result": "Sukses!",
    "randomsession": 788360,
    "apps_id": "1",
    "owner_id": "1",
    "owner_email": "kukuhtw@gmail.com",
    "owner_whatsapp": "628129893706",
    "custom_id": "DEMO2",
    "saatini": "2022\/10\/03 19:23:46",
    "list_available_product": [{
        "nomorurut": 1,
        "cartid": "143",
        "cartdate": "2022-10-03 19:23:46",
        "score": "6",
        "SKU": "B009",
        "productname": "jeruk pamelo ( bali) perbuah",
        "user_command": "6 jeruk pamelo",
        "deskripsi_satuan": "per 1 buah",
        "hargasatuan": "35000",
        "qty": "6.000000000",
        "totalharga": "210000"
    }, {
        "nomorurut": 2,
        "cartid": "144",
        "cartdate": "2022-10-03 19:23:46",
        "score": "4",
        "SKU": "B005",
        "productname": "Jeruk Kupas Mandarin Wokam Wo Kam 1kg Import ",
        "user_command": "2 jeruk kupas",
        "deskripsi_satuan": "per 1 kg",
        "hargasatuan": "56000",
        "qty": "2.000000000",
        "totalharga": "112000"
    }, {
        "nomorurut": 3,
        "cartid": "145",
        "cartdate": "2022-10-03 19:23:46",
        "score": "4",
        "SKU": "B008",
        "productname": "JERUK KUPAS AUSTRALIA ORANGE AFFOURER SEEDLESS FRESH IMPORT PER 1 Kg",
        "user_command": "2 jeruk kupas",
        "deskripsi_satuan": "per 1 kg",
        "hargasatuan": "70000",
        "qty": "2.000000000",
        "totalharga": "140000"
    }, {
        "nomorurut": 4,
        "cartid": "147",
        "cartdate": "2022-10-03 19:23:46",
        "score": "8",
        "SKU": "M001",
        "productname": "Indomie Goreng 1 dus isi 40 pcs",
        "user_command": "2 Indomie Goreng 1 dus isi 40 pcs",
        "deskripsi_satuan": "per 40 pcs",
        "hargasatuan": "118500",
        "qty": "2.000000000",
        "totalharga": "237000"
    }, {
        "nomorurut": 5,
        "cartid": "142",
        "cartdate": "2022-10-03 19:23:46",
        "score": "7",
        "SKU": "AQ005",
        "productname": "AQUA Botol 330 ml (isi 12)",
        "user_command": "2 box Aqua 330 ml",
        "deskripsi_satuan": "perbox isi 12 botol 300ml",
        "hargasatuan": "37500",
        "qty": "2.000000000",
        "totalharga": "75000"
    }, {
        "nomorurut": 6,
        "cartid": "148",
        "cartdate": "2022-10-03 19:23:46",
        "score": "10",
        "SKU": "T001",
        "productname": "Telur Ayam Kampung Best Value isi 30 butir",
        "user_command": "1 telur ayam kampung isi 30",
        "deskripsi_satuan": "per 30 butir",
        "hargasatuan": "79900",
        "qty": "1.000000000",
        "totalharga": "79900"
    }, {
        "nomorurut": 7,
        "cartid": "146",
        "cartdate": "2022-10-03 19:23:46",
        "score": "4",
        "SKU": "M003",
        "productname": "INDOMIE MIE GORENG 10 bungkus",
        "user_command": "1 INDOMIE MIE GORENG 10 bungkus",
        "deskripsi_satuan": "per 10 bungkus",
        "hargasatuan": "28750",
        "qty": "1.000000000",
        "totalharga": "28750"
    }, {
        "nomorurut": 8,
        "cartid": "141",
        "cartdate": "2022-10-03 19:23:46",
        "score": "12",
        "SKU": "AQ001",
        "productname": "AQUA Botol 600 ml",
        "user_command": "1 botol Aqua 600 ml",
        "deskripsi_satuan": "per botol 600 ml",
        "hargasatuan": "3500",
        "qty": "1.000000000",
        "totalharga": "3500"
    }],
    "grand_total": {
        "grand_total": 886150
    },
    "list_unavailable_product": [{
        "nomor": 1,
        "unavailable_product": "1 iphone 13max"
    }, {
        "nomor": 2,
        "unavailable_product": "1 ipad 2"
    }]
}
*/

function call_api_proses_list_item($apps_id,$owner_id,$custom_id,$text_list_item,$Header_ClientID,$Header_PassKey) {
    
    include("settings.php");

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
