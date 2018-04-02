<?php
require_once("admin_header.php"); 

require_once("../classes/authors.class.php");

$mat_obj = new authors();


$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

$cat_count_qry = "select min(DisplayOrder), max(DisplayOrder) from ". $mat_obj->cls_tbl;
$cat_count_res = $GLOBALS['db_con_obj']->execute_sql($cat_count_qry);
$cat_count_data = mysql_fetch_array($cat_count_res[0]);


switch ($submit_action)
{
	case "preview":
		$edit = 1;
		$edit_id = $_REQUEST[$mat_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:authors.php");
			exit();
		}
		
		$edit_res = $mat_obj->fetch_record($id);
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$mat_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:authors.php");
			exit();
		}
		
		$edit_res = $mat_obj->fetch_record($id);
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$mat_obj->primary_fld];
			
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($mat_obj->insert())
				$redirect_url = "authors.php";
			else
				$redirect_url = "authors.php?submit_action=add";
		
		}
		else
		{//update the record
 
 			if($mat_obj->update($id))
			{	
				$redirect_url = "authors.php";
				}
			else
			{
				
				$redirect_url = "authors.php?submit_action=edit&" . $mat_obj->primary_fld . "=" . $_REQUEST[$mat_obj->primary_fld];
				}
		} 
		
		break;

	case "delete":
	
		 $id = $_REQUEST[$mat_obj->primary_fld];
		if($id <= 0)
		{
			header("location:authors.php?AuthId=$AuthId");
			exit();
		}
		else
		{
		
			$mat_obj->delete($id); 
			$redirect_page = 1;
			$redirect_url = "authors.php";
		}
		break;
		
		case "hide":
	
		 $id = $_REQUEST[$mat_obj->primary_fld];
		if($id <= 0)
		{
			header("location:authors.php");
			exit();
		}
		else
		{
			$update_qry= "update ".$mat_obj->cls_tbl. " set del_status = 1 where ".$mat_obj->primary_fld ." = '".$id."'";
			$GLOBALS['db_con_obj']->execute_sql($update_qry, "update");
			frame_notices("Product details successfully deleted !!", "redfont");
			$redirect_page = 1;
			$redirect_url = "authors.php";
		}
		break;
	case "status":
		$id = $_REQUEST['id'];
		
		if($id <= 0)
		{
			header("location:authors.php");
			exit();
		}
		else
		{
			//$AuthStatus = $_REQUEST['status'];
			$AuthStatus = $GLOBALS['db_con_obj']->fetch_field($mat_obj->cls_tbl,"AuthStatus","AuthId='".$id."'");
		
			
			if($AuthStatus == 1)
				$update = "update ".$mat_obj->cls_tbl." set AuthStatus = 0 where AuthId='".$id."'";
			else if(AuthStatus == 0)
				$update = "update ".$mat_obj->cls_tbl." set AuthStatus = 1 where AuthId='".$id."'";
			$GLOBALS['db_con_obj']->execute_sql($update,"update");
			frame_notices("Status successfully updated !!", "greenfont", 1);
			$redirect_page = 1;
			$redirect_url = "authors.php";
		}
		break;
		
		case "order":
		//$GLOBALS['site_config']['debug'] =1;
			if($_REQUEST['perform'] == "down") {
			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($mat_obj->cls_tbl, "AuthId,DisplayOrder", "DisplayOrder < '".$_REQUEST['order_id']."' order by DisplayOrder desc limit 0,1");
			
			$ord_data = mysql_fetch_object($ord_res[0]);
			
			$order_qry= "update ".$mat_obj->cls_tbl. " set DisplayOrder ='".$ord_data->DisplayOrder."' where AuthId='".$_REQUEST['AuthId']."'";
			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			$order_qry= "update ".$mat_obj->cls_tbl. " set DisplayOrder ='".($_REQUEST['order_id'])."' where AuthId ='".$ord_data->AuthId."'";
			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			}
			
			if($_REQUEST['perform'] == "up") {
			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($mat_obj->cls_tbl,"AuthId,DisplayOrder"," DisplayOrder >'".$_REQUEST['order_id']."' order by DisplayOrder asc limit 0,1");
			
			$ord_data = mysql_fetch_object($ord_res[0]);
			
			$order_qry= "update ".$mat_obj->cls_tbl. " set DisplayOrder ='".$ord_data->DisplayOrder."' where AuthId='".$_REQUEST['AuthId']."'";
			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			$order_qry= "update ".$mat_obj->cls_tbl. " set DisplayOrder ='".($_REQUEST['order_id'])."' where AuthId ='".$ord_data->AuthId."'";
			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			}
			frame_notices("Dispaly order successfully updated !!", "greenfont");
			$redirect_page = 1;
			$redirect_url = "authors.php";
			
		break;

} //end switch


if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}
	
?>


 <h1>Manage Author</h1>
<?php
	
require_once("../includes/error_message.php");

switch ($display_what)
{

	case "detail_frm";
		require_once("../forms/admin/authors_detail_frm.php"); 
		break;
	
	case "list_frm";
		require_once("../forms/admin/authors_list_frm.php"); 
		break;

	

} //end switch

?>



<?php 

require_once("admin_footer.php"); 

?>