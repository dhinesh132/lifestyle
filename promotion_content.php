<?php 
$spl_doc_title = "promotion";
require_once("header.php"); 
require_once(dirname(__FILE__) . '/classes/functions.class.php');
$fun_obj = new functions();
require_once(dirname(__FILE__) . '/classes/promotion_banner.class.php');
$promo_obj = new promotion_banner();
$cat_id = $_REQUEST['cat_id'];

$key = $_REQUEST['key'];
$promo_res = $GLOBALS['db_con_obj']->fetch_flds($promo_obj->cls_tbl,"*","UniqueKey='".$key."' and Status=1 ");
$promo_data = mysql_fetch_object($promo_res[0]);


$image_path = $GLOBALS['site_config']['site_path'].$promo_obj->attachment_path.$promo_data->BigBanImage;;
$submit_action = $_REQUEST['submit_action'];

$bredcruburl = $GLOBALS['site_config']['site_path']."index/Promotions";
$BreadCrumb = "Promotion";
	
	
$display_what = "list_frm";

	
	require_once("includes/error_message.php");
	require_once("templates/promo_prod_lists.php");
	
	

require_once("footer.php"); 

?>