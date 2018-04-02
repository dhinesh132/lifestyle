<?php
    $from_page = "paymentapproval_cron";
	require_once("admin_header.php"); 
	require_once("../classes/order_master.class.php");
	//require_once("../classes/order_master.class.php");
	require_once("../classes/email.class.php");
	require_once("../classes/customers.class.php");

	
	$cron_obj=new order_master();
	
	$num_emails = 10; 
		
	$cron_obj->shipment_approval_email($num_emails);
	
	require_once("admin_footer.php"); 
				

?>