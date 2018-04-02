<?php 

require_once("admin_header.php"); 
require_once("../classes/product_master.class.php");



$ser_obj=new product_master();

$submit_action = $_REQUEST['submit_action'];
//echo $_REQUEST['ordnum'];

$frm_pag=$_REQUEST['frm'];

switch ($submit_action)
{

	case "search":
	if($frm_pag!="")
	{
	require_once("../classes/product_master.class.php");
	$ser_obj=new product_master();
	$arr_res=$ser_obj->search_query();
	$_SESSION['ses_frame_srch_qry'] = $arr_res;
	header("location:frame_search.php");
	exit();
	}
	else
	{
	
	$arr_res=$ser_obj->search_query();
	$_SESSION['ses_frame_srch_qry'] = $arr_res;
	header("location:frame_search.php");
	exit();
	break;
	
	}
	

	case "clear":
		echo $_SESSION['ses_cust_srch_qry'];
		unset($_SESSION['ses_cust_srch_qry']);
		unset($_SESSION['ses_cust_srch_vars']);
	break;
	
	//Change the order status from Payment pending into Shipment pending--START CODE	
	
	case "mrkpaid":
		foreach($_REQUEST['ordnum'] as $key => $val)
			{
			//echo $val."<br>\n";
			$res = $ser_obj->fetch_record($val);
			
				if( $res[1] >0 )
				
				{
				
		$prod_res1 = $ord_d_obj->fetch_flds("order_details","*", "order_id = '" .$val . "'");

		while($prod_data1 = mysql_fetch_object($prod_res1[0])) 
		  {
		 
		$category_id = $GLOBALS['db_con_obj']->fetch_field("customers","category_id","prod_id='".$prod_data1->prod_id."'");
		 
		 $id_ship1 = substr_count($GLOBALS['site_config']['ebook_cat'],$category_id);
		 
		
		 
		 if($id_ship1 <= 0)
		 {
		  $ship_deatils =1;
		  break;
		 }
		 }
		 
		 if($ship_deatils ==1)
		 {
		 	$status =1;
		 	$method = "payment";
		 }
		 else
		 {
			$status =2;
		 	$method = "shipment";
		 }
		 
				$paid_qry="update ".$ser_obj->cls_tbl." set order_status='".$status."', approved_dt = now(),pay_approved_by = 'by admin' where order_id='".$val."'";
				
				$res = $GLOBALS['db_con_obj']->execute_sql($paid_qry, "update");
				
				// 280507 -send Email Payment approval
				
				$ins_qry = "insert into temp_cron_table (id, order_id, method, method_status) values ('', '" . $val . "', '".$method."', '".$status. "')";// $val= orderid, payment = method , 1 payment status for select query
			
				$GLOBALS['db_con_obj']->execute_sql($ins_qry,"insert");
				
				unset($val);
				
				//$master_res->payment_approval_email($val);
				
				/*
				$master_res = $ser_obj->fetch_record($val);
				
				$detail_res = $ser_obj->fetch_flds($ord_d_obj->cls_tbl, "*", "order_id = '" . $val . "'");
				
				$master_data = mysql_fetch_object($master_res[0]);
				
				include("../forms/invoice_email_dets.php");
				
				//$ser_obj = set_values($ser_obj,"db", $res[0]);
				
				$res = $cust_obj->fetch_record($master_data->user_id);
				
				$cust_obj = set_values($cust_obj, "db", $res[0]);
				//$GLOBALS[site_config][debug] = 1;
				//email class
				$eml_cls = new email();
				
				$eml_cls->frame_email_body($ser_obj->approval_email_ids['pay_app'], array("#firstname#", "#lastname#", "#CN#", "#ordercontent#","#orderno#"), array($cust_obj->cust_firstname['value'], $cust_obj->cust_lastname['value'], $GLOBALS['site_config']['company_name'], $string, $master_data->order_id));
						
				
								
				$eml_cls->send_email($cust_obj->cust_email['value']);
				unset($eml_cls);
				
				*/
				
				// 280507 -send Email Payment approval
				
				$_SESSION['ses_mrkpaid']=1;
								
				}
									
			}
			header("location:frame_search.php");
			exit;
			
	break;
	//Change the order status from Payment pending into Shipment pending--END 
	
	
	//Change the order status from Shipment pending into Ready to shipping--START CODE
	
	case "mrkship":
	
			foreach($_REQUEST['ordnum'] as $key => $val)
			{
			$res = $ser_obj->fetch_record($val);
			
				if( $res[1] >0 )
				
				{
				
				$paid_qry="update ".$ser_obj->cls_tbl." set order_status='2', shipment_appdt = now() where order_id='".$val."'";
				
				$res = $GLOBALS['db_con_obj']->execute_sql($paid_qry, "update");
				
				// 280507 -send Email Shipment approval 
				
				$ins_qry = "insert into temp_cron_table (id, order_id, method, method_status) values ('', '" . $val . "', 'shipment', '2')";// $val= orderid, shipment = method , 2 for  shipment status for select query
							
				mysql_query($ins_qry);
				
				unset($val);
				/*
				$master_res = $ser_obj->fetch_record($val);
				
				$detail_res = $ser_obj->fetch_flds($ord_d_obj->cls_tbl, "*", "order_id = '" . $val . "'");
				
				$master_data = mysql_fetch_object($master_res[0]);
				
				include("../forms/invoice_email_dets.php");
				
							
				//$ser_obj = set_values($ser_obj,"db", $res[0]);
				
				$res = $cust_obj->fetch_record($master_data->user_id);
				
				$cust_obj = set_values($cust_obj, "db", $res[0]);
				//$GLOBALS[site_config][debug] = 1;
				//email class
				$eml_cls = new email();
				
				$eml_cls->frame_email_body($ser_obj->approval_email_ids['ship_app'], array("#firstname#", "#lastname#", "#CN#", "#ordercontent#","#orderno#"), array($cust_obj->cust_firstname['value'], $cust_obj->cust_lastname['value'], $GLOBALS['site_config']['company_name'], $string, $master_data->order_id));
				
								
				$eml_cls->send_email($cust_obj->cust_email['value']);
				
				unset($eml_cls);
				*/
				
				// 280507 -send Email Shipment approval 
				
				$_SESSION['ses_mrkship']=1;
				
				}
			}
			
			header("location:frame_search.php");
			exit;
			
	break;
 //Change the order status from Shipment pending into Ready to shipping--START CODE
 
 
 case "delete":
		
		$id = $_REQUEST[$ser_obj->primary_fld];
		
		
		if($id <= 0)
		{
			header("location:frame_search.php");
			exit();
		}
		else
		{
			
			$ser_obj->delete($id); 
			header("location:frame_search.php");
			exit();
		}
		break;
 
 
	case "mrkasdelete":
		foreach($_REQUEST['ordnum'] as $key => $val)
			{
			//echo $val."<br>\n";
			$ser_obj->delete($val); 
			/*$insert_qry="insert into customers_backup select * from ".$ser_obj->cls_tbl." where order_id = '".$val."'";
			$GLOBALS['db_con_obj']->execute_sql($insert_qry, "insert");
			
						
			$qry1="insert into order_details_backup select * from order_details where order_id = '".$val."'";
			$GLOBALS['db_con_obj']->execute_sql($qry1, "insert");
			
			
			$del_customers = "delete from customers where order_id = '".$val."'";				
			$GLOBALS['db_con_obj']->execute_sql($del_customers, "delete");
			
			$del_order_details = "delete from order_details where order_id = '".$val."'";				
			$GLOBALS['db_con_obj']->execute_sql($del_order_details , "delete");
			*/
					
			}
			frame_notices("All Selected Orders deleted !!", "redfont");
			
			header("location:frame_search.php");
			exit;
			break;
			
	}

if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}

?>

<table <?php echo $inner_table_param; ?>>
  <tr>
    <td>
	<?php
	
		if(!empty($_SESSION['ses_mrkpaid']))
		{
		unset($_SESSION['ses_mrkpaid']);
		frame_notices("Selected orders has been marked as Paid !!", "greenfont");
		}
		 if(!empty($_SESSION['ses_mrkship']))
		{
		unset($_SESSION['ses_mrkship']);
		frame_notices("Selected orders has been marked as Shipped !!", "greenfont");
		}
	
	 require_once("../includes/error_message.php");	
		
	 require_once("../forms/admin/view_frames.php");
	
	 
  	?>
	</td>
  </tr>
</table>


<?php
require_once("admin_footer.php"); 
?>