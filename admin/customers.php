<?php
require_once("admin_header.php"); 

require_once("../classes/customers.class.php");

$cust_obj = new customers();

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

switch ($submit_action)
{
	/*case "search":
		$arr_res=$cust_obj->search_query();
		$_SESSION['ses_cust_srch_qry'] = $arr_res;
		header("location:customers.php");
		exit();
	break;
	
	case "clear":
		unset($_SESSION['ses_cust_srch_qry']);
		unset($_SESSION['ses_cust_srch_vars']);
		header("location:customers.php");
		exit();
	break; */
	
	case "preview":
		$edit = 1;
		$edit_id = $_REQUEST[$cust_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:customers.php");
			exit();
		}
		
		$edit_res = $cust_obj->fetch_record($id);
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$cust_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:customers.php");
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
				$redirect_url = "customers.php";
			else
				$redirect_url = "customers.php?submit_action=add";
		
		}
		else
		{//update the record
			if($cust_obj->update($id))
				$redirect_url = "customers.php";
			else
				$redirect_url = "customers.php?submit_action=edit&" . $cust_obj->primary_fld . "=" . $_REQUEST[$cust_obj->primary_fld];
		} 
		break;

	case "delete":
		$id = $_REQUEST[$cust_obj->primary_fld];
		if($id <= 0)
		{
			header("location:customers.php");
			exit();
		}
		else
		{
		
			$cust_obj->delete_record($id); 
			$redirect_page = 1;
			$redirect_url = "customers.php";
		}
		break;
		
		case "status":
		$id = $_REQUEST['id'];
		
		if($id <= 0)
		{
			header("location:customers.php");
			exit();
		}
		else
		{
			//$cust_status = $_REQUEST['status'];
			$cust_status = $GLOBALS['db_con_obj']->fetch_field($cust_obj->cls_tbl,"cust_status","cust_id='".$id."'");
		
			
			if($cust_status == 1)
				$update = "update ".$cust_obj->cls_tbl." set cust_status = 0 where cust_id='".$id."'";
			else if(cust_status == 0)
				$update = "update ".$cust_obj->cls_tbl." set cust_status = 1 where cust_id='".$id."'";
			$GLOBALS['db_con_obj']->execute_sql($update,"update");
			frame_notices("Status successfully updated !!", "greenfont", 1);
			$redirect_page = 1;
			$redirect_url = "customers.php";
		}
		break;
		
		case "search":
			if($frm_pag!="")
			{
				$arr_res=$cust_obj->search_query();
				$_SESSION['ses_cust_srch_qry'] = $arr_res;
				header("location:customers.php");
				exit();
			}
			else
			{			
			$arr_res=$cust_obj->search_query();
			$_SESSION['ses_cust_srch_qry'] = $arr_res;
			header("location:customers.php");
			exit();	
		}
		break;
	
		case "clear":
			unset($_SESSION['ses_cust_srch_vars']);
			unset($_SESSION['ses_cust_srch_qry']);
		break;

} //end switch


if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}
	
?>


<h1>Manage Customers </h1>
<?php
	
require_once("../includes/error_message.php");

switch ($display_what)
{
	
	case "detail_frm":
		require_once("../forms/admin/customers_detail_frm.php"); 
		break;

	case "list_frm";
		//require_once("../forms/admin/customers_search_frm.php"); 
		require_once("../forms/admin/customers_list_frm.php"); 
		break;

	case "preview_frm";
		require_once("../forms/admin/customers_preview_frm.php"); 
		break;
		

} //end switch

?>



<?php 

require_once("admin_footer.php"); 

?>