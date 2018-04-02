<?php
require_once("admin_header.php"); 
require_once("../classes/frame_len_referense.class.php");
require_once("../classes/product_master.class.php");
require_once("../classes/productcategory.class.php");
require_once("../classes/productattributes.class.php");

$relprod_obj = new frame_len_referense();

$prod_obj = new product_master();
			
$productcategory_obj = new productcategory();

$submit_action = $_REQUEST['submit_action'];

$display_what = "detail_frm";

$edit_id = $_SESSION['ses_rel_frame_id'];

switch ($submit_action)
{
	case "preview":
		$edit = 1;
		$edit_id = $_REQUEST[$relprod_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:frame_len_referense.php");
			exit();
		}
		
		$edit_res = $relprod_obj->fetch_record($id);
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$relprod_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:frame_len_referense.php");
			exit();
		}
		
		$edit_res = $relprod_obj->fetch_record($id);
		
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$relprod_obj->primary_fld];
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($relprod_obj->insert())
				$redirect_url = "frame_len_referense.php";
			else
				$redirect_url = "frame_len_referense.php";
		
		}
		else
		{//update the record
			if($relprod_obj->update($id))
				$redirect_url = "frame_len_referense.php";
			else
				$redirect_url = "frame_len_referense.php";
		} 
		break;

	case "delete":
		$id = $_REQUEST[$relprod_obj->primary_fld];
		if($id <= 0)
		{
			header("location:frame_len_referense.php");
			exit();
		}
		else
		{
		
			$relprod_obj->delete_record($id); 
			$redirect_page = 1;
			$redirect_url = "frame_len_referense.php";
		}
		break;

} //end switch


if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}
	
?>


<table <?php echo $inner_table_param; ?>>
  <tr>
    <td>
    <table width="60%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr > 
    <td align="right"><p align="right"><a href="frame_master.php" class="blue_link">Back to Frame</a></p></td></tr></table>
<?php
	
require_once("../includes/error_message.php");

switch ($display_what)
{
	
	case "detail_frm":
		require_once("../forms/admin/frame_len_referense_detail_frm.php"); 
		break;

	case "list_frm1";
		require_once("../forms/admin/frame_len_referense_list_frm.php"); 
		break;

	case "preview_frm";
		require_once("../forms/admin/frame_len_referense_preview_frm.php"); 
		break;
		

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>