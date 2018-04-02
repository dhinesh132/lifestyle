<?php 
$from_page = "logout";
require_once("admin_header.php"); 

session_unset();

header("location:index.php");

?>

