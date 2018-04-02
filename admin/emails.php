<?php
require_once("admin_header.php"); 

require_once("../classes/emails.class.php");

$emails_obj = new emails();

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

switch ($submit_action)
{
	case "preview":
		$emails_id = $_REQUEST[$emails_obj->primary_fld];
		if($emails_id <= 0)
		{
			header("location:emails.php");
			exit();
		}
		
		//$edit_res = $emails_obj->fetch_record($id);
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$emails_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:emails.php");
			exit();
		}
		
		$edit_res = $emails_obj->fetch_record($id);
		
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$emails_obj->primary_fld];
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($emails_obj->insert())
				$redirect_url = "emails.php";
			else
				$redirect_url = "emails.php?submit_action=add";
		
		}
		else
		{//update the record
			if($emails_obj->update($id))
				$redirect_url = "emails.php";
			else
				$redirect_url = "emails.php?submit_action=edit&" . $emails_obj->primary_fld . "=" . $_REQUEST[$emails_obj->primary_fld];
		} 
		break;

	case "delete":
		$emails_id = $_REQUEST[$emails_obj->primary_fld];
		if($emails_id <= 0)
		{
			header("location:emails.php");
			exit();
		}
		else
		{
		
			$emails_obj->delete($emails_id);				
		
			$redirect_page = 1;
			$redirect_url = "emails.php";
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
<?php
	
require_once("../includes/error_message.php");

switch ($display_what)
{
	
	case "detail_frm":
		require_once("../forms/admin/emails_detail_frm.php"); 
		break;

	case "list_frm";
		require_once("../forms/admin/emails_list_frm.php"); 
		break;

	case "preview_frm";
		require_once("../forms/admin/emails_preview_frm.php"); 
		break;
		

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>