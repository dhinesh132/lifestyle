<?php
//for product
if(file_exists("classes/products.class.php"))
{
	require_once("classes/products.class.php");
}
else if(file_exists("./classes/products.class.php"))
{
	require_once("./classes/products.class.php");
}
else if(file_exists("../classes/products.class.php"))
{
	require_once("../classes/products.class.php");
}

class cart
{

	var $Id;
	
	var $prod_prnt_id;
	
	var $EnName;
	
	var $prod_quantity;
	
	var $prod_unit_price;
	
	var $prod_thumb_path;
	
	var $Weight;
	
	var $last_added_prod;
	
	var $dis_coupon_code;
	
	var $dis_purpose;
	
	var $dis_value;
	
	var $gc_coupon_code;
	
	var $gc_used_amount;
	
	var $shipping_method;
	
	var $shipping_cost;
	
	var $payment_method;
	
	var $payment_value;
	
	function cart()
	{
		
		if(!is_array($_SESSION['ses_cart_items']))
		$_SESSION['ses_cart_items'] = array();
		
		if(strlen(trim($_SESSION['ses_dis_coupon_code'])) <= 0)
		$_SESSION['ses_dis_coupon_code'] = '';
		
		if(strlen(trim($_SESSION['ses_dis_value'])) <= 0)
		$_SESSION['ses_dis_value'] = '';

		if(strlen(trim($_SESSION['ses_gc_coupon_code'])) <= 0)
		$_SESSION['ses_gc_coupon_code'] = '';
		
		if(strlen(trim($_SESSION['ses_gc_used_amount'])) <= 0)
		$_SESSION['ses_gc_used_amount'] = '';

		if(strlen(trim($_SESSION['ses_last_added_prod'])) <= 0)
		$_SESSION['ses_last_added_prod'] = '';

		$this->dis_coupon_code = $_SESSION['ses_dis_coupon_code'];
		
		$this->dis_value = $_SESSION['ses_dis_coupon_code'];
		
		$this->gc_coupon_code = $_SESSION['ses_gc_coupon_code'];
		
		$this->gc_used_amount = $_SESSION['ses_gc_used_amount'];
		
	}
	
	/***************************************************************************************************************************
												Method To Add Products To Cart.
	***************************************************************************************************************************/
	
	function add_product($crtobj)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::add_product() - PARAMETER LIST : ', $param_array);
		
		//$crtobj = $this;
		
	
		$crtobj->Id = $_REQUEST['Id'];
		
		$prod_obj = new products();
		
		$res = $prod_obj->fetch_record($crtobj->Id);
		
		if($data = mysql_fetch_object($res[0]))
		{
		
			$temp_EnName = display_field_value($data,"Name");
			

			$Price = $data->Price;
			
			$Weight = $data->Weight;
			
			$crtobj->prod_id = $data->Id ;		
			
			$crtobj->prod_name = $data->EnName;
			
			if($_REQUEST['sizes'] > 0) {
			$size_res = $GLOBALS['db_con_obj']->fetch_flds('product_sizes','Price,Id,EnTitle','Id ='.$_REQUEST['sizes']); 
				$size_data = mysql_fetch_object($size_res[0]);				  
				  $Price = $size_data->Price;
				  
				  $crtobj->prod_unit_price = format_number(product_price($data->Id,$Price)) ;
			}
			else{ 
				$crtobj->prod_unit_price = format_number(product_price($data->Id,$Price)) ;
			}
			//$crtobj->prod_unit_price = $_SESSION['ses_product']['price'];
			
			unset($_SESSION['ses_product']['price']);
			
			$quantity = $_REQUEST['quantity'];	
			
			$crtobj->size = $_REQUEST['sizes'];	
			
			$crtobj->colour = $_REQUEST['Colors'];	
			
			//$crtobj->size = $size;
			
			$crtobj->prod_quantity = $quantity;
			
			$crtobj->prod_code = $data->ProdCode;
				
			$crtobj->Weight = $Weight;
			
			$crtobj->category_id = $category_id;
			
			$crtobj->prod_type = $data->ProdType;
			
			
			
				
			$crtobj->prod_thumb_path = $prod_obj->attachment_path . $data->Image;
			
			if(!(file_exists($crtobj->prod_thumb_path) && is_file($crtobj->prod_thumb_path)))
			$crtobj->prod_thumb_path = $prod_obj->attachment_path . "default_th_prod.jpg";
	
			$cur_key = 0;
			$exists = false;
			
			foreach($_SESSION['ses_cart_items'] as $key => $value)
			{
				//$obj_vars = get_object_vars($value);
				
				if($value['Id'] == $crtobj->Id && $value['size'] == $crtobj->size )
				{
					$exists = true;
					$cur_key = $key;
					$crtobj->prod_quantity = 1;
					break;
				}
				
			}
			
			
			$crtobj = get_object_vars($crtobj);
			if($exists )
				
				$_SESSION['ses_cart_items'][$cur_key] = $crtobj;
			
			else
			{
				$crtobj->prod_quantity = $quantity;
				$_SESSION['ses_cart_items'][] = $crtobj;
			}
			
			if(isset($_SESSION['ses_coupon_code'])){
			
			$this->apply_promocode($_SESSION['ses_coupon_code']);
			}
			
			$crtobj->last_added_prod = end($_SESSION['ses_cart_items']);
			
			$_SESSION['ses_last_added_prod'] = $crtobj->last_added_prod;
	
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::add_product() - Return Value : ', 'Added a product to the cart and returning void');

		return $ret_val;
	
	}
	
	function update_cart()
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::update_cart() - PARAMETER LIST : ', $param_array);
		
		$temp_msg = "";
		$qty_validate = 0;
		$ctr = 0;
		foreach($_SESSION['ses_cart_items'] as $key => $value)
		{	
			$ctr++;
			$fld_nam = "quantity" . $key;
			//030407
          	$qty_value= $_REQUEST[$fld_nam];
			if (($qty_value==0) || ($qty_value==""))
			{
				$qty_validate = 1;
				$temp_msg = $temp_msg . "Quantity values should be numeric in item # " . ($ctr) . "<br>";
			}
			else
			$_SESSION['ses_cart_items'][$key]['prod_quantity'] = $_REQUEST[$fld_nam];
		}
		
		if(isset($_SESSION['ses_coupon_code'])){
			
			$this->apply_promocode($_SESSION['ses_coupon_code']);
		}
		if($qty_validate == 1)
		frame_notices($temp_msg ,"redfont",1);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::update_cart() - Return Value : ', 'prod_quantity for the items in teh cart were updated and returning void');

	}
	
	function delete_product($cart_key)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::delete_product() - PARAMETER LIST : ', $param_array);
		
		unset($_SESSION['ses_cart_items'][$cart_key]);

		$GLOBALS['logger_obj']->debug('<br>METHOD cart::delete_product() - Return Value : ', 'Deleted a item from the cart and returning void');
	}
	
	function apply_discount($dis)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::apply_discount() - PARAMETER LIST : ', $param_array);
		
		require_once("classes/discount_coupon.class.php");
	
		
		$dis_obj = new discount_coupon();
		
		$cond="dis_serialno='$dis' and dis_status='1' and dis_expdate >= now()";
		
		$res_query=$dis_obj->fetch_flds($dis_obj->cls_tbl, "*", $cond);
		
		if($dis_data = mysql_fetch_object($res_query[0]))
		{
		
		$dis_data->dis_percent;
		$_SESSION['ses_dis_auto_id'] = $dis_data->dis_id;
		
		
		if($dis_data->dis_percent != 0)
			{
				$_SESSION['ses_dis_percent'] = $dis_data->dis_percent;
				$_SESSION['ses_dis_res']=$dis_data->dis_percent;
			}
		
		else if($dis_data->dis_percent=="freeshipping")
			{
				$_SESSION['ses_dis_free']=$dis_data->dis_percent;
				$_SESSION['ses_dis_res']=$dis_data->dis_percent;
			}
	}
		else
		{
			
				frame_notices("Discount coupons is not valid !!", "redfont");
				header("location:payment.php");
				exit();
			
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::apply_discount() - Return Value : ', 'Returning Void');
		
	}
	
	function calculate_weight($purpose="fortotalweight")
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::calculate_weight() - PARAMETER LIST : ', $param_array);
		
		require_once("classes/products.class.php");

		$prod_obj = new products();
		
		$tot_wt = 0;
		$freeship_wt = 0;
		foreach($_SESSION['ses_cart_items'] as $key => $value)
		{
			
		  	$chk_res = $GLOBALS['db_con_obj']->fetch_flds($prod_obj->cls_tbl, "Price,prod_ws_price,product_attributes,Weight,dis_st_dt,dis_end_dt,prod_discount_val,prod_discount_typ", "Id = '" . $value['Id'] . "'");
			
			$chk_data = mysql_fetch_object($chk_res[0]);
			
			if($chk_data->prod_discount_val == -1 && ($chk_data->dis_st_dt <= date("Y-m-d") && date("Y-m-d") <= $chk_data->dis_end_dt))
			$freeship_wt += $chk_data->Weight * $value['prod_quantity'];
			
			$tot_wt += trim($chk_data->Weight) * $value['prod_quantity'];
		}
		
		//weight should be returned in lbs, so divide this by 16 to get it
		$tot_wt = format_number(round($tot_wt/16, 2));//converting ounce into lbs
		
		if($purpose != "fortotalweight")
		{
			$tot_wt -= format_number(round($freeship_wt/16, 2));
			$tot_wt = format_number($tot_wt);
		}
		
		if($tot_wt < 1 && $tot_wt > 0)
		$tot_wt = "1.00";
		
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::calculate_weight() - Return Value : ', $tot_wt);

		return $tot_wt;
		
	}
	
	
	//******************** changed 03022007
	
	//****************************************
	
	function salestax($Id,$temp_amount)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::salestax($Id,$temp_amount) - PARAMETER LIST : ', $param_array);
		/*
		$tax_pro = $_SESSION['ses_tax_pro_id'];
		$con_code = $_SESSION['ses_ship_bill_arr']['country'];
		
		
		require_once("classes/discount_coupon.class.php");
		$dis_obj = new discount_coupon();
		
		
		$state_code=$_SESSION['ses_ship_bill_arr']['state'];
				
		$tax_con_state="productrefcategory.category_id = tax_state.category_id and tax_state.state_code = state.stateid and state.state_code='$state_code' and state.countryid='$con_code'and productrefcategory.product_id='$Id'";
		
		$query_state=$dis_obj->fetch_flds("tax_state,state,productrefcategory","*", $tax_con_state );
		if($data_tax_state = mysql_fetch_object($query_state[0]))
		{
		
		$tax_con2 = $data_tax_state->taxrate;
		$tax_con=($temp_amount/100)*$tax_con2;
		}
		else
		{
		
		$tax_con_data="productrefcategory.category_id = taxes.category_id and taxes.countrycode='$con_code' and productrefcategory.product_id='$Id'";
		$query=$dis_obj->fetch_flds("productrefcategory,taxes ","*", $tax_con_data );
		
		$data_tax = mysql_fetch_object($query[0]);
		$tax_con1 = $data_tax->taxrate;
		$tax_con=($temp_amount/100)*$tax_con1;
		}
		*/
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::salestax($Id,$temp_amount) - Return Value : ', $tax_con);

		return $tax_con;
	
	}
		
	//******************** changed 03022007
	
	//****************************************
	
		
		
	function discount_amount($percent,$payable_amt)
	{
		$param_array = func_get_args();
		
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::discount_amount() - PARAMETER LIST : ', $param_array);
		
		$dis_amount=($payable_amt/100)*$percent;
		
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::discount_amount() - Return Value : ', $dis_amount);

		return $dis_amount;
	
	}
	
	//************************
	
	//************************
	function empty_cart()
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::empty_cart() - PARAMETER LIST : ', $param_array);
		
		unset($_SESSION['ses_cart_items']);
		unset($_SESSION['ses_ship_bill_arr']);
		unset($_SESSION['ses_cart_shipping_method']);
		unset($_SESSION['ses_payment_vars']);
		unset($_SESSION['ses_dis_amt']);
		unset($_SESSION['ses_dis_res']);
		unset($_SESSION['ses_dis_free']);
		unset($_SESSION['ses_dis_percent']);
		unset($_SESSION['ses_dis_auto_id']);
		unset($_SESSION['ses_tax_con']);
		unset($_SESSION['ses_card']);
		unset($_SESSION['ses_payable_amount']);
		unset($_SESSION['ses_repay_oid']);
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::empty_cart() - Return Value : ', 'Cart emptied and returning void');
	}
	
	function apply_giftcertificate()
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::apply_giftcertificate() - PARAMETER LIST : ', $param_array);
	
	
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::calculate_weight() - Return Value : ', '');
	}
	
	function apply_promocode($code){
		
		$GLOBALS['site_config']['debug']=1;
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::apply_promocode() - PARAMETER LIST : ', $param_array);
		
		$cond="Code='".$code."' and Status='1' and StartDate <= '".date("Y-m-d")."' and ExpiryDate >= '".date("Y-m-d")."'";
		
		$res_query= $GLOBALS['db_con_obj']->fetch_flds("promotions", "*", $cond);
		
		if($res_query[1] >0){
			
			$promo_data = mysql_fetch_object($res_query[0]);
			$valid =0;
			$dis_amount=0;
			$tot_amount = 0;
			$notvalid = 1;
			
			if($promo_data->CustomerLogin ==1 && empty($_SESSION['ses_customer_id'])){
			  $notvalid  =0;
			  frame_notices("Customer login is required !!", "redfont");
			}
			if($promo_data->MinAmountVal ==1 && $notvalid == 1){
				if($_SESSION['ses_payment_vars']['payable_amt'] < $promo_data->MinAmountVal ){
					 $notvalid  =0;
			 		 frame_notices("Cart amount must reach $".$promo_data->MinAmountVal." !!", "redfont");
				}
			}
			if($promo_data->ReUse !=''  && $notvalid == 1){
				$order_res = $GLOBALS['db_con_obj']->fetch_flds("order_master","order_id","order_status !=0 and coupon_code='".$code."'");
				if($order_res[1] >=$promo_data->ReUse){
					 $notvalid  =0;
					 frame_notices("Coupon code has been used !!", "redfont");		  
				}
			}
			if($promo_data->NoOfUseByCustomer !=''  && $notvalid == 1){
				$order_res = $GLOBALS['db_con_obj']->fetch_flds("order_master","order_id","order_status !=0 and coupon_code='".$code."' and user_id =".$_SESSION['ses_customer_id']);
				if($order_res[1] >=$promo_data->NoOfUseByCustomer){
					 $notvalid  =0;
					 frame_notices("Coupon code has been used by you!!", "redfont");		  
				}
			}
			
			
			if( $notvalid ==1){
				$dis_direct_amount=0;
				foreach($_SESSION['ses_cart_items'] as $k => $v){ 
					
					$valid_prod = explode(",",$promo_data->ItemId);
					if(in_array($v['prod_id'],$valid_prod)){
						
						$temp_amount = format_number(round($v['prod_unit_price'] * $v['prod_quantity'], 2) / 1.07); 
						
						if($promo_data->Type =="$"){
							if($dis_direct_amount ==0)
								$dis_amount = $promo_data->Value;
							else
								$dis_amount = 0;
							$dis_direct_amount=1;
							//$dis_amount = $promo_data->Value * $v['prod_quantity'];
						}else if($promo_data->Type =="%") 
							$dis_amount = ($temp_amount/100) * $promo_data->Value;							    
						else if($promo_data->Type =="Free"){ 
							$dis_amount = "0.00";
							$_SESSION['ses_coupon_type'] = "free_shipping";
						}
						//exit;
							$tot_amount += $dis_amount;
							$tot_amount;
					 $valid = 1;
					}
				
				}
				if( $valid==1){
					$_SESSION['ses_coupon_code'] = $code;
					$_SESSION['ses_discount_amount']=$tot_amount;
				}else{
					unset($_SESSION['ses_coupon_type']);
					unset($_SESSION['ses_coupon_code']);
					unset($_SESSION['ses_discount_amount']);
				}
			}
			
		}else{
			
			frame_notices("Coupon code is not valid !!", "redfont");
			
		}
		//echo $dis_amount;
		//exit;
		return  $dis_amount;
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::apply_promocode() - Return Value : ', 'Returning Void');
	}
	
	function add_product_ajax($crtobj, $Id, $quantity, $sizes=0, $Colors=0)
	{
		
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::add_product() - PARAMETER LIST : ', $param_array);
		
		//$crtobj = $this;
		
	
		$crtobj->Id = $Id;
		
		$prod_obj = new products();
		
		$res = $prod_obj->fetch_record($crtobj->Id);
		
		if($data = mysql_fetch_object($res[0]))
		{
		
			$temp_EnName = display_field_value($data,"Name");
			

			$Price = $data->Price;
			
			$Weight = $data->Weight;
			
			$crtobj->prod_id = $data->Id ;		
			
			$crtobj->prod_name = $data->EnName;
			
			if($sizes > 0) {
			$size_res = $GLOBALS['db_con_obj']->fetch_flds('product_sizes','Price,Id,EnTitle','Id ='.$sizes); 
				$size_data = mysql_fetch_object($size_res[0]);				  
				  $Price = $size_data->Price;
				  
				  $crtobj->prod_unit_price = format_number(product_price($data->Id,$Price)) ;
			}
			else{ 
				$crtobj->prod_unit_price = format_number(product_price($data->Id,$Price)) ;
			}
			
			//$crtobj->prod_unit_price = $_SESSION['ses_product']['price'];
			
			unset($_SESSION['ses_product']['price']);
			
			$quantity = $quantity;	
			
			$crtobj->size = $sizes;	
			
			$crtobj->colour = $Colors;	
			
			//$crtobj->size = $size;
			
			$crtobj->prod_quantity = $quantity;
			
			$crtobj->prod_code = $data->ProdCode;
				
			$crtobj->Weight = $Weight;
			
			$crtobj->category_id = $category_id;
			
			$crtobj->prod_type = $data->ProdType;
			
			
			
				
			$crtobj->prod_thumb_path = $prod_obj->attachment_path . $data->Image;
			
			if(!(file_exists($crtobj->prod_thumb_path) && is_file($crtobj->prod_thumb_path)))
			$crtobj->prod_thumb_path = $prod_obj->attachment_path . "default_th_prod.jpg";
	
			$cur_key = 0;
			$exists = false;
			
			foreach($_SESSION['ses_cart_items'] as $key => $value)
			{
				//$obj_vars = get_object_vars($value);
				
				if($value['Id'] == $crtobj->Id && $value['size'] == $crtobj->size )
				{
					$exists = true;
					$cur_key = $key;
					$crtobj->prod_quantity = 1;
					break;
				}
				
			}
			
			
			$crtobj = get_object_vars($crtobj);
			if($exists ){
				$ret_val = false;
				$_SESSION['ses_cart_items'][$cur_key] = $crtobj;
			}
			else
			{
				$ret_val = true;
				$crtobj->prod_quantity = $quantity;
				$_SESSION['ses_cart_items'][] = $crtobj;
			}
			
			if(isset($_SESSION['ses_coupon_code'])){
			
			$this->apply_promocode($_SESSION['ses_coupon_code']);
			}
			
			$crtobj->last_added_prod = end($_SESSION['ses_cart_items']);
			
			$_SESSION['ses_last_added_prod'] = $crtobj->last_added_prod;
	
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD cart::add_product() - Return Value : ', 'Added a product to the cart and returning void');

		return $ret_val;
	
	}
	
	
}

?>