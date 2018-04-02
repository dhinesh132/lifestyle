<?php
require_once("admin_header.php"); 

require_once("../classes/country.class.php");
			

$country_obj = new country();

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

switch ($submit_action)
{
	case "preview":
		$edit = 1;
		$edit_id = $_REQUEST[$country_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:country.php");
			exit();
		}
		
		$edit_res = $country_obj->fetch_record($id);
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$country_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:country.php");
			exit();
		}
		
		$edit_res = $country_obj->fetch_record($id);
		
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$country_obj->primary_fld];
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($country_obj->insert())
				$redirect_url = "country.php";
			else
				$redirect_url = "country.php?submit_action=add";
		
		}
		else
		{//update the record
			if($country_obj->update($id))
				$redirect_url = "country.php";
			else
				$redirect_url = "country.php?submit_action=edit&" . $country_obj->primary_fld . "=" . $_REQUEST[$country_obj->primary_fld];
		} 
		break;

	case "delete":
		$id = $_REQUEST[$country_obj->primary_fld];
		if($id <= 0)
		{
			header("location:country.php");
			exit();
		}
		else
		{
		
			$country_obj->delete($id);				
		
			$redirect_page = 1;
			$redirect_url = "country.php";
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
		require_once("../forms/admin/country_detail_frm.php"); 
		break;

	case "list_frm";
		require_once("../forms/admin/country_list_frm.php"); 
		break;

	case "preview_frm";
		require_once("../forms/admin/country_preview_frm.php"); 
		break;
		

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>