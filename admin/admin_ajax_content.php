<?php 

require_once("../includes/admin_code_header.php");

$required = $_REQUEST['required'];

//$alpha = array(1 => "A", "B", "C", "D", "E", "F", "G","H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");


//echo "dsdsaddaaasdsdsd";
//exit();
switch ($required)
{
	
	
	case "promotion":
		$category = $_REQUEST['category'];		 	 
			$qry = "select EnName,Id from products where ProdStatus=1 and Function in(".$category.") order by EnName";
			$item_res = $GLOBALS['db_con_obj']->execute_sql($qry,"select");
			$display_text .= '<select name="PromoItems[]" class="mediumtxtbox"  multiple="multiple" style="height:120px;">
			<option value="" >Select Products</option>';
			while($item_data = mysql_fetch_object($item_res[0])){
				$display_text .= '<option value="'.$item_data->Id.'" selected="selected">'.$item_data->EnName.'</option>';
			 }	
			 $display_text .= '</select>';
		  echo $display_text;
		  exit;
	break;
	
	case "relateditem":
		$category = $_REQUEST['category'];		 
			$qry = "select Name,Id from products where ProdStatus=1 and Category in(".$category.") order by Name";
			$item_res = $GLOBALS['db_con_obj']->execute_sql($qry,"select");
			$display_text .= '<select name="RelatedItems[]" class="mediumtxtbox"  multiple="multiple" style="height:120px;">
			<option value="" >Select Products</option>';
			while($item_data = mysql_fetch_object($item_res[0])){
				$display_text .= '<option value="'.$item_data->Id.'">'.$item_data->Name.'</option>';
			 }	
			 $display_text .= '</select>';
		  echo $display_text;
		  exit;
	break;
	
	case "consultation":
		$category = $_REQUEST['category'];		 
			$qry = "select Name,Id from products where ProdStatus=1 and Category in(".$category.") order by Name";
			$item_res = $GLOBALS['db_con_obj']->execute_sql($qry,"select");
			$display_text .= '<select name="ProdId" class="mediumtxtbox"  >
			<option value="" >Select Products</option>';
			while($item_data = mysql_fetch_object($item_res[0])){
				$display_text .= '<option value="'.$item_data->Id.'">'.$item_data->Name.'</option>';
			 }	
			 $display_text .= '</select>';
		  echo $display_text;
		  exit;
	break;
	
	case "closeprmobar":
		$_SESSION['ses_close_bar'] = 1;
		echo "";
		exit;
	break;
	
	case "promotions":
		 $menu = $_REQUEST['menu'];
		  $menus = explode(",",$menu);
		  $menu_flr_qry ="";
		  if(count($menus)>0 && $_REQUEST['menu'] !=''){
			  foreach($menus as $key =>$val){
				  $menus = 1;
				 $qry_str .= " concat(',',Types,',') Like '%,".trim($val).",%' or";
			  }
			  if( $menus == 1){
				$qry_str = substr($qry_str,0,-2);
				$menu_flr_qry  = "and (". $qry_str.")";
			  }
		  }
		  $filterby='';
		  $fltrby_title = $_REQUEST['filterby'];		  
		  if(isset($fltrby_title) && $fltrby_title !='' && 1==2){
			  $filterby .= " and  concat(',',EnName,',') Like '%".trim($fltrby_title)."%' ";
		  }
		  
			$display_text = ' <select name="SelectItem[]" class="mediumtxtbox" multiple="multiple" style="height:150px; width:350px" id="SelectedItemId">';
			$qry = "select EnName,Id  from products where ProdStatus=1 ". $menu_flr_qry. $filterby;
			$dish_res = $GLOBALS['db_con_obj']->execute_sql($qry,"select");
			while($dish_data = mysql_fetch_object($dish_res[0])){
				$display_text .= ' <option value="'.$dish_data->Id.'" >'.$dish_data->EnName.'</option>';
			 }			
			$display_text .= '</select>';
		  echo $display_text;
	      exit;
	break;
	
	
}//end switch

?>