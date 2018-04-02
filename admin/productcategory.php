<?php
require_once("admin_header.php"); 

require_once("../classes/productcategory.class.php");

$productcategory_obj = new productcategory();

$submit_action = $_REQUEST['submit_action'];

$display_what = "detail_frm";

switch ($submit_action)
{
	case "preview":
		$cat_id = $_REQUEST[$productcategory_obj->primary_fld];
		if($cat_id <= 0)
		{
			header("location:productcategory.php");
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
		$edit_id = $_REQUEST[$productcategory_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:productcategory.php");
			exit();
		}
		
		$edit_res = $productcategory_obj->fetch_record($supplier_id);
		
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$productcategory_obj->primary_fld];
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($productcategory_obj->insert())
				$redirect_url = "productcategory.php";
			else
				$redirect_url = "productcategory.php?submit_action=add";
		
		}
		else
		{//update the record
			if($productcategory_obj->update($id))
				$redirect_url = "productcategory.php";
			else
				$redirect_url = "productcategory.php?submit_action=edit&" . $productcategory_obj->primary_fld . "=" . $_REQUEST[$productcategory_obj->primary_fld];
		} 
		break;

	case "delete":
		$id = $_REQUEST[$productcategory_obj->primary_fld];
		if($id <= 0)
		{
			header("location:productcategory.php");
			exit();
		}
		else
		{
		
			$productcategory_obj->delete($id);				
		
			$redirect_page = 1;
			$redirect_url = "productcategory.php";
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
		require_once("../forms/admin/productcategory_detail_frm.php"); 
		break;

	case "list_frm";
		require_once("../forms/admin/productcategory_list_frm.php"); 
		break;

	case "preview_frm";
		require_once("../forms/admin/productcategory_preview_frm.php"); 
		break;
		

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>