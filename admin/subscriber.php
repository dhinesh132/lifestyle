<?php
require_once("admin_header.php"); 
require_once("../classes/subscriber.class.php");

$email_obj = new subscriber();

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";



switch ($submit_action)
{
	case "preview":
		$edit = 1;
		$edit_id = $_REQUEST[$email_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:subscriber.php");
			exit();
		}
		
		$edit_res = $email_obj->fetch_record($id);
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$email_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:subscriber.php");
			exit();
		}
		
		$edit_res = $email_obj->fetch_record($id);
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$email_obj->primary_fld];
			
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($email_obj->insert())
				$redirect_url = "subscriber.php";
			else
				$redirect_url = "subscriber.php?submit_action=add";
		
		}
		else
		{//update the record
 
 			if($email_obj->update($id))
			{	
				$redirect_url = "subscriber.php";
				}
			else
			{
				
				$redirect_url = "subscriber.php?submit_action=edit&" . $email_obj->primary_fld . "=" . $_REQUEST[$email_obj->primary_fld];
				}
		} 
		
		break;

	case "delete":
	
		 $id = $_REQUEST[$email_obj->primary_fld];
		if($id <= 0)
		{
			header("location:subscriber.php?news_id=$news_id");
			exit();
		}
		else
		{
		
			$email_obj->delete($id); 
			$redirect_page = 1;
			$redirect_url = "subscriber.php";
		}
		break;
		
		
	case "status":
		$id = $_REQUEST[$email_obj->primary_fld];
		
		if($id <= 0)
		{
			header("location:subscriber.php");
			exit();
		}
		else
		{
			//$display_status = $_REQUEST['status'];
			echo $display_status = $GLOBALS['db_con_obj']->fetch_field($email_obj->cls_tbl,"display_status","news_id='".$id."'");
		
			
			if($display_status == 1)
				$update = "update ".$email_obj->cls_tbl." set display_status = 0 where news_id='".$id."'";
			else if(display_status == 0)
				$update = "update ".$email_obj->cls_tbl." set display_status = 1 where news_id='".$id."'";
			$GLOBALS['db_con_obj']->execute_sql($update,"update");
			frame_notices("Static page status successfully updated !!", "greenfont", 1);
			$redirect_page = 1;
			$redirect_url = "subscriber.php";
		}
		break;
		
		case "order":
		//$GLOBALS['site_config']['debug'] =1;
			if($_REQUEST['perform'] == "down") {
			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($email_obj->cls_tbl, "news_id,display_order", "display_order < '".$_REQUEST['order_id']."' order by display_order desc limit 0,1");
			
			$ord_data = mysql_fetch_object($ord_res[0]);
			
			$order_qry= "update ".$email_obj->cls_tbl. " set display_order ='".$ord_data->display_order."', date_modified = now() where news_id='".$_REQUEST['news_id']."'";
			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			$order_qry= "update ".$email_obj->cls_tbl. " set display_order ='".($_REQUEST['order_id'])."', date_modified = now() where news_id ='".$ord_data->news_id."'";
			$GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			}
			
			if($_REQUEST['perform'] == "up") {
			$ord_res = $GLOBALS['db_con_obj']->fetch_flds($email_obj->cls_tbl,"news_id,display_order"," display_order >'".$_REQUEST['order_id']."' order by display_order asc limit 0,1");
			
			$ord_data = mysql_fetch_object($ord_res[0]);
			
			$order_qry= "update ".$email_obj->cls_tbl. " set display_order ='".$ord_data->display_order."', date_modified = now() where news_id='".$_REQUEST['news_id']."'";
			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			$order_qry= "update ".$email_obj->cls_tbl. " set display_order ='".($_REQUEST['order_id'])."', date_modified = now() where news_id ='".$ord_data->news_id."'";
			$res = $GLOBALS['db_con_obj']->execute_sql($order_qry, "update");
			
			}
			//exit;
			frame_notices("News dispaly order successfully updated !!", "greenfont");
			$redirect_page = 1;
			$redirect_url = "subscriber.php";
			
		break;
		
		case "search":
			if($frm_pag!="")
			{
				$arr_res=$email_obj->search_query();
				$_SESSION['ses_sub_srch_qry'] = $arr_res;
				header("location:subscriber.php");
				exit();
			}
			else
			{			
				$arr_res=$email_obj->search_query();
				$_SESSION['ses_sub_srch_qry'] = $arr_res;
				header("location:subscriber.php");
				exit();	
			}
		break;
	
		case "clear":
			unset($_SESSION['ses_sub_srch_vars']);
			unset($_SESSION['ses_sub_srch_qry']);
		break;
	

} //end switch


if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}
	
?>


<h1>Manage Subscriber </h1>
<?php
	
require_once("../includes/error_message.php");

switch ($display_what)
{

	case "detail_frm";
		require_once("../forms/admin/subscriber_detail_frm.php"); 
		break;
	
	case "list_frm";
		require_once("../forms/admin/subscriber_list_frm.php"); 
		break;

	

} //end switch

?>


<?php 

require_once("admin_footer.php"); 

?>