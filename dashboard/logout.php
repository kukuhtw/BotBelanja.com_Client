<?php
session_start();
include("settings/usersettings.php");

$_SESSION['sessionloginemailclient']="";
$_SESSION['sessionuserclientfoldername'] ="";

session_destroy();


$_SESSION['sessionloginemailclient']="";

/*
echo"<br>session_destroy()";
echo"<br>session_destroy()";
echo"<br>session_destroy()";
echo"<br>session_destroy()";
*/

$usirkeformlogin="index.php";

?>
<meta http-equiv="refresh"  content="0; url=<?php echo $usirkeformlogin ?>">