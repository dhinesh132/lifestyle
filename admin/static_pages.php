<?php
require_once("admin_header.php"); 


require_once("../components/fckeditor/fckeditor.php"); 


require_once("../classes/static_pages.class.php");
//require_once("../classes/category_master.class.php");

$sbg_obj = new static_pages();
//$sbg_obj = new category_master();

$cat_count_qry = "select min(display_order), max(display_order) from ". $sbg_obj->cls_tbl;
$cat_count_res = $GLOBALS['db_con_obj']->execute_sql($cat_count_qry);
$cat_count_data = mysql_fetch_array($cat_count_res[0]);


$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";


switch ($submit_action)
{
	case "preview":
		$edit = 1;
		$edit_id = $_REQUEST[$sbg_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:static_pages.php");
			exit();
		}
		
		$edit_res = $sbg_obj->fetch_record($id);
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$sbg_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:static_pages.php");
			exit();
		}
		
		$edit_res = $sbg_obj->fetch_record($id);
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$sbg_obj->primary_fld];
			
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($sbg_obj->insert())
				$redirect_url = "static_pages.php";
			else
				$redirect_url = "static_pages.php?submit_action=add";
		
		}
		else
		{//update the record
 
 			if($sbg_obj->update($id))
			{	
				$redirect_url = "static_pages.php";
				}
			else
			{
				
				$redirect_url = "static_pages.php?submit_action=edit&" . $sbg_obj->primary_fld . "=" . $_REQUEST[$sbg_obj->primary_fld];
				}
		} 
		
		break;

	case "delete":
	
		 $id = $_REQUEST[$sbg_obj->primary_fld];
		if($id <= 0)
		{
			header("location:static_pages.php?page_id=$page_id");
			exit();
		}
		else
		{
		
			$sbg_obj->delete($id); 
			$redirect_page = 1;
			$redirect_url = "static_pages.php";
		}
		break;
		
		case "hide":
	
		 $id = $_REQUEST[$sbg_obj->primary_fld];
		if($id <= 0)
		{
			header("location:static_pages.php");
			exit();
		}
		else
		{
			$update_qry= "update ".$sbg_obj->cls_tbl. " set del_status = 1 where ".$sbg_obj->primary_fld ." = '".$id."'";
			$GLOBALS['db_con_obj']->execute_sql($update_qry, "update");
			frame_notices("Product details successfully deleted !!", "redfont");
			$redirect_page = 1;
			$redirect_url = "static_pages.php";
		}
		break;
	case "status":

		$id = $_REQUEST[$sbg_obj->primary_fld];

		

		if($id <= 0)

		{

			$redirect_page = 1;

			$redirect_url = "static_pages.php";


		}

		else

		{

			//$display_status = $_REQUEST['status'];

			$display_status = $GLOBALS['db_con_obj']->fetch_field($sbg_obj->cls_tbl,"display_status","Id='".$id."'");

		

			

			if($display_status == 1)

				$update = "update ".$sbg_obj->cls_tbl." set display_status = 0 where Id='".$id."'";

			else if(display_status == 0)

				$update = "update ".$sbg_obj->cls_tbl." set display_status = 1 where Id='".$id."'";

			$GLOBALS['db_con_obj']->execute_sql($update,"update");

			frame_notices("Static page status successfully updated !!", "greenfont", 1);

			$redirect_page = 1;

			$redirect_url = "static_pages.php";

		}

		break;
		
		case "order":
		//$GLOBALS['site_config']['debug'] =1;
			if($_REQUEST['perform'] == "down") {
			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($sbg_obj->cls_tbl, "page_id,display_order", "display_order < '".$_REQUEST['order_id']."' order by display_order desc limit 0,1");
			
			$ord_data = mysql_fetch_object($ord_res[0]);
			
			$order_qry= "update ".$sbg_obj->cls_tbl. " set display_order ='".$ord_data->display_order."', date_modified = now() where page_id='".$_REQUEST['page_id']."'";
			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			$order_qry= "update ".$sbg_obj->cls_tbl. " set display_order ='".($_REQUEST['order_id'])."', date_modified = now() where page_id ='".$ord_data->page_id."'";
			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			}
			
			if($_REQUEST['perform'] == "up") {
			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($sbg_obj->cls_tbl,"page_id,display_order"," display_order >'".$_REQUEST['order_id']."' order by display_order asc limit 0,1");
			
			$ord_data = mysql_fetch_object($ord_res[0]);
			
			$order_qry= "update ".$sbg_obj->cls_tbl. " set display_order ='".$ord_data->display_order."', date_modified = now() where page_id='".$_REQUEST['page_id']."'";
			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			$order_qry= "update ".$sbg_obj->cls_tbl. " set display_order ='".($_REQUEST['order_id'])."', date_modified = now() where page_id ='".$ord_data->page_id."'";
			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			}
			frame_notices("Menu dispaly order successfully updated !!", "greenfont");
			$redirect_page = 1;
			$redirect_url = "static_pages.php";
			
		break;
	

} //end switch


if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}
	
?>


 <h1>Manage Page Content</h1>
<?php
	
require_once("../includes/error_message.php");

switch ($display_what)
{

	case "detail_frm";
		require_once("../forms/admin/static_pages_detail_frm.php"); 
		break;
	
	case "list_frm";
		require_once("../forms/admin/static_pages_list_frm.php"); 
		break;

	

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>