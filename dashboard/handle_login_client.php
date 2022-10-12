<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
include("db.php");
include("function_dashboard.php");
include("dashboard_akses.php");


//$cookies_visitor = isset($_COOKIE['cookies_visitor']) ? $_COOKIE['cookies_visitor'] : '';
//echo"<br>cookies_visitor=".$cookies_visitor;

$mode = isset($_POST['mode']) ? $_POST['mode'] : '';
$loginemailclient = isset($_POST['loginemailclient']) ? $_POST['loginemailclient'] : '';
$loginpasswordclient = isset($_POST['loginpasswordclient']) ? $_POST['loginpasswordclient'] : '';

$status_boleh_login=0;

echo "<br>loginemailclient = ".$loginemailclient;
echo "<br>loginpasswordclient = ".$loginpasswordclient;

echo "<br>default_login_email = ".$default_login_email;
echo "<br>default_login_password = ".$default_login_password;


if ($mode=="loginclient") {
	$loginemailclient = clear_variable_post_get($link,$loginemailclient);
	$passwordclient=$loginpasswordclient;
	$status_boleh_login=0;
	if ($loginemailclient==$default_login_email) {
		if ($passwordclient==$default_login_password) {
			$status_boleh_login=1;
		}
	}


	echo "<br>status_boleh_login = ".$status_boleh_login;
	
	if ($status_boleh_login==1) {
	$_SESSION['sessionloginemailclient'] = $loginemailclient;
	$_SESSION['sessionloginemailclient'] = $loginemailclient;
	$_SESSION['sessionloginemailclient'] = $loginemailclient;
	$_SESSION['sessionloginemailclient'] = $loginemailclient;
	?>
    <meta http-equiv="refresh"  content="0; url=dashboard_index.php">
	<?php
	exit;
	}
	else {
	?>
	<meta http-equiv="refresh"  content="0; url=index.php">
	<?php
	echo "<br>Password Salah ! atau username tidak ada !";
	mysqli_close($link); 
	}


}

?>