<?php
require_once("admin_header.php"); 

require_once("../classes/products.class.php");
require_once("../components/fckeditor/fckeditor.php"); 
require_once("../classes/prod_qty_notify.class.php");
require_once("../classes/minimum_qty_products.class.php");

$qty_notify = new minimum_qty_products();
$prod_obj = new products();
$notify_obj = new prod_qty_notify();

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

$cat_count_qry = "select min(DisplayOrder), max(DisplayOrder) from ". $prod_obj->cls_tbl;
$cat_count_res = $GLOBALS['db_con_obj']->execute_sql($cat_count_qry);
$cat_count_data = mysql_fetch_array($cat_count_res[0]);

switch ($submit_action)
{
	case "preview":
		$edit = 1;
		$edit_id = $_REQUEST[$prod_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:products.php");
			exit();
		}
		
		$edit_res = $prod_obj->fetch_record($id);
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$prod_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:products.php");
			exit();
		}
		
		$edit_res = $prod_obj->fetch_record($id);
		$display_what = "detail_frm";
		$hid_action = "save";
		break;
	case "update_qty":
		$edit = 1;
		$edit_id = $_REQUEST[$prod_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:products.php");
			exit();
		}
		
		$edit_res = $prod_obj->fetch_record($id);
		$display_what = "update_qty_frm";
		$hid_action = "save";
		break;
	case "save":
		$id = $_REQUEST[$prod_obj->primary_fld];
		if(isset($_REQUEST['TypeArray'])){
			$prod_obj->Types['save_todb'] ="true";
			$prod_obj->Types['value'] = implode(",",$_REQUEST['TypeArray']);
		}
		if(isset($_REQUEST['FunctionArray'])){
			$prod_obj->Function['save_todb'] ="true";
			$prod_obj->Function['value'] = implode(",",$_REQUEST['FunctionArray']);
		}
		if(isset($_REQUEST['FunctionArray'])){
			$prod_obj->Material['save_todb'] ="true";
			$prod_obj->Material['value'] = implode(",",$_REQUEST['MaterialArray']);
		}
		
		if(isset($_REQUEST['GroupArray'])){
			$prod_obj->Groups['save_todb'] ="true";
			$prod_obj->Groups['value'] = implode(",",$_REQUEST['GroupArray']);
		}
		
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($prod_obj->insert())
				$redirect_url = "products.php";
			else
				$redirect_url = "products.php?submit_action=add";
		
		}
		else
		{//update the record
 			if(isset($_REQUEST['sub_action']) && $_REQUEST['sub_action'] =='Quantity'){
				$prod_obj->Quantity['save_todb'] ="true";
				$total_qty  =  $_REQUEST['ExtraQty']+$_REQUEST['TotalQty'];
				$prod_obj->Quantity['value'] = $total_qty;
				$prod_obj->update($id);
				$redirect_url = "products.php";
				$notify_obj->send_notification($id);
				
				/*if($id >0){
					$delete_qry = "Delete from ".$qty_notify->cls_tbl." WHERE ProdId=".$id;
					$GLOBALS['db_con_obj']->execute_sql($delete_qry);	
				}*/
			}
			else{
				if($prod_obj->update($id))
				{	
					$redirect_url = "products.php";
					}
				else
				{
					
					$redirect_url = "products.php?submit_action=edit&" . $prod_obj->primary_fld . "=" . $_REQUEST[$prod_obj->primary_fld];
				}
			}
		} 
		
		break;

	case "delete":
	
		 $id = $_REQUEST[$prod_obj->primary_fld];
		if($id <= 0)
		{
			header("location:products.php?Id=$Id");
			exit();
		}
		else
		{
		
			$prod_obj->delete($id); 
			$redirect_page = 1;
			$redirect_url = "products.php";
		}
		break;
		
		case "hide":
	
		 $id = $_REQUEST[$prod_obj->primary_fld];
		if($id <= 0)
		{
			header("location:products.php");
			exit();
		}
		else
		{
			$update_qry= "update ".$prod_obj->cls_tbl. " set del_status = 1 where ".$prod_obj->primary_fld ." = '".$id."'";
			$GLOBALS['db_con_obj']->execute_sql($update_qry, "update");
			frame_notices("Product details successfully deleted !!", "redfont");
			$redirect_page = 1;
			$redirect_url = "products.php";
		}
		break;
	case "status":
		$id = $_REQUEST['id'];
		
		if($id <= 0)
		{
			header("location:products.php");
			exit();
		}
		else
		{
			//$ProdStatus = $_REQUEST['status'];
			$ProdStatus = $GLOBALS['db_con_obj']->fetch_field($prod_obj->cls_tbl,"ProdStatus","Id='".$id."'");
		
			
			if($ProdStatus == 1)
				$update = "update ".$prod_obj->cls_tbl." set ProdStatus = 0 where Id='".$id."'";
			else if(ProdStatus == 0)
				$update = "update ".$prod_obj->cls_tbl." set ProdStatus = 1 where Id='".$id."'";
			$GLOBALS['db_con_obj']->execute_sql($update,"update");
			frame_notices("ProdStatus successfully updated !!", "greenfont", 1);
			$redirect_page = 1;
			$redirect_url = "products.php";
		}
		break;
		
		
		case "order":
		//$GLOBALS['site_config']['debug'] =1;
			if($_REQUEST['perform'] == "down") {
			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($prod_obj->cls_tbl, "Id,DisplayOrder", "DisplayOrder < '".$_REQUEST['order_id']."' order by DisplayOrder desc limit 0,1");
			
			$ord_data = mysql_fetch_object($ord_res[0]);
			
			$order_qry= "update ".$prod_obj->cls_tbl. " set DisplayOrder ='".$ord_data->DisplayOrder."' where Id='".$_REQUEST['Id']."'";
			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			$order_qry= "update ".$prod_obj->cls_tbl. " set DisplayOrder ='".($_REQUEST['order_id'])."' where Id ='".$ord_data->Id."'";
			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			}
			
			if($_REQUEST['perform'] == "up") {
			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($prod_obj->cls_tbl,"Id,DisplayOrder"," DisplayOrder >'".$_REQUEST['order_id']."' order by DisplayOrder asc limit 0,1");
			
			$ord_data = mysql_fetch_object($ord_res[0]);
			
			$order_qry= "update ".$prod_obj->cls_tbl. " set DisplayOrder ='".$ord_data->DisplayOrder."' where Id='".$_REQUEST['Id']."'";
			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			$order_qry= "update ".$prod_obj->cls_tbl. " set DisplayOrder ='".($_REQUEST['order_id'])."' where Id ='".$ord_data->Id."'";
			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			}
			frame_notices("Dispaly order successfully updated !!", "greenfont");
			$redirect_page = 1;
			$redirect_url = "products.php";
			
		break;
		
		case "search":
			$arr_res=$prod_obj->search_query();
			$_SESSION['ses_prod_srch_qry'] = $arr_res;
			$redirect_page = 1;
			$redirect_url = "products.php";
			
		break;
		
		case "clear":
			unset($_SESSION['ses_prod_srch_qry']);
			unset($_SESSION['ses_prod_srch_vars']);
			$redirect_page = 1;
			$redirect_url = "products.php";
	break;
	case "updatekey":
		$GLOBALS['site_config']['debug'] =1;
			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($prod_obj->cls_tbl, "Id,EnName", "UniqueKey is Null order by Id ");			
			while($ord_data = mysql_fetch_object($ord_res[0])) {
				$uniquekey = GenerateUniqueKey($ord_data->EnName,$prod_obj->cls_tbl);
				$order_qry= "update ".$prod_obj->cls_tbl. " set UniqueKey ='".$uniquekey ."' where Id='".$ord_data->Id."'";
				$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			}
			$redirect_page = 1;
			$redirect_url = "products.php";
			exit;
	break;
	
	case "updateorder":
			foreach($_REQUEST['Ids'] as $key => $val)
			{	$fild_name = "Ord".$val;
				$order_val = $_REQUEST[$fild_name];
				$order_qry= "update ".$prod_obj->cls_tbl. " set DisplayOrder ='".$order_val."' where Id='".$val."'";
				$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			}
			//exit;
			frame_notices("Dispaly order successfully updated !!", "greenfont");
			
			$redirect_page = 1;
			$redirect_url = "products.php";	
		break;
	
} //end switch


if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}
	
?>


 <h1>Manage Products</h1>
<?php
	
require_once("../includes/error_message.php");

switch ($display_what)
{

	case "detail_frm";
		require_once("../forms/admin/products_detail_frm.php"); 
		break;
	
	/*case "list_frm";
		require_once("../forms/admin/products_list_frm.php"); 
		break;
	*/
	case "list_frm";
		require_once("../forms/admin/products_list_frm.php"); 
		break;
	case "update_qty_frm";
		require_once("../forms/admin/update_quantity_frm.php"); 
		break;

	

} //end switch

?>



<?php 

require_once("admin_footer.php"); 

?>