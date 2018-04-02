<?php

require_once("classes/order_master.class.php");
require_once("classes/cart.class.php");
$ord_mobj = new order_master();
$ordnum = $_REQUEST['repay_oid'];
$ord_mobj->user_id['save_todb'] = "false";
$ord_mobj->shipping_cost['save_todb'] = "false";
$ord_mobj->ship_method['save_todb'] = "false";
$ord_mobj->tax_collected['save_todb'] = "false";
$ord_mobj->payable_amount['save_todb'] = "false";
$ord_mobj->discount_amount['save_todb'] = "false";
$ord_mobj->giftcertificate_amt['save_todb'] = "false";
$ord_mobj->giftcert_id['save_todb'] = "false";
$ord_mobj->discount_id['save_todb'] = "false";
$ord_mobj->handling_msg['save_todb'] = "false";
$ord_mobj->callback_number['save_todb'] = "false";
$ord_mobj->approved_dt['save_todb'] = "false";
$ord_mobj->shipment_appdt['save_todb'] = "false";
$ord_mobj->cancel_dt['save_todb'] = "false";
$ord_mobj->date_entered['save_todb'] = "false";
$ord_mobj->ship_fname['save_todb'] = "false";
$ord_mobj->ship_lname['save_todb'] = "false";
$ord_mobj->ship_ads1['save_todb'] = "false";
$ord_mobj->ship_ads2['save_todb'] = "false";
$ord_mobj->ship_city['save_todb'] = "false";
$ord_mobj->ship_state['save_todb'] = "false";
$ord_mobj->ship_zip['save_todb'] = "false";
$ord_mobj->ship_country['save_todb'] = "false";
$ord_mobj->ship_email['save_todb'] = "false";
$ord_mobj->bill_fname['save_todb'] = "true";
$ord_mobj->bill_lname['save_todb'] = "true";
$ord_mobj->bill_ads1['save_todb'] = "true";
$ord_mobj->bill_ads2['save_todb'] = "true";
$ord_mobj->bill_city['save_todb'] = "true";
$ord_mobj->bill_state['save_todb'] = "true";
$ord_mobj->bill_zip['save_todb'] = "true";
$ord_mobj->bill_country['save_todb'] = "true";
$ord_mobj->order_id['save_todb'] = "false";
$ord_mobj->pay_method['save_todb'] = "false";
$ord_mobj->order_status['save_todb'] = "true";
$ord_mobj->trans_id['save_todb'] = "false";

//non of the above values should be framed in update query..			

$ord_mobj->bill_fname['value'] = $_REQUEST['bfname'];
$ord_mobj->bill_lname['value'] = $_REQUEST['blname'];
$ord_mobj->bill_ads1['value'] = $_REQUEST['baddress1'];
$ord_mobj->bill_ads2['value'] = $_REQUEST['baddress2'];
$ord_mobj->bill_city['value'] = $_REQUEST['bcity'];
$ord_mobj->bill_state['value'] = $_REQUEST['bstate'];
$ord_mobj->bill_zip['value'] = $_REQUEST['bzip'];
$ord_mobj->bill_country['value'] = $_REQUEST['bcountry'];
$ord_mobj->order_status['value'] = $ord_status;
$ord_mobj->error_reason['value'] = $reason_txt;

$ord_mobj->update($ordnum);
$order_id = $ordnum;
require_once("forms/order_email.php");

?>