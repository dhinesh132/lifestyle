<?php
require_once("admin_header.php"); 

require_once("../classes/your_review.class.php");
			


$your_review_obj = new your_review();

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

switch ($submit_action)
{
	case "preview":
		$edit = 1;
		$edit_id = $_REQUEST[$your_review_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:your_review.php");
			exit();
		}
		
		$edit_res = $your_review_obj->fetch_record($id);
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$your_review_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:your_review.php");
			exit();
		}
		
		$edit_res = $your_review_obj->fetch_record($id);
		
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$your_review_obj->primary_fld];
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($your_review_obj->insert())
				$redirect_url = "your_review.php";
			else
				$redirect_url = "your_review.php?submit_action=add";
		
		}
		else
		{//update the record
			if($your_review_obj->update($id))
				$redirect_url = "your_review.php";
			else
				$redirect_url = "your_review.php?submit_action=edit&" . $your_review_obj->primary_fld . "=" . $_REQUEST[$your_review_obj->primary_fld];
		} 
		break;

	case "delete":
		$id = $_REQUEST[$your_review_obj->primary_fld];
		if($id <= 0)
		{
			header("location:your_review.php");
			exit();
		}
		else
		{
		
			$your_review_obj->delete($id);				
		
			$redirect_page = 1;
			$redirect_url = "your_review.php";
		}
		break;
		
	case "status":
		$redirect_page = 1;
		if($_REQUEST['status'] == 0)
		$status = 1;
		else
		$status = 0;
		
		$status_id = $_REQUEST['id'];
		$approv_qry= "update ".$your_review_obj->cls_tbl. " set status ='".$status."', modify_datetime=now() where id ='".$status_id."'";
		
		$res = database_manipulation::execute_sql($approv_qry, "update");
		if ($status == 1)
		frame_notices("Review approved to display at user section !!", "greenfont");
		else
		frame_notices("Review status has been changed, it would not be displayed at user section !!", "greenfont");
		
		
		$redirect_url = "your_review.php";
		
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
<?php
	
require_once("../includes/error_message.php");

switch ($display_what)
{

	case "list_frm";
		require_once("../forms/admin/your_review_list_frm.php"); 
		break;

	case "preview_frm";
		require_once("../forms/admin/your_review_preview_frm.php"); 
		break;

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>