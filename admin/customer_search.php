<?php 

require_once("admin_header.php"); 
require_once("../classes/customers.class.php");

$cust_obj=new customers();

$submit_action = $_REQUEST['submit_action'];
//echo $_REQUEST['ordnum'];

$frm_pag=$_REQUEST['frm'];

switch ($submit_action)
{

	case "search":
	if($frm_pag!="")
	{
	require_once("../classes/customers.class.php");
	$cust_obj=new customers();
	$arr_res=$cust_obj->search_query();
	$_SESSION['ses_cust_srch_qry'] = $arr_res;
	header("location:customer_search.php");
	exit();
	}
	else
	{
	
	$arr_res=$cust_obj->search_query();
	$_SESSION['ses_cust_srch_qry'] = $arr_res;
	header("location:customer_search.php");
	exit();
	break;
	
	}
	

	case "clear":
		unset($_SESSION['ses_cust_srch_qry']);
		unset($_SESSION['ses_cust_srch_vars']);
	break;
	
	//Change the order status from Payment pending into Shipment pending--START CODE	
	
		case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$cust_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:customer_search.php");
			exit();
		}
		
		$edit_res = $cust_obj->fetch_record($id);
		
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$cust_obj->primary_fld];
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($cust_obj->insert())
				$redirect_url = "customer_search.php";
			else
				$redirect_url = "customer_search.php?submit_action=add";
		
		}
		else
		{//update the record
			if($cust_obj->update($id))
				$redirect_url = "customer_search.php";
			else
				$redirect_url = "customer_search.php?submit_action=edit&" . $cust_obj->primary_fld . "=" . $_REQUEST[$cust_obj->primary_fld];
		} 
		break;
	
	

 case "delete":
		$id = $_REQUEST[$cust_obj->primary_fld];
		if($id <= 0)
		{
			header("location:customer_search.php");
			exit();
		}
		else
		{
			$cust_obj->delete_record($id); 
			header("location:customer_search.php");
			exit();
		}
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
switch ($display_what)
{
	
	case "detail_frm":
		require_once("../forms/customers_detail_frm.php"); 
		break;
	
	 	
	default:
		
	 require_once("../forms/admin/view_customer.php");
}
	 
  	?>
	</td>
  </tr>
</table>


<?php
require_once("admin_footer.php"); 
?>