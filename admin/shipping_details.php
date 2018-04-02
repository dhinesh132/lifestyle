<?php
require_once("admin_header.php"); 

require_once("../classes/shipping_details.class.php");


$shipping_obj = new shipping_details();

	

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

$admin_menu_file ="shipping_details.php";


switch ($submit_action)
{
	case "preview":
		$id = $_REQUEST['id'];
		
		if($id <= 0)
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
		$edit_id = $_REQUEST[$shipping_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:$admin_menu_file");
			exit();
		}
		
		$edit_res = $shipping_obj->fetch_record($supplier_id);
		
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$shipping_obj->primary_fld];
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($shipping_obj->insert())
				$redirect_url = "$admin_menu_file";
			else
				$redirect_url = "$admin_menu_file?submit_action=add";
		
		}
		else
		{//update the record
			if($shipping_obj->update($id))
				$redirect_url = "$admin_menu_file";
			else
				$redirect_url = "$admin_menu_file?submit_action=edit&" . $shipping_obj->primary_fld . "=" . $_REQUEST[$shipping_obj->primary_fld];
		} 
		break;

	case "delete":
		$id = $_REQUEST[$shipping_obj->primary_fld];
		if($id <= 0)
		{
			header("location:$admin_menu_file");
			exit();
		}
		else
		{
		
			$shipping_obj->delete($id);				
		
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


<h1>Shipping Details </h1>
<?php
	
require_once("../includes/error_message.php");

switch ($display_what)
{
	
	case "detail_frm":
		require_once("../forms/admin/shipping_details_detail_frm.php"); 
		break;

	case "list_frm";
		require_once("../forms/admin/shipping_details_list_frm.php"); 
		break;

	case "preview_frm";
		require_once("../forms/admin/shipping_details_preview_frm.php"); 
		break;
		

} //end switch

?>

<?php 

require_once("admin_footer.php"); 

?>