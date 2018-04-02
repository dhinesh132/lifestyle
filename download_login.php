<?php 

require_once("header.php"); 
session_unset();
$_SESSION['ses_download_login'] = 1;


foreach($_REQUEST as $key => $val)
$_SESSION['ses_download_vars'][$key] = $val;

//frame_notices("Login to your account and download your ebook !!", "greenfont");

header("location:cust_login.php");
//header("location:download_register.php");
exit();

?>