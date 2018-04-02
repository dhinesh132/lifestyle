<?php 
$spl_doc_title = "Products";
require_once("header.php"); 
$BreadCrumb = PUBLICATION; 
$cat_id = $_REQUEST['cat_id'];


$cat_res= $GLOBALS['db_con_obj']->fetch_flds($prodcat_obj->cls_tbl,"parent_id,cat_name","cat_id='".$cat_id."'");
$cat_data = mysql_fetch_object($cat_res[0]);

 $cat_name = $cat_data->cat_name;
 $parent_id = $cat_data->parent_id;
 
 $submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

if(isset($_REQUEST['auth']) && $_REQUEST['auth'] =='all'){
	unset($_SESSION['ses_temp_search_obj']['author']);
}
else if(isset($_REQUEST['auth']) && $_REQUEST['auth'] >0){
	unset($_SESSION['ses_temp_search_obj']);
	$_SESSION['ses_temp_search_obj']['author']= $_REQUEST['auth'];
}
//echo $_SESSION['ses_temp_search_obj']['author'];
//echo $_SESSION['ses_temp_search_obj']['functions'];echo "hahahahha";
switch ($submit_action)
{
	case "search":
			unset($_SESSION['ses_temp_search_obj']['author']);			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_search_obj'][$ky] = $vl;
			
		
			header("location:publication_lists.php");
			exit();
		
	 break;
	 
	 // from home page 
	 case "index_filder":
			unset($_SESSION['ses_temp_search_obj']['author']);	
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_search_obj'][$ky] = $vl;
			header("location:publication_lists.php");
			exit();
	 break;
	 
	 case "filter":
			if(isset($_REQUEST['perPage']) && $_REQUEST['perPage'] >0){
				$_SESSION['ses_temp_search_obj']['tot_rec'] = $_REQUEST['perPage'];
			}
			if(isset($_REQUEST['sortBy']) && $_REQUEST['sortBy'] !=''){
				$_SESSION['ses_temp_search_obj']['sort_by'] = $_REQUEST['sortBy'];
			}		
			header("location:publication_lists.php");
			exit();
	 break;
	 
	 case "searchbyname":
	 	 if(isset($_REQUEST['keyword']) && $_REQUEST['keyword'] !=''){
			 $_SESSION['ses_temp_search_obj']['keyword'] = strip_tags($_REQUEST['keyword']);
		 }else{
			 unset($_SESSION['ses_temp_search_obj']['keyword']);
		 }
		 header("location:publication_lists.php");
		exit();
	 break;
	
}
	
	require_once("includes/error_message.php");
	require_once("forms/publication_list_frm.php");
	
	

require_once("footer.php"); 

?>