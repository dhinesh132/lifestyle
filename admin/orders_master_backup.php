<?php 

require_once("admin_header.php"); 
require_once("../classes/order_master.class.php");
require_once("../classes/order_backup.class.php");
require_once("../classes/email.class.php");
require_once("../classes/customers.class.php");



$ser_obj=new order_master();

$ser_bac_obj = new order_backup();

$eml_cls = new email();

$cust_obj = new customers();

$ord_d_obj = new order_details();

$submit_action = $_REQUEST['submit_action'];
//echo $_REQUEST['ordnum'];

$frm_pag=$_REQUEST['frm'];


switch ($submit_action)
{

	case "search":
	if($frm_pag!="")
	{
	
	//require_once("../classes/order_master.class.php");
	//$ser_obj=new order_master();
	$arr_res=$ser_bac_obj->search_query();
	$_SESSION['ses_ord_bac_qry'] = $arr_res;
	header("location:orders_master_backup.php");
	exit();
	}
	else
	{
	
	$arr_res=$ser_bac_obj->search_query();
	$_SESSION['ses_ord_bac_qry'] = $arr_res;
	break;
	
	}
	

	case "clear":
		unset($_SESSION['ses_ord_bac_qry']);
		unset($_SESSION['ses_ord_bac_srch']);
	break;
	
	case "mrkdel":
		if(count($_REQUEST['ordnum']) > 0)
			{
			foreach($_REQUEST['ordnum'] as $key => $val)
			{
			//echo $val."<br>\n";
			
			$del_order_master = "delete from order_master_backup where order_id = '".$val."'";				
			$GLOBALS['db_con_obj']->execute_sql($del_order_master, "delete");
			
			$del_order_details = "delete from order_details_backup where order_id = '".$val."'";				
			$GLOBALS['db_con_obj']->execute_sql($del_order_details , "delete");
			
			frame_notices("Order details deleted successfully !!", "redfont");
			}
			}
			else 
			{
			frame_notices("Please Select atleast one order to delete !!", "redfont");
			}
			header("location:orders_master_backup.php");
			exit;
				break;
				
		case "delete":
			$id = $_REQUEST[order_id];
			if($id <= 0)
			{
				header("location:orders_master_backup.php");
				exit();
			}
			else
			{
					
			
			$del_order_master = "delete from order_master_backup where order_id = '".$id."'";				
			$GLOBALS['db_con_obj']->execute_sql($del_order_master, "delete");
			
			$del_order_details = "delete from order_details_backup where order_id = '".$id."'";				
			$GLOBALS['db_con_obj']->execute_sql($del_order_details , "delete");
			}
			frame_notices("Order details deleted successfully !!", "redfont");
			
			header("location:orders_master_backup.php");
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
	
			
	 require_once("../includes/error_message.php");	
		
	 require_once("../forms/admin/view_orders_master_backup.php");
	
	 
  	?>
	</td>
  </tr>
</table>


<?php
require_once("admin_footer.php"); 
?>