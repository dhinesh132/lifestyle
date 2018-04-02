<?php 
require_once("admin_header.php"); 

$_SESSION['ses_prod_id'] = $_REQUEST['prod'];

header("location:product_colours.php");
exit;
?>