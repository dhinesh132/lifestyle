<?php
require_once("admin_header.php"); 

require_once("../classes/productcategory.class.php");

require_once("../classes/productrefcategory.class.php"); 



$prodcat_obj = new productcategory();

$prodrefcat_obj = new productrefcategory();



 $submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

$admin_menu_file = "topcategory.php";

if($from_page == "sub_category")
$admin_menu_file = "sub_category.php";
else
$_SESSION['ses_cat_id'] = 0;


switch ($submit_action)
{
	case "preview":
		$cat_id = $_REQUEST['cat_id'];
		
		if($cat_id <= 0)
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
		$edit_id = $_REQUEST[$prodcat_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:$admin_menu_file");
			exit();
		}
		
		$edit_res = $prodcat_obj->fetch_record($supplier_id);
		
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$prodcat_obj->primary_fld];
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($prodcat_obj->insert())
				$redirect_url = "$admin_menu_file";
			else
				$redirect_url = "$admin_menu_file?submit_action=add";
		
		}
		else
		{//update the record
			if($prodcat_obj->update($id))
				$redirect_url = "$admin_menu_file";
			else
				$redirect_url = "$admin_menu_file?submit_action=edit&" . $prodcat_obj->primary_fld . "=" . $_REQUEST[$prodcat_obj->primary_fld];
		} 
		break;

	case "delete":
		$id = $_REQUEST[$prodcat_obj->primary_fld];
		if($id <= 0)
		{
			header("location:$admin_menu_file");
			exit();
		}
		else
		{
		
			$prodcat_obj->delete($id);				
		
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
    <td>
<?php
	
require_once("../includes/error_message.php");

switch ($display_what)
{
	
	case "detail_frm":
		require_once("../forms/admin/topcategory_detail_frm.php"); 
		break;

	case "list_frm";
		require_once("../forms/admin/topcategory_list_frm.php"); 
		break;

	case "preview_frm";
		require_once("../forms/admin/topcategory_preview_frm.php"); 
		break;
		
	case "section_frm";
		require_once("../forms/admin/menus_section_list_frm.php"); 
		break;
		

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>