<?php
include("sessionclient.php");
?>
<!DOCTYPE html>
<html lang="en">

<?php
include("head_dashboard.php");
?>
  <body id="page-top">
<?php
include("nav_dashboard.php");
?>

   <div id="wrapper">
     <!-- Sidebar -->
<?php
include("sidebar_dashboard.php");
include("content_view_order_detail.php");

?>
    </div>
    
    <!-- /#wrapper -->
<?php
include("scrollup_icon_dashboard.php");
include("logout_modal_dashboard.php");
include("footer_javascript.php") 

?>
  </body>

</html>
