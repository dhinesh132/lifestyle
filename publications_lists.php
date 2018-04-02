<?php 
$spl_doc_title = "Products";
require_once("header.php"); 
require_once(dirname(__FILE__) . '/classes/functions.class.php');
$fun_obj = new functions();
$cat_id = $_REQUEST['cat_id'];

$fun_res= $GLOBALS['db_con_obj']->fetch_flds($fun_obj->cls_tbl,"*","UniqueKey='".$key."' and FunStatus =1 order by DisplayOrder DESC");
$fun_data = mysql_fetch_object($fun_res[0]);



 $cat_name = $cat_data->cat_name;
 $parent_id = $cat_data->parent_id;
 
 $submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

if(isset($_REQUEST['fun']) && $_REQUEST['fun'] =='all'){
	unset($_SESSION['ses_temp_search_obj']['fun']);
}
else if(isset($_REQUEST['fun']) && $_REQUEST['fun'] >0){
	unset($_SESSION['ses_temp_search_obj']);
	$_SESSION['ses_temp_search_obj']['functions'][] = $_REQUEST['fun'];
}

//echo $_SESSION['ses_temp_search_obj']['functions'];echo "hahahahha";
switch ($submit_action)
{
	case "search":
			unset($_SESSION['ses_temp_search_obj']['functions']);
			unset($_SESSION['ses_temp_search_obj']['materials']);
			unset($_SESSION['ses_temp_search_obj']['types']);			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_search_obj'][$ky] = $vl;
			
		
			header("location:product_lists.php");
			exit();
		
	 break;
	 
	 // from home page 
	 case "index_filder":
			unset($_SESSION['ses_temp_search_obj']['functions']);
			unset($_SESSION['ses_temp_search_obj']['materials']);
			unset($_SESSION['ses_temp_search_obj']['types']);
			unset($_SESSION['ses_temp_search_obj']['keyword']);	
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_search_obj'][$ky] = $vl;
			
			if(isset($_REQUEST['price_range']) && strlen($_REQUEST['price_range'])>0){
				$prices = explode("-",$_REQUEST['price_range']);
				$_SESSION['ses_temp_search_obj']['PriceFrom'] = $prices[0];
				$_SESSION['ses_temp_search_obj']['PriceTo'] = $prices[1];
			}
			
			header("location:product_lists.php");
			exit();
	 break;
	 
	 case "filter":
			if(isset($_REQUEST['perPage']) && $_REQUEST['perPage'] >0){
				$_SESSION['ses_temp_search_obj']['tot_rec'] = $_REQUEST['perPage'];
			}
			if(isset($_REQUEST['sortBy']) && $_REQUEST['sortBy'] !=''){
				$_SESSION['ses_temp_search_obj']['sort_by'] = $_REQUEST['sortBy'];
			}		
			header("location:product_lists.php");
			exit();
	 break;
	 
	 case "searchbyname":
	 //print_r($_REQUEST['keyword']);
	 	 if(isset($_REQUEST['keyword']) && $_REQUEST['keyword'] !='' && $_REQUEST['keyword'] !='Search emblems'){
			 unset($_SESSION['ses_temp_search_obj']);
			 $_SESSION['ses_temp_search_obj']['keyword'] = strip_tags($_REQUEST['keyword']);
		 }else{
			 unset($_SESSION['ses_temp_search_obj']['keyword']);
		 }
		// print_r($_SESSION['ses_temp_search_obj']['keyword']);
		// exit;
		 header("location:product_lists.php");
		exit();
	 break;
	
}
	
	require_once("includes/error_message.php");
	require_once("templates/publication_lists.php");
	
	

require_once("footer.php"); 

?>