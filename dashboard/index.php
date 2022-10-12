<?php
session_start();
/*
*/
?>

<!DOCTYPE html>
<?php

$cookies_visitor = isset($_COOKIE['cookies_visitor']) ? $_COOKIE['cookies_visitor'] : '';


if ($cookies_visitor=="") {
	$durationcookies = 3600 * 24 * 30 * 12 * 10 ;  // 10 tahun
	$cookies_visitor=rand(1111,9999)."-".rand(1111,9999)."-".rand(1111,9999);
	setcookie("cookies_visitor", $cookies_visitor, time()+$durationcookies);
	$cookies_visitor = isset($_COOKIE['cookies_visitor']) ? $_COOKIE['cookies_visitor'] : '';
	//echo"<br>Now cookies_visitor=".$cookies_visitor;

}
?>
<html lang="en">
 <?php include("head_register.php") ?>
  <body class="bg-dark">
   <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">Login client</div>
        <div class="card-body">
          <?php 
          include("handle_login_client.php") ;
          include("form_login_client.php") ;
          ?>
       
          <div class="text-center">
            <a class="d-block small mt-3" href="index.php">Home</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  </body>

</html>
