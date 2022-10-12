<?php
$mySQLserver = "localhost";
$mySQLuser = "root";
$mySQLpassword = "";
$mySQLdefaultdb = "invoice_belanja_client";
$host = "localhost/invoice_belanja_client/";
$folderweb="";
$webhook = $host."dashboard/";

$link = mysqli_connect($mySQLserver, $mySQLuser, $mySQLpassword,$mySQLdefaultdb) or die ("Could not connect to MySQL");

include("../test_API/settings.php");

?>