<?php

require_once("classes/order_master.class.php");
require_once("classes/cart.class.php");

$cart_obj = new cart();

//$consult_obj = new consultations();

$ord_master_obj = new order_master();


$ord_master_obj->user_id['value'] = $_SESSION['ses_customer_id'];
$ship_arr = explode("|-|", $_SESSION['ses_cart_shipping_method']);
$ord_master_obj->shipping_cost['value'] = $_SESSION['ses_cart_shipping_cost'];
$ord_master_obj->ship_method['value'] = trim($ship_arr[1]);
$ord_master_obj->tax_collected['value'] = $_SESSION['ses_tax_con'];

if(isset($_REQUEST['payable_amt']))
	$temp_pay_amt = $_REQUEST['payable_amt'];
else
	$temp_pay_amt = $_SESSION['ses_payment_vars']['payable_amt'];

$ord_master_obj->payable_amount['value'] = $temp_pay_amt;

$ord_master_obj->discount_amount['value'] = $_SESSION['ses_dis_amt'];
$ord_master_obj->giftcertificate_amt['value'] = 0;
$ord_master_obj->giftcert_id['value'] = 0;
$ord_master_obj->discount_id['value'] = $_SESSION['ses_dis_auto_id'];
$ord_master_obj->handling_msg['value'] = $_SESSION['ses_ship_bill_arr']['handling_msg'];
$ord_master_obj->callback_number['value'] = $_REQUEST['callbck_number'];

if(isset($_REQUEST['payment_method']))
	$temp_pay_meth = $_REQUEST['payment_method'];
else
	$temp_pay_meth = $_SESSION['ses_payment_vars']['payment_method'];
$ord_master_obj->pay_method['value'] = $temp_pay_meth;

if($from_page == "authorize_step1")
{
	$ord_master_obj->order_status['value'] = $ord_status;
}
else
	$ord_master_obj->order_status['value'] = "0";//based on payment method selected this should be reset..

$ord_master_obj->approved_dt['value'] = date("Y-m-d H:i:s");
$ord_master_obj->shipment_appdt['value'] = "";
$ord_master_obj->cancel_dt['value'] = "";
$ord_master_obj->date_entered['value'] = date("Y-m-d H:i:s");

//frame shipping address - Start

$ord_master_obj->ship_fname['value'] = $_SESSION['ses_ship_bill_arr']['fname'];
$ord_master_obj->ship_lname['value'] = $_SESSION['ses_ship_bill_arr']['lname'];
$ord_master_obj->ship_ads1['value'] = $_SESSION['ses_ship_bill_arr']['saddress1'];
$ord_master_obj->ship_ads2['value'] = $_SESSION['ses_ship_bill_arr']['saddress2'];	
$ord_master_obj->ship_unit['value'] = $_SESSION['ses_ship_bill_arr']['sunit'];
$ord_master_obj->ship_building['value'] = $_SESSION['ses_ship_bill_arr']['sbuilding'];	
$ord_master_obj->ship_mobile['value'] = $_SESSION['ses_ship_bill_arr']['mobile'];
$ord_master_obj->ship_landline['value'] = $_SESSION['ses_ship_bill_arr']['landline'];
$ord_master_obj->ship_city['value'] = $_SESSION['ses_ship_bill_arr']['city'];
$ord_master_obj->ship_state['value'] = $_SESSION['ses_ship_bill_arr']['state'];
$ord_master_obj->ship_zip['value'] = $_SESSION['ses_ship_bill_arr']['zip'];
$ord_master_obj->ship_country['value'] = $_SESSION['ses_ship_bill_arr']['country'];
$ord_master_obj->ship_email['value'] = $_SESSION['ses_ship_bill_arr']['email']; //$_REQUEST['shipment_email']; //$_SESSION['ses_ship_bill_arr']['ship_email'];

//frame shipping address - End

//frame billing address - Start
if($from_page == "authorize")
{
	$ord_master_obj->bill_fname['value'] = $_REQUEST['bfname'];
	$ord_master_obj->bill_lname['value'] = $_REQUEST['blname'];
	$ord_master_obj->bill_ads1['value'] = $_REQUEST['baddress1'];
	$ord_master_obj->bill_ads2['value'] = $_REQUEST['baddress2'];	
	$ord_master_obj->bill_mobile['value'] = $_REQUEST['bmobile'];
	$ord_master_obj->bill_landline['value'] = $_REQUEST['blandline'];
	$ord_master_obj->bill_city['value'] = $_REQUEST['bcity'];
	$ord_master_obj->bill_state['value'] = $_REQUEST['bstate'];
	$ord_master_obj->bill_zip['value'] = $_REQUEST['bzip'];
	$ord_master_obj->bill_country['value'] = $_REQUEST['bcountry'];
}
else
{
	$ord_master_obj->bill_fname['value'] = $_SESSION['ses_ship_bill_arr']['bfname'];
	$ord_master_obj->bill_lname['value'] = $_SESSION['ses_ship_bill_arr']['blname'];
	$ord_master_obj->bill_ads1['value'] = $_SESSION['ses_ship_bill_arr']['baddress1'];
	$ord_master_obj->bill_ads2['value'] = $_SESSION['ses_ship_bill_arr']['baddress2'];
	$ord_master_obj->bill_unit['value'] = $_SESSION['ses_ship_bill_arr']['bunit'];
	$ord_master_obj->bill_building['value'] = $_SESSION['ses_ship_bill_arr']['bbuilding'];	
	$ord_master_obj->bill_mobile['value'] = $_SESSION['ses_ship_bill_arr']['bmobile'];
	$ord_master_obj->bill_landline['value'] = $_SESSION['ses_ship_bill_arr']['blandline'];
	$ord_master_obj->bill_city['value'] = $_SESSION['ses_ship_bill_arr']['bcity'];
	$ord_master_obj->bill_state['value'] = $_SESSION['ses_ship_bill_arr']['bstate'];
	$ord_master_obj->bill_zip['value'] = $_SESSION['ses_ship_bill_arr']['bzip'];
	$ord_master_obj->bill_country['value'] = $_SESSION['ses_ship_bill_arr']['bcountry'];
	$ord_master_obj->bill_email['value'] = $_SESSION['ses_ship_bill_arr']['bemail'];
}

//frame billing address - End

//print_r($_SESSION['ses_ship_bill_arr']);

if($from_page == "authorize_step1")
$ord_master_obj->error_reason['value'] = $reason_txt;

$temp_res = $ord_master_obj->insert();

$order_id = $temp_res[2];

$qry = "update " . $ord_master_obj->cls_tbl . " set bill_ipaddress = '" . wrap_values($_SERVER['REMOTE_ADDR']) . "' where " . $ord_master_obj->primary_fld . " = '" . $order_id . "'";

$res = $GLOBALS['db_con_obj']->execute_sql($qry, "update");

//28062007 - save consultation info - Start
/*if(check_consultation_exists())
{
	$existing_consult = "";	
	foreach($_SESSION['ses_cart_items'] as $key => $value)
	{
		if($GLOBALS['consultations_prod_id']['2hr'] == $value['prod_id'] || $GLOBALS['consultations_prod_id']['30min'] == $value['prod_id'])
		{
			$_SESSION['ses_temp_consult_obj']['consultation_type'] = $value['prod_id'];
			$_SESSION['ses_temp_consult_obj']['order_id'] = $order_id;
		
			//$temp_consult_res = $consult_obj->insert("ses", $_SESSION['ses_temp_consult_obj']);
		}
	}
	
}*/
//28062007 - save consultation info - End


$pay_met = $_SESSION['ses_pay_meth'];
$temp_meth = $_SESSION['ses_payment_method'];
if($temp_meth != 4 )
{
$cart_obj->empty_cart();//clears the cart
require_once("forms/order_email.php");//send email for the order after payment has been made.
}

?>