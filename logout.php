<?php 

require_once("header.php");
require_once("classes/cart.class.php");

$cart_obj = new cart();
session_destroy();
$cart_obj->empty_cart();
header("location:index.php");
exit();

?>