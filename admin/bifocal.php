<?php
require_once("admin_header.php"); 

require_once("../classes/bifocal.class.php");

$sbg_obj = new bifocal();


$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";



switch ($submit_action)
{
	case "preview":
		$edit = 1;
		$edit_id = $_REQUEST[$sbg_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:bifocal.php");
			exit();
		}
		
		$edit_res = $sbg_obj->fetch_record($id);
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$sbg_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:bifocal.php");
			exit();
		}
		
		$edit_res = $sbg_obj->fetch_record($id);
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$sbg_obj->primary_fld];
			
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($sbg_obj->insert())
				$redirect_url = "bifocal.php";
			else
				$redirect_url = "bifocal.php?submit_action=add";
		
		}
		else
		{//update the record
 
 			if($sbg_obj->update($id))
			{	
				$redirect_url = "bifocal.php";
				}
			else
			{
				
				$redirect_url = "bifocal.php?submit_action=edit&" . $sbg_obj->primary_fld . "=" . $_REQUEST[$sbg_obj->primary_fld];
				}
		} 
		
		break;

	case "delete":
	
		 $id = $_REQUEST[$sbg_obj->primary_fld];
		if($id <= 0)
		{
			header("location:bifocal.php?page_id=$page_id");
			exit();
		}
		else
		{
		
			$sbg_obj->delete($id); 
			$redirect_page = 1;
			$redirect_url = "bifocal.php";
		}
		break;
		
		case "hide":
	
		 $id = $_REQUEST[$sbg_obj->primary_fld];
		if($id <= 0)
		{
			header("location:bifocal.php");
			exit();
		}
		else
		{
			$update_qry= "update ".$sbg_obj->cls_tbl. " set del_status = 1 where ".$sbg_obj->primary_fld ." = '".$id."'";
			$GLOBALS['db_con_obj']->execute_sql($update_qry, "update");
			frame_notices("Product details successfully deleted !!", "redfont");
			$redirect_page = 1;
			$redirect_url = "bifocal.php";
		}
		break;
	case "status":
		$id = $_REQUEST[$sbg_obj->primary_fld];
		
		if($id <= 0)
		{
			header("location:bifocal.php");
			exit();
		}
		else
		{
			//$display_status = $_REQUEST['status'];
			echo $display_status = $GLOBALS['db_con_obj']->fetch_field($sbg_obj->cls_tbl,"display_status","page_id='".$id."'");
		
			
			if($display_status == 1)
				$update = "update ".$sbg_obj->cls_tbl." set display_status = 0 where page_id='".$id."'";
			else if(display_status == 0)
				$update = "update ".$sbg_obj->cls_tbl." set display_status = 1 where page_id='".$id."'";
			$GLOBALS['db_con_obj']->execute_sql($update,"update");
			frame_notices("Static page status successfully updated !!", "greenfont", 1);
			$redirect_page = 1;
			$redirect_url = "bifocal.php";
		}
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
		require_once("../forms/admin/bifocal_detail_frm.php"); 
		break;
	
	case "list_frm";
		require_once("../forms/admin/bifocal_list_frm.php"); 
		break;

	

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>