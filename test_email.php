<?php 

//$customer_page = 1;

$from_page = "paypal_step1";

require_once("header.php"); 

require_once('classes/paypal.class.php');

require_once('classes/order_master.class.php');

require_once('classes/customers.class.php');

require_once('classes/cart.class.php');

require_once("classes/email.class.php");

require_once("classes/temp_cart.class.php"); 

$temp_cart = new temp_cart();

$eml_cls = new email();

$ordnum = 854;
$order_id = 854;
					
					require_once("forms/order_email.php");
					$_SESSION["ses_pay_com"] = 1;
					$subject = "Your order confirmation & invoice details -test";
					$name = $master_data->bill_fname." ".$master_data->bill_lname;
					$Message = $email_string;
					$to_email =$master_data->bill_email;
					$from_email = "roreply@wayonnet.com";
					$cc_email = trim($GLOBALS['site_config']['admin_email']);
					$eml_cls->pear_mail($subject,$Message,$to_email,$from_email);
					//$eml_cls->pear_mail($subject,$Message,$cc_email,$from_email);
					
					
?>