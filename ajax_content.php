<?php 

require_once("includes/code_header.php");

$required = $_REQUEST['required'];

//$alpha = array(1 => "A", "B", "C", "D", "E", "F", "G","H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

$_SESSION['ses_lang'] =$_REQUEST['language'];
		if($_SESSION['ses_lang'] =="Ch"){
			define("LANG", "Ch");
			$_SESSION['ses_lang'] ="Ch";
			include("languages/Ch.php");
		}
		else{
			$_SESSION['ses_lang'] ="En";
			define("LANG", "En");
			include("languages/En.php"); 
		}
//echo "dsdsaddaaasdsdsd";
//exit();
switch ($required)
{

	case "state":
			
			$country_id = $_REQUEST['country_id'];
			$frm_fld_name = $_REQUEST['frm_fld_name'];
			$selected_val = $_REQUEST['selected_val'];
			
			$st_res = $db_con_obj->fetch_flds("state", "stateid,state_code,statename", "countryid='" . $country_id . "'");
			
			if($st_res[1] > 0)
			{
				if(strlen($display_fld) <= 0)
				$display_fld = "state_code";
				
				$display_cont = "";
				
				$display_cont .= "<select style='width:200px' name='" . $frm_fld_name . "' onchange=\"window.document.customer_frm.cust_state.value=this.value\">";
				$display_cont .= "<option value=''>Select a State</option>";
				
				while($st_data = mysql_fetch_object($st_res[0]))
				{
	
				$sel_txt = ($selected_val == $st_data->$display_fld)?"selected":"";
				$display_cont .= "<option value='" . $st_data->$display_fld . "' " . $sel_txt . ">" . stripslashes($st_data->statename) . "</option>";
				
				} 
				$display_cont .= "</select>";
			}
			else
			{
			$display_cont = "<input style='width:193px' type='text' name='" . $frm_fld_name . "' value='" . stripslashes($selected_val) . "' onblur=\"window.document.customer_frm.cust_state.value=this.value\">";
			}
			echo $display_cont;
		break;
	
	case "filename":
		if(strlen(trim($_REQUEST['bkname'])) > 0)
		{
			$fname = strtolower(str_replace(" ","_",$_REQUEST['bkname']));
			$flname = "book_" . date("YmdHis") . "_" . $fname . ".pdf";
		}
		else
			$flname = "Please enter your book name !!";
		echo stripslashes($flname);
		break;
	case "language":
		$_SESSION['ses_lang'] =$_REQUEST['language'];
		if($_SESSION['ses_lang'] =="Ch"){
			define("LANG", "Ch");
			$_SESSION['ses_lang'] ="Ch";
			include("languages/Ch.php");
		}
		else{
			$_SESSION['ses_lang'] ="En";
			define("LANG", "En");
			include("languages/En.php"); 
		}
		
		case "left_menu":
		
		
			$string ='<div class="lightbrown-bg">
                <h2>'.FUNCTIONS.'</h2><br />
                <ul>';
				$fun_fltr_res = $db_con_obj->fetch_flds("functions", "FunId,EnName,ChName", "FunStatus =1 order by DisplayOrder desc"); 
				while($fun_fltr_data = mysql_fetch_object($fun_fltr_res[0])){
				if(in_array($fun_fltr_data->FunId,$_SESSION['ses_temp_search_obj']['functions'])){ 				
					$check_str = 'checked="checked"';
				}
				else{
					$check_str = '';
				}
                
                $string .='<li><input type="checkbox" name="functions[]" value="'.$fun_fltr_data->FunId.'" onclick="$(\'#filtr_products\').submit();"  '.$check_str.'>'.$fun_fltr_data->EnName.'</li>';
               
				}
                
                 $string .='</ul>
                </div>';
             
			 	$string .='<div class="lightbrown-bg">
                <h2>'.MATERIAL.'</h2><br />
                <ul>';
                
				$mat_res = $db_con_obj->fetch_flds("materials", "MatId,EnName,ChName", "MatStatus =1 order by DisplayOrder desc"); 
				while($mat_data = mysql_fetch_object($mat_res[0])){
				if(in_array($mat_data->MatId,$_SESSION['ses_temp_search_obj']['materials'])){
					$mat_check_str = 'checked="checked"';
				}
				else{
					$mat_check_str = '';
				}
                $string .='<li><input type="checkbox" name="materials[]" value="'.$mat_data->MatId.'"   onclick="$(\'#filtr_products\').submit();" '.$mat_check_str.'>'.$mat_data->EnName.'</li>';
               
				}
				
                $string .='</ul>
                </div>';
                
				$string .='<div class="lightbrown-bg">
                <h2>'.TYPE.'</h2><br />
                <ul>';
                
				$type_res = $db_con_obj->fetch_flds("types", "TypeId,EnName,ChName", "TypeStatus =1 order by DisplayOrder asc"); 
				while($type_data = mysql_fetch_object($type_res[0])){
					
				if(in_array($type_data->TypeId,$_SESSION['ses_temp_search_obj']['types'])){
					$type_check_str = 'checked="checked"';
				}
				else{
					$type_check_str = '';
				}
                $string .='<li><input type="checkbox" name="types[]" value="'.$type_data->TypeId.'"   onclick="$(\'#filtr_products\').submit();" '.$type_check_str.'>'.$type_data->EnName.'</li>';
               
				}
				
                $string .='</ul>
                </div>';
			   echo $string;
			   
		break;
		
		case "left_function":
		
		
			$string ='<div class="lightbrown-bg">
                <h2>'.FUNCTIONS.'</h2><br />
                <ul>';
				$fun_fltr_res = $db_con_obj->fetch_flds("functions", "FunId,EnName,ChName", "FunStatus =1 order by DisplayOrder desc"); 
				while($fun_fltr_data = mysql_fetch_object($fun_fltr_res[0])){
				if(in_array($fun_fltr_data->FunId,$_SESSION['ses_temp_search_obj']['functions'])){ 				
					$check_str = 'checked="checked"';
				}
				else{
					$check_str = '';
				}
                
                $string .='<li><input type="checkbox" name="functions[]" value="'.$fun_fltr_data->FunId.'" onclick="$(\'#filtr_products\').submit();"  '.$check_str.'>'.$fun_fltr_data->EnName.'</li>';
               
				}
                
                 $string .='</ul>
                </div>';
				
				echo $string;
             		
			break;
		
		case "left_material":
			$string .='<div class="lightbrown-bg">
                <h2>'.MATERIAL.'</h2><br />
                <ul>';
                
				$mat_res = $db_con_obj->fetch_flds("materials", "MatId,EnName,ChName", "MatStatus =1 order by DisplayOrder desc"); 
				while($mat_data = mysql_fetch_object($mat_res[0])){
				if(in_array($mat_data->MatId,$_SESSION['ses_temp_search_obj']['materials'])){
					$mat_check_str = 'checked="checked"';
				}
				else{
					$mat_check_str = '';
				}
                $string .='<li><input type="checkbox" name="materials[]" value="'.$mat_data->MatId.'"   onclick="$(\'#filtr_products\').submit();" '.$mat_check_str.'>'.$mat_data->EnName.'</li>';
               
				}
				
                $string .='</ul>
                </div>';
				
				echo  $string;
		break;
		
		case "left_type":
		$string .='<div class="lightbrown-bg">
                <h2>'.TYPE.'</h2><br />
                <ul>';
                
				$type_res = $db_con_obj->fetch_flds("types", "TypeId,EnName,ChName", "TypeStatus =1 order by DisplayOrder asc"); 
				while($type_data = mysql_fetch_object($type_res[0])){
					
				if(in_array($type_data->TypeId,$_SESSION['ses_temp_search_obj']['types'])){
					$type_check_str = 'checked="checked"';
				}
				else{
					$type_check_str = '';
				}
                $string .='<li><input type="checkbox" name="types[]" value="'.$type_data->TypeId.'"   onclick="$(\'#filtr_products\').submit();" '.$type_check_str.'>'.$type_data->EnName.'</li>';
               
				}
				
                $string .='</ul>
                </div>';
			   echo $string;
		break;
		
		case "promotions":
		 $menu = $_REQUEST['menu'];
		  $menus = explode(",",$menu);
		  $menu_flr_qry ="";
		  if(count($menus)>0 && $_REQUEST['menu'] !=''){
			  foreach($menus as $key =>$val){
				  $menus = 1;
				 $qry_str .= " concat(',',Function,',') Like '%,".trim($val).",%' or";
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
	
	case "prod-price":
	$prod_id = $_REQUEST['prod'];
	$prod_price = $_REQUEST['price'];
	
	$size_id = $_REQUEST['size'];
	
	$dis_res = $GLOBALS['db_con_obj']->fetch_flds("promotion_banner","Id,Discount,Type","concat(',',ItemId,',') Like '%,".trim($prod_id ).",%' and Discount >0 and Status=1");


	$dis_price = format_number(product_price($prod_id,$prod_price));
	
											  
		 $price = '<div class="price-main">SGD '.$dis_price.'</div>';
          if($size_id >0 && $dis_res[1] >0){ 
        		$price .='<div class="disc price-main">SGD '.stripslashes($prod_price).'</div>';
		  }
	   echo   $price ;
	   exit;
	   
	break;
	
	case "ajax_search":
	//$GLOBALS['site_config']['debug'] =1;
	$key = $_REQUEST['string'];
	require_once(dirname(__FILE__) . '/classes/products.class.php');
	$prod_obj = new products();
	
	 $display_text .='<div class="ajax-drop" id="search_result">';
	 $prod_res = $db_con_obj->fetch_flds($prod_obj->cls_tbl,"Id, EnName,Price,Quantity,Types,Material,Function,ProdStatus,Image,UniqueKey,EnShortDesc","(lower(concat(serach_tags,' ') ) Like '% ".strtolower(trim($key ))."%'  or lower(concat(serach_tags,' ') ) Like '".strtolower(trim($key ))."%' ) order by DisplayOrder desc limit 0,10");
	 if($prod_res[1] >0){
	 while($prod_data = mysql_fetch_object($prod_res[0])){
		 
		 $dis_res = $GLOBALS['db_con_obj']->fetch_flds("promotion_banner","Id,Discount,Type","concat(' ',ItemId,',') Like '% ".trim($prod_data->Id).",%' and Discount >0 and Status=1");
		  if($dis_res[1] >0){
				  $dis_data =mysql_fetch_object($dis_res[0]);
		  }
				  
		 $med_img_path = $prod_obj->attachment_path . $prod_data->Image;
				 
				if(file_exists($med_img_path) && is_file($med_img_path))
		  			$disp_img = $med_img_path;
				else
					$disp_img = $prod_obj->attachment_path . 'default_prod.gif';
					
     $display_text .='<a href="'.$GLOBALS['site_config']['site_path']."product/".$prod_data->UniqueKey.'" class="prodsearch-item w-clearfix w-inline-block">
                        <div class="prod-img-search"><img src="'.$GLOBALS['site_config']['site_path'].$med_img_path.'" class="promimg-search"  alt="'. display_field_value($prod_data,"Name").'"></div>
                        <div class="prod-infosearch">
                          <div>'. display_field_value($prod_data,"Name").'</div>
                          <div class="regprice">$'.format_number(product_price($prod_data->Id,$prod_data->Price)).'</div>';
						 if($dis_res[1] >0){
                           $display_text .='<div class="regprice strike">$'.$prod_data->Price.'</div>';
						 }
                         $display_text .='</div>
                      </a>';
			  }
	 }
	 else {
		  $display_text .=' <div class="prod-img-search"><div>No results</div>
                        </div>';
	 }
	 $display_text .='</div>';
	 
	 echo $display_text;
	break;
	
	case "add-to-cart":
		require_once("classes/cart.class.php");
		$cart_obj = new cart();
		//print_r($_REQUEST);
		$Id = $_REQUEST['prod'];
		$quantity= $_REQUEST['qty'];
		$sizes=$_REQUEST['size'];
		$Colors=$_REQUEST['Colors'];
		
		$cart_obj->add_product_ajax($cart_obj, $Id, $quantity, $sizes, $Colors);
		
			$display_text .='<a href="'.$GLOBALS['site_config']['site_path'].'cart" class="cart-blk-in w-inline-block"><img src="'.$GLOBALS['site_config']['site_path'].'images/cart-icon-main.png" width="20" class="canticon-img">';
			
			if(isset($_SESSION['ses_cart_items']) && count($_SESSION['ses_cart_items']) >0){
                $display_text .='<div class="cartnum"><div>'.count($_SESSION['ses_cart_items']).'</div></div>';
				
				} 
				
			$display_text .='</a>';
			
			$display_text .='<div class="cartmessage" id="add-to-cart-message">
                    <p class="added-msg-par">Item added to cart</p>
                    <p class="added-msg-par">Click <a class="addedlink" href="'.$GLOBALS['site_config']['site_path'].'cart">here</a> to continue</p>
                  </div>';
	
		/*else{
		$display_text .='<div class="cartmessage">
                    <p class="added-msg-par">Item already added to cart</p>
                    <p class="added-msg-par">Click <a class="addedlink" href="'.$GLOBALS['site_config']['site_path'].'cart">here</a> to continue</p>
                  </div>';	
		} */
		 echo $display_text;
		 exit;
	break;
		
}//end switch

?>