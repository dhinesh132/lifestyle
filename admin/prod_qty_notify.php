<?php
require_once("admin_header.php"); 

require_once("../classes/prod_qty_notify.class.php");

$qty_notify = new prod_qty_notify();

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

switch ($submit_action)
{
	case "preview":
		$edit = 1;
		$edit_id = $_REQUEST[$qty_notify->primary_fld];
		if($edit_id <= 0)
		{
			header("location:prod_qty_notify.php");
			exit();
		}
		
		$edit_res = $qty_notify->fetch_record($id);
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$qty_notify->primary_fld];
		if($edit_id <= 0)
		{
			header("location:prod_qty_notify.php");
			exit();
		}
		
		$edit_res = $qty_notify->fetch_record($id);
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$qty_notify->primary_fld];
			
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($qty_notify->insert())
				$redirect_url = "prod_qty_notify.php";
			else
				$redirect_url = "prod_qty_notify.php?submit_action=add";
		
		}
		else
		{//update the record
 
 			if($qty_notify->update($id))
				$redirect_url = "prod_qty_notify.php";
			else
				$redirect_url = "prod_qty_notify.php?submit_action=edit&" . $qty_notify->primary_fld . "=" . $_REQUEST[$qty_notify->primary_fld];
		} 
		break;

	case "delete":
	
		echo $id = $_REQUEST[$qty_notify->primary_fld];
		if($id <= 0)
		{
			header("location:prod_qty_notify.php");
			exit();
		}
		else
		{
		
			$qty_notify->delete($id); 
			$redirect_page = 1;
			$redirect_url = "prod_qty_notify.php";
		}
		break;
		
	case "status":
	
		$id = $_REQUEST['ban_id'];
		if($id <= 0)
		{
			header("location:prod_qty_notify.php");
			exit();
		}
		else
		{
		
			$ban_status = $_REQUEST['ban_status'];

			if($ban_status == 1)
				$update = "update ".$qty_notify->cls_tbl." set ban_status = 0 where ban_id='".$id."'";
			else if($ban_status == 0)
				$update = "update ".$qty_notify->cls_tbl." set ban_status = 1 where ban_id='".$id."'";
				
			$GLOBALS['db_con_obj']->execute_sql($update,"update");
			frame_notices("Status successfully updated !!", "greenfont", 1);
			$redirect_page = 1;
			$redirect_url = "prod_qty_notify.php";
		}
		break;
	break;

} //end switch


if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}
	
?>


<table <?php echo $inner_table_param; ?> align="center">
  <tr>
    <td>
<?php
	
require_once("../includes/error_message.php");

switch ($display_what)
{

	case "detail_frm";
		require_once("../forms/admin/prod_qty_notify_detail_frm.php"); 
		break;
	
	case "list_frm";
		require_once("../forms/admin/prod_qty_notify_list_frm.php"); 
		break;

	

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>