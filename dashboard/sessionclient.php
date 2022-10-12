<?php
session_start();
$cookies_visitor = isset($_COOKIE['cookies_visitor']) ? $_COOKIE['cookies_visitor'] : '';
$sessionloginemailclient = isset($_SESSION['sessionloginemailclient']) ? $_SESSION['sessionloginemailclient'] : '';

//echo"<br>cookies_visitor  =".$cookies_visitor;
//echo"<br>sessionloginemailclient  =".$sessionloginemailclient;

if ($sessionloginemailclient=="") {
	//echo "kickout";
	$usirkeformlogin="..client/".$userclientfoldername."/login_client.php";
	$usirkeformlogin="login_client.php";
	?>
	<meta http-equiv="refresh"  content="0; url=<?php echo $usirkeformlogin ?>">
  <?php
}


?>
     