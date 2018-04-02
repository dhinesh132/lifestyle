<?php
require_once("admin_header.php"); 


$product_page_url = "product_master.php";


require_once("../classes/product_master.class.php");
require_once("../classes/productcategory.class.php");
require_once("../classes/productattributes.class.php");

$prod_obj = new product_master();

$productcategory_obj = new productcategory();

$prod_attr_obj = new productattributes();

$submit_action = $_REQUEST['submit_action'];
$flag=$_REQUEST['flag'];
$display_what = "list_frm";
$make_parent = 0;


if($_SESSION['ses_selected_prnt_prod'] > 0 && $submit_action == "add")

	$submit_action = "edit";



switch ($submit_action)
{
	case "model_color":
		$id = $_REQUEST[$prod_obj->primary_fld];
		$redirect_page = 1;
		
	
		if($id <= 0)
		{

			if($prod_obj->insert())
				$redirect_url = "$product_page_url?submit_action=add";
			else
				$redirect_url = "$product_page_url?submit_action=add";
		}
		else
		{			
			if($prod_obj->update($id))
				$redirect_url = "$product_page_url?submit_action=add";
			else
				$redirect_url = "$product_page_url?submit_action=add";
				
		} 
	break;
	
	case "size":
	
		$id = $_REQUEST[$prod_obj->primary_fld];
		$redirect_page = 1;
		
	
		if($id <= 0)
		{

			if($prod_obj->insert())
				$redirect_url = "$product_page_url?submit_action=add";
			else
				$redirect_url = "$product_page_url?submit_action=add";
		}
		else
		{			
			if($prod_obj->update($id))
				$redirect_url = "$product_page_url?submit_action=add";
			else
				$redirect_url = "$product_page_url?submit_action=add";
		}
	break;
	
	case "preview":
		$edit = 1;
		$edit_id = $_REQUEST[$prod_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:$product_page_url");
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
		$edit_id = $_REQUEST[$prod_obj->primary_fld];
		
		if($children_product == 1 && $_REQUEST['submit_action'] == "add")
		$edit_id = $_SESSION['ses_selected_prnt_prod'];
		
		if($edit_id <= 0)
		{
			header("location:$product_page_url");
			exit();
		}
		
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "mkprnt":
		$edit = 1;
		$edit_id = $_REQUEST[$prod_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:$product_page_url");
			exit();
		}
		
		$display_what = "detail_frm";
		$hid_action = "save";
		$make_parent = 1;
		break;

	case "save":
		$id = $_REQUEST[$prod_obj->primary_fld];
		$redirect_page = 1;
		
				
	
		if($id <= 0)
		{//need to add the record


			if($prod_obj->insert())
				$redirect_url = "$product_page_url";
			else
				$redirect_url = "$product_page_url?submit_action=add";
		}
		else
		{			
			if($prod_obj->update($id))
				$redirect_url = "$product_page_url";
			else
				$redirect_url = "$product_page_url?submit_action=edit&" . $prod_obj->primary_fld . "=" . $_REQUEST[$prod_obj->primary_fld];
				
		} 
		
		break;

	case "delete":
		$id = $_REQUEST[$prod_obj->primary_fld];
		if($id <= 0)
		{
			header("location:$product_page_url");
			exit();
		}
		else
		{
			$prod_obj->delete($id); 
			$redirect_page = 1;
			$redirect_url = "$product_page_url";
		}
		break;

	case "dissolve":
		$prod_obj->dissolve_group($_REQUEST['prnt_prod_id']);
		$redirect_url = "$product_page_url";
		$redirect_page = 1;
		break;
		
		
	case "status":
		$redirect_page = 1;
		if($_REQUEST['status'] == 0)
		$status = 1;
		else
		$status = 0;
		
		$status_id = $_REQUEST['id'];
		$approv_qry= "update ".$prod_obj->cls_tbl. " set prod_status ='".$status."', date_modified=now() where prod_id ='".$status_id."'";
		
		$res = database_manipulation::execute_sql($approv_qry, "update");
		if ($status == 1)
		frame_notices("Product status changed to active !!", "greenfont");
		else
		frame_notices("Product status changed to inactive !!", "greenfont");
		
		if($flag=="search")
		{
		$redirect_url="frame_search.php";
		}
		else
		{
		$redirect_url = "product_master.php";
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
	
	case "detail_frm":
		require_once("../forms/admin/product_master_detail_frm.php"); 
		break;

	case "list_frm";
		require_once("../forms/admin/product_master_list_frm.php");
		break;

	case "preview_frm";
		require_once("../forms/admin/product_master_preview_frm.php"); 
		break;
		

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>