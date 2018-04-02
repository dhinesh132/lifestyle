<?php 

require_once("header.php"); 
require_once("classes/cart.class.php");
$cart_obj = new cart();

$submit_action = $_REQUEST['submit_action'];
/*if(isset($_SESSION['ses_customer_id']))
$redirect_url = "payment.php";
else
//$redirect_url = "cust_login.php";
$redirect_url = "cust_register.php";*/
$redirect_url = $GLOBALS['site_config']['site_path']."cart";

switch ($submit_action)
{

	case "addtocart":
		$cart_obj->add_product($cart_obj);
		
		
		break;

	case "savecart":
		$cart_obj->update_cart();
		break;

	case "deletecart":
		$cart_obj->delete_product($_REQUEST['del_key']);
		
		break;

	case "save_payment":
		$dis=trim($_REQUEST['dis_coupon']);
		$cart_obj->apply_discount($dis);
		$redirect_url = "payment.php";
		break;
	
	case "apply_promotion":
		$code=trim($_REQUEST['code']);
		$cart_obj->apply_promocode($code);
		
		$redirect_url = $GLOBALS['site_config']['site_path']."cart";
		break;
}//end switch

//print_r($_SESSION);
header("location:$redirect_url");

?>