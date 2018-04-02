<?php
ob_start();
session_id();
session_start();

//$payment_gateway = "paypal_pro"; - not required as on 18062007
$payment_gateway = "paypal";
global $treemenu_pth;
$site_session_id = $_COOKIE['PHPSESSID'];
if(empty($from_page) )
	$from_page="admin";
	
if($from_page == "billing_info" && $_SERVER['SERVER_PORT'] == "443")
{
	$tmp_sesid = $_GET['PHPSESSID'];
	if(strlen(trim($tmp_sesid)) > 0)
	setcookie("PHPSESSID",$tmp_sesid, mktime(date("H"), date("m"), date("i"), date("m"), date("d") + 1, date("Y")));
}

if($from_page == "payment_result" && $_SERVER['SERVER_PORT'] == "443")
	setcookie("PHPSESSID",'', mktime(date("H"), date("m"), date("i"), date("m"), date("d") - 1, date("Y")));

//echo "<font color='#ffffff'>" . session_id() . "</font>";
	
//error_reporting(0);
global $consultations_prod_id;

$consultations_prod_id = array("2hr" => 0, "30min" => 0);

if(file_exists("classes/connections.class.php"))
{
	include("includes/config_settings.php");
	include("includes/subadmin_config_settings.php");
	include("includes/payment_config_settings.php");
	include("includes/gst_config_settings.php");
	require_once("includes/shipment_config_settings.php");
	require_once("includes/project_config_settings.php");
	require_once("includes/template_config_settings.php");
	require_once("includes/menu_config_settings.php");
	require_once("includes/functions.php");
	require_once("classes/logger.class.php");
	require_once("classes/images.class.php");
	require_once("classes/connections.class.php");
	require_once("classes/paging.class.php");
	require_once("classes/matrix.paging.class.php");
	require_once("classes/cart.class.php");
}
else if(file_exists("../classes/connections.class.php"))
{
	include("../includes/config_settings.php");
	include("../includes/subadmin_config_settings.php");
	include("../includes/payment_config_settings.php");
	include("../includes/gst_config_settings.php");
	require_once("../includes/shipment_config_settings.php");
	require_once("../includes/project_config_settings.php");
	require_once("../includes/template_config_settings.php");
	require_once("../includes/menu_config_settings.php");
	require_once("../includes/functions.php");
	require_once("../includes/available_modules.php");
	require_once("../classes/logger.class.php");
	require_once("../classes/images.class.php");
	require_once("../classes/connections.class.php");
	require_once("../classes/paging.class.php");
	require_once("../classes/matrix.paging.class.php");
	require_once("../classes/cart.class.php");
	$treemenu_pth ="../";
}
else if(file_exists("../../classes/connections.class.php"))
{
	include("../../includes/config_settings.php");
	include("../../includes/subadmin_config_settings.php");
	include("../../includes/payment_config_settings.php");
	include("../../includes/gst_config_settings.php");
	require_once("../../includes/shipment_config_settings.php");
	require_once("../../includes/project_config_settings.php");
	require_once("../../includes/template_config_settings.php");
	require_once("../../includes/menu_config_settings.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/available_modules.php");
	require_once("../../classes/logger.class.php");
	require_once("../../classes/images.class.php");
	require_once("../../classes/connections.class.php");
	require_once("../../classes/paging.class.php");
	require_once("../../classes/matrix.paging.class.php");
	require_once("../../classes/cart.class.php");
	$treemenu_pth ="../";
}
else if($from_page == "payaction")
{
	require_once("../../../includes/config_settings.php");
	require_once("../../../includes/subadmin_config_settings.php");
	require_once("../../../includes/payment_config_settings.php");
	require_once("../../../includes/gst_config_settings.php");
	require_once("../../../includes/shipment_config_settings.php");
	require_once("../../../includes/project_config_settings.php");
	require_once("../../../includes/template_config_settings.php");
	require_once("../../../includes/menu_config_settings.php");
	require_once("../../../includes/functions.php");
	require_once("../../../classes/logger.class.php");
	require_once("../../../classes/images.class.php");
	require_once("../../../classes/connections.class.php");
	require_once("../../../classes/paging.class.php");
	require_once("../../../classes/matrix.paging.class.php");
	require_once("../../../classes/cart.class.php");
}



if($from_page == "billing_info" && $_SERVER['SERVER_PORT'] == "443")
{
	$tmp_sesid = $_GET['PHPSESSID'];
	//echo "<hr>" . $tmp_sesid . " - " . $site_session_id . "<hr>";
	if($tmp_sesid != $site_session_id)
	{
		$chkout_url = stripslashes($GLOBALS['site_config']['ssl_url'] . "billing_info.php?PHPSESSID=" . $tmp_sesid);
		//echo $chkout_url . "<hr>";
		header("location:$chkout_url");
		exit();
	}
}


$t_host = $_SERVER['HTTP_HOST'];
$t_url = $_SERVER['REQUEST_URI'];

if(1==2 && substr_count($t_host, "www") <= 0 && $_SERVER['SERVER_PORT'] != 443 && $_SERVER['REMOTE_ADDR'] != "127.0.0.1")
{
	$full_url = "http://www." . $t_host . $t_url;
	header("location:$full_url");
	exit();
}


//Initialize logger object - Start

global $logger_obj, $db_con_obj, $cart_obj;

$logger_obj = new logger();

//Initialize logger object - End

$cart_obj = new cart();

//Establish a database connection - Start

$db_con_obj = new database_manipulation();

//Establish a database connection - End

$old_error_handler = set_error_handler("userErrorHandler");



if($GLOBALS['in_admin'] == 1)

	$inner_table_param = "width=\"95%\" cellpadding='2' cellspacing='3' border='0'";

else

	$inner_table_param = "width=\"100%\" cellpadding='2' cellspacing='3' border='0'";

if(($from_page == "authorize_step1" || $from_page == "paypal_step1") && $_SERVER['SERVER_PORT'] == 443 && !isset($_SESSION['ses_cart_products']))
{
	initialize_session_for_ssl(); //initializes the session from the normal page to ssl page.
/*
	setcookie('PHPSESSID',$_REQUEST['PHPSESSID'],time()+86400);
	$t_url .= "?PHPSESSID=" . $_REQUEST['PHPSESSID'];
	header("location:$t_url");
	exit();
*/	
}

if(file_exists("includes/logincheck.php"))
require_once("includes/logincheck.php");

//login check for admin section - Start

if($GLOBALS['in_admin'] == 1 && $_SESSION['ses_admin_id'] <= 0 && $frm_page != "login")
{
	frame_notices("Please login to continue!");
	header("location:index.php");
	exit();
}

//login check for admin section - End

?>