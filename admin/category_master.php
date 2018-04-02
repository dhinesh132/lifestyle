<?php
require_once("admin_header.php"); 

require_once("../classes/category_master.class.php");


$cat_obj = new category_master();

	$count_qry= "select min(display_order), max(display_order) from ". $cat_obj->cls_tbl;
	$count_res = $GLOBALS['db_con_obj']->execute_sql($count_qry);
	$count_data = mysql_fetch_array($count_res[0]);



$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

$admin_menu_file ="category_master.php";


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
		$edit_id = $_REQUEST[$cat_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:$admin_menu_file");
			exit();
		}
		
		$edit_res = $cat_obj->fetch_record($supplier_id);
		
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$cat_obj->primary_fld];
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			$cat_obj->display_order['save_todb'] = "true";
			$cat_obj->display_order['value'] = ($count_data[1]+1);
			if($cat_obj->insert())
				$redirect_url = "$admin_menu_file";
			else
				$redirect_url = "$admin_menu_file?submit_action=add";
		
		}
		else
		{//update the record
			if($cat_obj->update($id))
				$redirect_url = "$admin_menu_file";
			else
				$redirect_url = "$admin_menu_file?submit_action=edit&" . $cat_obj->primary_fld . "=" . $_REQUEST[$cat_obj->primary_fld];
		} 
		break;

	case "delete":
		$id = $_REQUEST[$cat_obj->primary_fld];
		if($id <= 0)
		{
			header("location:$admin_menu_file");
			exit();
		}
		else
		{
		
			$cat_obj->delete($id);				
		
			$redirect_page = 1;
			$redirect_url = "$admin_menu_file";
		}
		break;
		
	case "order":
			$id = $_REQUEST[$cat_obj->primary_fld];
			if($_REQUEST['perform'] == "down") {
			$order_qry= "update ".$cat_obj->cls_tbl. " set display_order ='".($_REQUEST['order_id'])."', date_modified = now() where display_order ='".($_REQUEST['order_id']+1)."'";
			
			$res = database_manipulation::execute_sql($order_qry, "update");
			
			$order_qry= "update ".$cat_obj->cls_tbl. " set display_order ='".($_REQUEST['order_id']+1)."', date_modified = now() where cat_id ='".$id."'";
			
			$res = database_manipulation::execute_sql($order_qry, "update");
			}
			
			if($_REQUEST['perform'] == "up") {
			$order_qry= "update ".$cat_obj->cls_tbl. " set display_order ='".($_REQUEST['order_id'])."', date_modified = now() where display_order ='".($_REQUEST['order_id']-1)."'";
			
			$res = database_manipulation::execute_sql($order_qry, "update");
			
			$order_qry= "update ".$cat_obj->cls_tbl. " set display_order ='".($_REQUEST['order_id']-1)."', date_modified = now() where cat_id ='".$id."'";
			
			$res = database_manipulation::execute_sql($order_qry, "update");
			}


			frame_notices("Category dispaly order successfully updated !!", "greenfont");
			$redirect_page = 1;
			$redirect_url = "category_master.php";
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
		require_once("../forms/admin/category_master_detail_frm.php"); 
		break;

	case "list_frm";
		require_once("../forms/admin/category_master_list_frm.php"); 
		break;

	case "preview_frm";
		require_once("../forms/admin/category_master_preview_frm.php"); 
		break;
		

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>