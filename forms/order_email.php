<?php

require_once("classes/order_master.class.php");
require_once("classes/customers.class.php");
require_once("classes/email.class.php");
require_once("classes/products.class.php");

//$GLOBALS['site_config']['debug'] =1;
$ord_m_obj = new order_master();
$ord_d_obj = new order_details();
$cust_obj = new customers();
$prod_obj = new products();

$temp_order_id = $order_id;

$master_res = $ord_m_obj->fetch_record($temp_order_id);
$detail_res = $ord_d_obj->fetch_flds($ord_d_obj->cls_tbl,"*", "order_id = '" . $temp_order_id . "'");

$master_data = mysql_fetch_object($master_res[0]);

$paymeth = $master_data->pay_method;



require_once("forms/invoice_email_dets.php");

/*$eml_cls = new email();

$email_id = $ord_m_obj->order_email_ids[$paymeth];

$res = $cust_obj->fetch_record($master_data->user_id);
$cust_obj = set_values($cust_obj, "db", $res[0]);

//email class
$eml_cls->frame_email_body($email_id, array("#firstname#", "#lastname#", "#CN#", "#ordercontent#"), array($cust_obj->cust_firstname['value'], $cust_obj->cust_lastname['value'], stripslashes($GLOBALS['site_config']['company_name']), $string));

$eml_cls->send_email($cust_obj->cust_email['value']);*/



//exit();

?>
