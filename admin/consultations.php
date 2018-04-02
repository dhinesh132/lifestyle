<?php
require_once("admin_header.php"); 
if($display_consultation == "tele")
	$page = "tele_consultations.php";
else
	$page = "consultations.php";
	
require_once("../classes/consultations.class.php");

$consult_obj = new consultations();

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

switch ($submit_action)
{

	case "save":
		$id = $_REQUEST[$consult_obj->primary_fld];
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($consult_obj->insert())
				$redirect_url = $page;
			else
				$redirect_url = $page . "?submit_action=add";
		
		}
		else
		{//update the record
			if($consult_obj->update($id))
				$redirect_url = $page;
			else
				$redirect_url = $page . "?submit_action=edit&" . $consult_obj->primary_fld . "=" . $_REQUEST[$author_obj->primary_fld];
		} 
		break;

	 case "status":
		$redirect_page = 1;
		
		$status_id = $_REQUEST[$consult_obj->primary_fld];
		$consult_obj->change_status($status_id);
		$redirect_url = $page;
		
		break;
	
	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$consult_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:$page");
			exit();
		}

		$display_what = "detail_frm";
		$hid_action = "save";
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
	
	case "list_frm";
		require_once("../forms/admin/consultations_list_frm.php"); 
		break;

	case "detail_frm";
		require_once("../forms/admin/admin_consultations_detail_frm.php"); 
		break;

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>