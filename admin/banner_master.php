<?php

require_once("admin_header.php"); 



require_once("../classes/banner_master.class.php");

require_once("../components/fckeditor/fckeditor.php"); 



$ban_obj = new banner_master();



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

			header("location:banner_master.php");

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

			header("location:banner_master.php");

			exit();

		}

		

		$edit_res = $ban_obj->fetch_record($id);

		$display_what = "detail_frm";

		$hid_action = "save";

		break;



	case "save":

		$id = $_REQUEST[$ban_obj->primary_fld];

			

		$redirect_page = 1;

		if($id <= 0)

		{//need to add the record

			

			if($ban_obj->insert())

				$redirect_url = "banner_master.php";

			else

				$redirect_url = "banner_master.php?submit_action=add";

		

		}

		else

		{//update the record

 

 			if($ban_obj->update($id))

				$redirect_url = "banner_master.php";

			else

				$redirect_url = "banner_master.php?submit_action=edit&" . $ban_obj->primary_fld . "=" . $_REQUEST[$ban_obj->primary_fld];

		} 

		break;



	case "delete":

	

		echo $id = $_REQUEST[$ban_obj->primary_fld];

		if($id <= 0)

		{

			header("location:banner_master.php");

			exit();

		}

		else

		{

		

			$ban_obj->delete($id); 

			$redirect_page = 1;

			$redirect_url = "banner_master.php";

		}

		break;

		

	case "status":

	

		$id = $_REQUEST['ban_id'];

		if($id <= 0)

		{

			header("location:banner_master.php");

			exit();

		}

		else

		{

		

			$ban_status = $_REQUEST['ban_status'];



			if($ban_status == 1)

				$update = "update ".$ban_obj->cls_tbl." set ban_status = 0 where ban_id='".$id."'";

			else if($ban_status == 0)

				$update = "update ".$ban_obj->cls_tbl." set ban_status = 1 where ban_id='".$id."'";

				

			$GLOBALS['db_con_obj']->execute_sql($update,"update");

			frame_notices("Status successfully updated !!", "greenfont", 1);

			$redirect_page = 1;

			$redirect_url = "banner_master.php";

		}

		break;case "order":

		//$GLOBALS['site_config']['debug'] =1;

			if($_REQUEST['perform'] == "down") {

			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($ban_obj->cls_tbl, "ban_id,display_order", " display_order < '".$_REQUEST['order_id']."' order by display_order desc limit 0,1");

			

			$ord_data = mysql_fetch_object($ord_res[0]);

			

			$order_qry= "update ".$ban_obj->cls_tbl. " set display_order ='".$ord_data->display_order."' where  ban_id='".$_REQUEST['ban_id']."'";

			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");

			

			$order_qry= "update ".$ban_obj->cls_tbl. " set display_order ='".($_REQUEST['order_id'])."' where ban_id ='".$ord_data->ban_id."'";

			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");

			}

			

			if($_REQUEST['perform'] == "up") {

			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($ban_obj->cls_tbl,"ban_id,display_order"," display_order >'".$_REQUEST['order_id']."' order by display_order asc limit 0,1");

			

			$ord_data = mysql_fetch_object($ord_res[0]);

			

			$order_qry= "update ".$ban_obj->cls_tbl. " set display_order ='".$ord_data->display_order."' where ban_id='".$_REQUEST['ban_id']."'";

			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");

			

			$order_qry= "update ".$ban_obj->cls_tbl. " set display_order ='".($_REQUEST['order_id'])."' where ban_id ='".$ord_data->ban_id."'";

			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");

			

			}

			frame_notices("Dispaly order successfully updated !!", "greenfont");

			$redirect_page = 1;

			$redirect_url = "banner_master.php";

			

		break;



} //end switch





if($redirect_page == 1)

{

	header("location:$redirect_url");

	exit();

}

	

?>





 <h1>Manage Masthead</h1>

<?php

	

require_once("../includes/error_message.php");



switch ($display_what)

{



	case "detail_frm";

		require_once("../forms/admin/banner_master_detail_frm.php"); 

		break;

	

	case "list_frm";

		require_once("../forms/admin/banner_master_list_frm.php"); 

		break;



	



} //end switch



?>




<?php 



require_once("admin_footer.php"); 



?>