<?php
require_once("admin_header.php"); 


$product_page_url = "lens_product.php";


require_once("../classes/lens_product.class.php");
require_once("../classes/productcategory.class.php");
require_once("../classes/productattributes.class.php");
//require_once("../classes/supplier_master.class.php");

require_once("../classes/author.class.php");

//$s_obj = new supplier_master();

$lens_obj = new lens_product();

$productcategory_obj = new productcategory();

$prod_attr_obj = new productattributes();

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";
$make_parent = 0;


if($_SESSION['ses_selected_prnt_prod'] > 0 && $submit_action == "add")

	$submit_action = "edit";



switch ($submit_action)
{
	case "save_base":
	
		$redirect_page = 1;
	
		foreach($_REQUEST as $ky => $vl)
		$_SESSION['ses_lens_product_obj'][$ky] = $vl;
		$redirect_url = $_SERVER["REQUEST_URI"];
		
		
		
		
	break;
	
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$lens_obj->primary_fld];
		
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

	case "save":
		$id = $_REQUEST[$lens_obj->primary_fld];
		$redirect_page = 1;
		
				
	
		if($id <= 0)
		{//need to add the record


			if($lens_obj->insert())
				$redirect_url = "$product_page_url";
			else
				$redirect_url = "$product_page_url?submit_action=add";
		}
		else
		{			
			if($lens_obj->update($id))
				$redirect_url = "$product_page_url";
			else
				$redirect_url = "$product_page_url?submit_action=edit&" . $lens_obj->primary_fld . "=" . $_REQUEST[$lens_obj->primary_fld];
				
		} 
		
		break;

	case "delete":
		$id = $_REQUEST[$lens_obj->primary_fld];
		if($id <= 0)
		{
			header("location:$product_page_url");
			exit();
		}
		else
		{
			$lens_obj->delete($id); 
			$redirect_page = 1;
			$redirect_url = "$product_page_url";
		}
		break;

		
	case "status":
		$redirect_page = 1;
		if($_REQUEST['status'] == 0)
		$status = 1;
		else
		$status = 0;
		
		$status_id = $_REQUEST['id'];
		$approv_qry= "update ".$lens_obj->cls_tbl. " set prod_status ='".$status."', date_modified=now() where lens_id ='".$status_id."'";
		
		$res = database_manipulation::execute_sql($approv_qry, "update");
		if ($status == 1)
		frame_notices("Product status changed to active !!", "greenfont");
		else
		frame_notices("Product status changed to inactive !!", "greenfont");
		
		
		$redirect_url = "lens_product.php";
		
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
		require_once("../forms/admin/lens_product_detail_frm.php"); 
		break;

	case "list_frm";
		require_once("../forms/admin/lens_product_list_frm.php");
		break;

	case "preview_frm";
		require_once("../forms/admin/lens_product_preview_frm.php"); 
		break;
		

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>