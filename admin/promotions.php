<?php

require_once("admin_header.php"); 

require_once("../classes/promotions.class.php");
require_once("../components/fckeditor/fckeditor.php"); 
require_once("../classes/products.class.php");

$ban_obj = new promotions();
$prod_obj = new products();

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";



$cat_count_qry = "select min(display_order), max(display_order) from ". $ban_obj->cls_tbl;

$cat_count_res = $GLOBALS['db_con_obj']->execute_sql($cat_count_qry);

$cat_count_data = mysql_fetch_array($cat_count_res[0]);





switch ($submit_action)

{

	case "preview":

		$edit = 1;

		$edit_id = $_REQUEST[$ban_obj->primary_fld];

		if($edit_id <= 0)

		{

			header("location:promotions.php");

			exit();

		}

		

		$edit_res = $ban_obj->fetch_record($id);

	    $display_what = "preview_frm";

	 break;

	

	case "add":

		$display_what = "detail_frm";

		$hid_action = "save";

		break;



	case "edit":

		$edit = 1;

		$edit_id = $_REQUEST[$ban_obj->primary_fld];

		if($edit_id <= 0)

		{

			header("location:promotions.php");

			exit();

		}

		

		$edit_res = $ban_obj->fetch_record($id);

		$display_what = "detail_frm";

		$hid_action = "save";

		break;



	case "save":
	
		//$GLOBALS['site_config']['debug'] =1;

		$id = $_REQUEST[$ban_obj->primary_fld];

		if(empty($_REQUEST['CustomerLogin'])){
			$ban_obj->CustomerLogin['save_todb'] = 'true';
			$ban_obj->CustomerLogin['value'] =0;
		}
		if(empty($_REQUEST['MinAmountVal'])){
			$ban_obj->MinAmountVal['save_todb'] = 'true';
			$ban_obj->MinAmountVal['value'] =0;
		}
		
		
		if(isset($_REQUEST['ListCate'])){
			$Category = implode(",",$_REQUEST['ListCate']);
			$ban_obj->CateId['save_todb'] = 'true';
			$ban_obj->CateId['value'] =$Category;
		}
		if(isset($_REQUEST['PromoItems'])){
			$items = implode(",",$_REQUEST['PromoItems']);
			$ban_obj->ItemId['save_todb'] = 'true';
			$ban_obj->ItemId['value'] =$items;
		}
		$redirect_page = 1;

		if($id <= 0)

		{//need to add the record

			

			if($ban_obj->insert())

				$redirect_url = "promotions.php";

			else

				$redirect_url = "promotions.php?submit_action=add";

		

		}

		else

		{//update the record

 

 			if($ban_obj->update($id))

				$redirect_url = "promotions.php";

			else

				$redirect_url = "promotions.php?submit_action=edit&" . $ban_obj->primary_fld . "=" . $_REQUEST[$ban_obj->primary_fld];

		} 
		
		//exit;
		break;



	case "delete":

	

		$id = $_REQUEST[$ban_obj->primary_fld];

		if($id <= 0)

		{

			header("location:promotions.php");

			exit();

		}

		else

		{

		

			$ban_obj->delete($id); 

			$redirect_page = 1;

			$redirect_url = "promotions.php";

		}

		break;

		

	case "status":

	

		$id = $_REQUEST['Id'];

		if($id <= 0)

		{

			header("location:promotions.php");

			exit();

		}

		else

		{

		

			$Status = $_REQUEST['Status'];



			if($Status == 1)

				$update = "update ".$ban_obj->cls_tbl." set Status = 0 where Id='".$id."'";

			else if($Status == 0)

				$update = "update ".$ban_obj->cls_tbl." set Status = 1 where Id='".$id."'";

				

			$GLOBALS['db_con_obj']->execute_sql($update,"update");

			frame_notices("Status successfully updated !!", "greenfont", 1);

			$redirect_page = 1;

			$redirect_url = "promotions.php";

		}

		break;case "order":

		//$GLOBALS['site_config']['debug'] =1;

			if($_REQUEST['perform'] == "down") {

			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($ban_obj->cls_tbl, "Id,display_order", " display_order < '".$_REQUEST['order_id']."' order by display_order desc limit 0,1");

			

			$ord_data = mysql_fetch_object($ord_res[0]);

			

			$order_qry= "update ".$ban_obj->cls_tbl. " set display_order ='".$ord_data->display_order."' where  Id='".$_REQUEST['Id']."'";

			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");

			

			$order_qry= "update ".$ban_obj->cls_tbl. " set display_order ='".($_REQUEST['order_id'])."' where Id ='".$ord_data->Id."'";

			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");

			}

			

			if($_REQUEST['perform'] == "up") {

			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($ban_obj->cls_tbl,"Id,display_order"," display_order >'".$_REQUEST['order_id']."' order by display_order asc limit 0,1");

			

			$ord_data = mysql_fetch_object($ord_res[0]);

			

			$order_qry= "update ".$ban_obj->cls_tbl. " set display_order ='".$ord_data->display_order."' where Id='".$_REQUEST['Id']."'";

			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");

			

			$order_qry= "update ".$ban_obj->cls_tbl. " set display_order ='".($_REQUEST['order_id'])."' where Id ='".$ord_data->Id."'";

			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");

			

			}

			frame_notices("Dispaly order successfully updated !!", "greenfont");

			$redirect_page = 1;

			$redirect_url = "promotions.php";

			

		break;



} //end switch





if($redirect_page == 1)

{

	header("location:$redirect_url");

	exit();

}

	

?>





 <h1>Manage Discount / Promotion</h1>

<?php

	

require_once("../includes/error_message.php");



switch ($display_what)

{



	case "detail_frm";

		require_once("../forms/admin/promotions_detail_frm.php"); 

		break;

	

	case "list_frm";

		require_once("../forms/admin/promotions_list_frm.php"); 

		break;



	



} //end switch



?>




<?php 



require_once("admin_footer.php"); 



?>