<?php
require_once("admin_header.php"); 

require_once("../classes/product_colours.class.php");
require_once("../components/fckeditor/fckeditor.php"); 
$prod_obj = new product_colours();

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

$cat_count_qry = "select min(DisplayOrder), max(DisplayOrder) from ". $prod_obj->cls_tbl ." where 1=1 and ProdId=".$_SESSION['ses_prod_id'];
$cat_count_res = $GLOBALS['db_con_obj']->execute_sql($cat_count_qry);
$cat_count_data = mysql_fetch_array($cat_count_res[0]);

switch ($submit_action)
{
	case "preview":
		$edit = 1;
		$edit_id = $_REQUEST[$prod_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:product_colours.php");
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
			header("location:product_colours.php");
			exit();
		}
		
		$edit_res = $prod_obj->fetch_record($id);
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
	$id = $_REQUEST[$prod_obj->primary_fld];
	//$GLOBALS['site_config']['debug']=1;
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($prod_obj->insert())
				$redirect_url = "product_colours.php";
			else
				$redirect_url = "product_colours.php?submit_action=add";
		
		}
		else
		{//update the record
 			
				if($prod_obj->update($id))
				{	
					$redirect_url = "product_colours.php";
					}
				else
				{
					
					$redirect_url = "product_colours.php?submit_action=edit&" . $prod_obj->primary_fld . "=" . $_REQUEST[$prod_obj->primary_fld];
				}
			
		} 
		//exit;
		break;

	case "delete":
	
		echo $id = $_REQUEST[$prod_obj->primary_fld];
		if($id <= 0)
		{
			header("location:product_colours.php");
			exit();
		}
		else
		{
		
			$prod_obj->delete($id); 
			$redirect_page = 1;
			$redirect_url = "product_colours.php";
		}
		break;
		
	case "status":
	
		$id = $_REQUEST['Id'];
		if($id <= 0)
		{
			header("location:product_colours.php");
			exit();
		}
		else
		{
		
			$ban_status = $_REQUEST['Status'];

			if($ban_status == 1)
				$update = "update ".$prod_obj->cls_tbl." set Status = 0 where Id='".$id."'";
			else if($ban_status == 0)
				$update = "update ".$prod_obj->cls_tbl." set Status = 1 where Id='".$id."'";
				
			$GLOBALS['db_con_obj']->execute_sql($update,"update");
			frame_notices("Status successfully updated !!", "greenfont", 1);
			$redirect_page = 1;
			$redirect_url = "product_colours.php";
		}
		break;
		
		case "order":
		//$GLOBALS['site_config']['debug'] =1;
			if($_REQUEST['perform'] == "down") {
			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($prod_obj->cls_tbl, "Id,DisplayOrder", "ProdId= ".$_SESSION['ses_prod_id']." and DisplayOrder < '".$_REQUEST['order_id']."' order by DisplayOrder desc limit 0,1");
			
			$ord_data = mysql_fetch_object($ord_res[0]);
			
			$order_qry= "update ".$prod_obj->cls_tbl. " set DisplayOrder ='".$ord_data->DisplayOrder."' where Id='".$_REQUEST['Id']."'";
			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			$order_qry= "update ".$prod_obj->cls_tbl. " set DisplayOrder ='".($_REQUEST['order_id'])."' where Id ='".$ord_data->Id."'";
			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			}
			
			if($_REQUEST['perform'] == "up") {
			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($prod_obj->cls_tbl,"Id,DisplayOrder","ProdId= ".$_SESSION['ses_prod_id']." and DisplayOrder >'".$_REQUEST['order_id']."' order by DisplayOrder asc limit 0,1");
			
			$ord_data = mysql_fetch_object($ord_res[0]);
			
			$order_qry= "update ".$prod_obj->cls_tbl. " set DisplayOrder ='".$ord_data->DisplayOrder."' where Id='".$_REQUEST['Id']."'";
			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			$order_qry= "update ".$prod_obj->cls_tbl. " set DisplayOrder ='".($_REQUEST['order_id'])."' where Id ='".$ord_data->Id."'";
			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			}
			frame_notices("Dispaly order successfully updated !!", "greenfont");
			$redirect_page = 1;
			$redirect_url = "product_colours.php";
			
		break;
		

} //end switch


if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}
	
?>


 <h1> <?php echo $GLOBALS['db_con_obj']->fetch_field('products','EnName','Id ='.$_SESSION['ses_prod_id']);  ?>'s Packs & Prices</h1>
<?php
	
require_once("../includes/error_message.php");

switch ($display_what)
{

	case "detail_frm";
		require_once("../forms/admin/product_colours_detail_frm.php"); 
		break;
	
	case "list_frm";
		require_once("../forms/admin/product_colours_list_frm.php"); 
		break;

} //end switch

?>
	


<?php 

require_once("admin_footer.php"); 

?>