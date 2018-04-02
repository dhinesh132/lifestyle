<?php

if($customer_page == 1 && $_SESSION['ses_customer_id'] <= 0)
{
	frame_notices("Please login to continue !!","redfont");
	$url = trim($GLOBALS['site_config']['site_path']) . "cust_login.php";
	header("location:$url");
	exit();
}
else if(strtolower(basename($_SERVER['PHP_SELF'])) == "cust_login.php" && $_SESSION['ses_customer_id'] > 0)
{
	$url = trim($GLOBALS['site_config']['site_path']) . "cust_edit_details.php";
	header("location:cust_edit_details.php");
	exit();
}

?>