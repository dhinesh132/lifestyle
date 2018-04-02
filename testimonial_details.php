<?php
require_once("header.php"); 

require_once("classes/testimonial_master.class.php");


$testimonial_obj = new testimonial_master();



$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

$admin_menu_file ="testimonial_details.php";


switch ($submit_action)
{
	case "preview":
		$testimonial_id = $_REQUEST['testimonial_id'];
		
		if($testimonial_id <= 0)
		{
			header("location:$admin_menu_file");
			exit();
		}
		
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$testimonial_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:$admin_menu_file");
			exit();
		}
		
		$edit_res = $testimonial_obj->fetch_record($supplier_id);
		
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$testimonial_obj->primary_fld];
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			if($testimonial_obj->insert())
				$redirect_url = "testimonial.php";
			else
				$redirect_url = "$admin_menu_file?submit_action=add";
		
		}
		else
		{//update the record
			if($testimonial_obj->update($id))
				$redirect_url = "$admin_menu_file";
			else
				$redirect_url = "$admin_menu_file?submit_action=edit&" . $testimonial_obj->primary_fld . "=" . $_REQUEST[$testimonial_obj->primary_fld];
		} 
		break;

	case "delete":
		$id = $_REQUEST[$testimonial_obj->primary_fld];
		if($id <= 0)
		{
			header("location:$admin_menu_file");
			exit();
		}
		else
		{
		
			$testimonial_obj->delete($id);				
		
			$redirect_page = 1;
			$redirect_url = "$admin_menu_file";
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
    <td width="100%" valign="top">
<?php
	
require_once("includes/error_message.php");
require_once("forms/testimonial_master_details_frm.php"); 
?>
	</td>
  </tr>
</table>


<?php 

require_once("footer.php"); 

?>