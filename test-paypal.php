<?php 

//$customer_page = 1;

//$from_page = "paypal_step1";


require_once("includes/code_header.php"); 


require_once('classes/paypal.class.php');

require_once('classes/order_master.class.php');

require_once('classes/customers.class.php');

require_once('classes/cart.class.php');

require_once("classes/email.class.php");

//require_once("classes/temp_cart.class.php"); 

//$temp_cart = new temp_cart();


$eml_cls = new email();

$submit_action = $_REQUEST['submit_action'];


if($submit_action == "processpayment")

{



	$p = new paypal_class;

	$p->paypal_url = trim($GLOBALS['site_config']['paypal_url']);

	

	$this_script = $GLOBALS['site_config']['site_path']."paypal_step1.php";

	

	$palemail=trim(trim($GLOBALS['site_config']['paypal_email']));



	//if (empty($_GET['action'])) $_GET['action'] = 'process';

	

	if ($_GET['action']=='process') 

	{

		
		
		//print_r($_SESSION);
		$ordnum=$_SESSION['ses_temp_order_id'];

		$amount=$_SESSION['ses_payment_vars']['payable_amt'];
		//exit;



		$p->add_field('business', $palemail);

		$p->add_field('return', $this_script.'?submit_action=processpayment&action=success&ord='.$ordnum);

		$p->add_field('cancel_return', $this_script.'?submit_action=processpayment&action=cancel&ord='.$ordnum);

		$p->add_field('notify_url', $this_script.'?submit_action=processpayment&action=ipn&ord='.$ordnum);

		$p->add_field('return_method', '2');
		
		$p->add_field('currency_code', trim($GLOBALS['site_config']['currency_type']));
		
		$p->add_field('amount', $amount);

		$p->log_payment($ordnum);
		
		$cart_obj->empty_cart();//clears the cart

		unset($_SESSION['ses_temp_consult_obj']);

		$p->submit_paypal_post();

	}
	else if ($_GET['action']=='ipn') {
		
		$redirect_page = 1;

		$cart_obj = new cart();

		

		$ordnum = "";

		$payment_status = "";

		$txn_id = "";

		$business = "";

		$pending_reason = "";

		//print_r($_REQUEST);
		
		foreach ($_REQUEST as $key => $value) 

		{

	$text .=$key." = ".$value. " ";

			if ($key == "ord")

				$ordnum = $value;
/* - 10082007 - commented out, paypal is nto returning the response in these variables in live account */
			if ($key == "tx")

				$txn_id = $value;

			if ($key == "payment_status")

				$payment_status = $value;

			if ($key == "txn_id")

				$txn_id = $value;

			if ($key == "payment_status")

				$payment_status = $value;

			if ($key == "pending_reason")

				$pending_reason = $value;

	

		}

		$redirect_url = "invoice.php?order_id=" . $ordnum;

		if ($ordnum != "") 

		{

				$ord_mobj = new order_master();
				

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

			$ord_mobj->bill_fname['save_todb'] = "false";

			$ord_mobj->bill_lname['save_todb'] = "false";

			$ord_mobj->bill_ads1['save_todb'] = "false";

			$ord_mobj->bill_ads2['save_todb'] = "false";

			$ord_mobj->bill_city['save_todb'] = "false";

			$ord_mobj->bill_state['save_todb'] = "false";

			$ord_mobj->bill_zip['save_todb'] = "false";

			$ord_mobj->bill_country['save_todb'] = "false";

			$ord_mobj->order_id['save_todb'] = "false";

			$ord_mobj->pay_method['save_todb'] = "false";

			$ord_mobj->order_status['save_todb'] = "true";
			
			$ord_mobj->ship_mobile['save_todb'] = "false";

			$ord_mobj->ship_landline['save_todb'] = "false";

			$ord_mobj->bill_mobile['save_todb'] = "false";

			$ord_mobj->bill_landline['save_todb'] = "false";
			
			$ord_mobj->bill_unit['save_todb'] = "false";

			$ord_mobj->bill_building['save_todb'] = "false";

			$ord_mobj->ship_unit['save_todb'] = "false";

			$ord_mobj->ship_building['save_todb'] = "false";
			
			$ord_mobj->bill_email['save_todb'] = "false";



			//non of the above values should be framed in update query..			

				if(strtolower($payment_status) == "completed")

					$st = "1";

				else

					$st = "0";
					
				$paypal_paymentfailed = 0;

				$ord_mobj->order_status['value'] = $st;

				$ord_mobj->trans_id['value'] = $txn_id;

				$ord_mobj->error_reason['value'] = $pending_reason;
				
				
				
				/*$myfile = fopen("payment.txt", "w") or die("Unable to open file!");
				$txt = $update_qry."\n";
				fwrite($myfile, $txt);
				$txt = $text ."\n";
				fwrite($myfile, $txt);
				fclose($myfile); */
				
				
				
				$order_id = $ordnum;

				if(strtolower($payment_status) == "completed")
				{
					/*$_SESSION['ses_email_sent'] =0;
					$order_status = $GLOBALS['db_con_obj']->fetch_field($ord_mobj->cls_tbl,"order_status", "order_id=".$ordnum);
					if($order_status  ==0 && $_SESSION['ses_email_sent'] ==0){
					require_once("forms/order_email.php");
					$_SESSION["ses_pay_com"] = 1;
					$subject = "Your order confirmation & invoice details -1";
					$name = $master_data->bill_fname." ".$master_data->bill_lname;
					$Message = $email_string;
					$to_email =$master_data->bill_email;
					$from_email = "roreply@wayonnet.com";
					$cc_email = trim($GLOBALS['site_config']['admin_email']);
					$eml_cls->pear_mail($subject,$Message,$to_email,$from_email);
					$eml_cls->pear_mail($subject,$Message,$cc_email,$from_email);
					$_SESSION['ses_email_sent']=1;
					} */
					$update_qry = "UPDATE ".$ord_mobj->cls_tbl." SET order_status=". $st.",trans_id='".$txn_id."',error_reason='".$pending_reason."' WHERE order_id=".$ordnum;
					$GLOBALS['db_con_obj']->execute_sql($update_qry,"update");
					
				}	
				else

				{

					$subject = "Your order Failled & invoice details";

					$paypal_paymentfailed = 1;
					
					$email_string = "invoice failed";

				}
				$redirect_url = "invoice/" . $ordnum;

				

		}

		else

		{

			$subject = "Sorry! Your payment has been Failed";
			$email_string = "invoice failed";

			$paypal_paymentfailed = 1;
			
			

		}	
		

		$p->log_payment($order_id);

		$cart_obj->empty_cart();//clears the cart

		unset($_SESSION['ses_temp_consult_obj']);
		
			
			
	}

	else

	{

		

		$redirect_page = 1;

		$cart_obj = new cart();



		$ordnum = "";

		$payment_status = "";

		$txn_id = "";

		$business = "";

		$pending_reason = "";

		//print_r($_REQUEST);
		
		foreach ($_REQUEST as $key => $value) 

		{

		

			if ($key == "ord")

				$ordnum = $value;
/* - 10082007 - commented out, paypal is nto returning the response in these variables in live account */
			if ($key == "tx")

				$txn_id = $value;

			if ($key == "payment_status")

				$payment_status = $value;

			if ($key == "txn_id")

				$txn_id = $value;

			if ($key == "payment_status")

				$payment_status = $value;

			if ($key == "pending_reason")

				$pending_reason = $value;

	

		}

//exit;
		$redirect_url = "invoice.php?order_id=" . $ordnum;

//$GLOBALS['site_config']['debug'] =1;

		if ($ordnum != "") 

		{

				$ord_mobj = new order_master();

				

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

			$ord_mobj->bill_fname['save_todb'] = "false";

			$ord_mobj->bill_lname['save_todb'] = "false";

			$ord_mobj->bill_ads1['save_todb'] = "false";

			$ord_mobj->bill_ads2['save_todb'] = "false";

			$ord_mobj->bill_city['save_todb'] = "false";

			$ord_mobj->bill_state['save_todb'] = "false";

			$ord_mobj->bill_zip['save_todb'] = "false";

			$ord_mobj->bill_country['save_todb'] = "false";

			$ord_mobj->order_id['save_todb'] = "false";

			$ord_mobj->pay_method['save_todb'] = "false";

			$ord_mobj->order_status['save_todb'] = "true";
			
			$ord_mobj->bill_ads2['save_todb'] = "false";
			

			$ord_mobj->ship_mobile['save_todb'] = "false";

			$ord_mobj->ship_landline['save_todb'] = "false";

			$ord_mobj->bill_mobile['save_todb'] = "false";

			$ord_mobj->bill_landline['save_todb'] = "false";
			
			
			$ord_mobj->bill_unit['save_todb'] = "false";

			$ord_mobj->bill_building['save_todb'] = "false";

			$ord_mobj->ship_unit['save_todb'] = "false";

			$ord_mobj->ship_building['save_todb'] = "false";
			
			$ord_mobj->bill_email['save_todb'] = "false";
			


			//non of the above values should be framed in update query..			

				$st = 1;

				
					
				$paypal_paymentfailed = 0;

				$ord_mobj->order_status['value'] = $st;

				$ord_mobj->trans_id['value'] = $txn_id;

				$ord_mobj->error_reason['value'] = $pending_reason;
				
				$GLOBALS['site_config']['debug'] =1;

				$order_status = $GLOBALS['db_con_obj']->fetch_field($ord_mobj->cls_tbl,"order_status","order_id=".$ordnum);

				$order_id = $ordnum;
				//$order_id = $ordnum;
				
				$order_status = $GLOBALS['db_con_obj']->fetch_field($ord_mobj->cls_tbl,"order_status", "order_id=".$ordnum);
				if($order_status  ==1){
				
					$_SESSION['ses_email_sent'] =0;
					$order_status = $GLOBALS['db_con_obj']->fetch_field($ord_mobj->cls_tbl,"order_status", "order_id=".$ordnum);
					if($order_status  ==1 ){
					require_once("forms/order_email.php");
					$_SESSION["ses_pay_com"] = 1;
					$subject = "Your order confirmation & invoice details";
					$name = $master_data->bill_fname." ".$master_data->bill_lname;
					$Message = $email_string;
					$to_email =$master_data->bill_email;
					$from_email = "roreply@wayonnet.com";
					$cc_email = trim($GLOBALS['site_config']['admin_email']);
					$eml_cls->pear_mail($subject,$Message,$to_email,$from_email);
					$eml_cls->pear_mail($subject,$Message,$cc_email,$from_email);
					$_SESSION['ses_email_sent']=1;
					}
					
					$_SESSION["ses_pay_com"] = 1;
					frame_notices("Your payment has been completed.<br>" . $pending_reason, "greenfont");
				}	
				else

				{

					frame_notices("Sorry! Your payment has been Failed.<br>" . $pending_reason, "redfont");

					$paypal_paymentfailed = 1;

				}
				
				echo "Email sent";
				exit;
				$redirect_url = "invoice/" . $ordnum;

				

		}

		else

		{

				$order_status = $GLOBALS['db_con_obj']->fetch_field($ord_mobj->cls_tbl,"order_status", "order_id=".$ordnum);
				if($order_status  ==1){
				
					//require_once("forms/order_email.php");
					$_SESSION["ses_pay_com"] = 1;
					frame_notices("Your payment has been completed.<br>" . $pending_reason, "greenfont");
				}	
				else

				{

					frame_notices("Sorry! Your payment has been Failed.<br>" . $pending_reason, "redfont");

					$paypal_paymentfailed = 1;

				}
				$redirect_url = "invoice/" . $ordnum;

		}

		

		if($paypal_paymentfailed == 1 )

		{		
		  

		}

		

		$p->log_payment($order_id);

		$cart_obj->empty_cart();//clears the cart

		unset($_SESSION['ses_temp_consult_obj']);

	}

}




//exit;
if($redirect_page == 1)

{

	header("location:$redirect_url");

	exit();

}





?>