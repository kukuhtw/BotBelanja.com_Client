<?php

$mySQLserver = "localhost";
$mySQLuser = "root";
$mySQLpassword = '';
$mySQLdefaultdb = "your_database_client";
$host = "yourdomain.com/yourfolder/";
$folderweb="";
$webhook = $host."dashboard/";
$link = mysqli_connect($mySQLserver, $mySQLuser, $mySQLpassword,$mySQLdefaultdb) or die ("Could not connect to MySQL 2");

?>