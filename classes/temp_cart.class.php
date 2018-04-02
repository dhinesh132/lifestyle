<?php
if(file_exists("classes/products.class.php"))
{
	require_once("classes/products.class.php");
	require_once("classes/cart.class.php");
}
else if(file_exists("./classes/products.class.php"))
{
	require_once("./classes/products.class.php");
	require_once("./classes/cart.class.php");
}
else if(file_exists("../classes/products.class.php"))
{
	require_once("../classes/products.class.php");
	require_once("../classes/cart.class.php");
}

class temp_cart extends database_manipulation
{


	var $frm_name;

	var $cls_tbl;

	var $cls_sql;

	var $unique_flds;

	var $file_flds;

	var $attachment_path;

	var $attachment_h;

	var $attachment_w;

	var $attachment_s;

	var $attachment_conditions;

	var $image_copies;

	var $primary_fld;

	var $register_email_id;

	var $fp_email_id;

	var $reference_tables;
	
//database field names - Start

	var $Id;
	
	var $UserId;
	
	var $SessionId;
	
	var $ProductId;
	
	//var $ProductId;
	
	var $ProdQty;
	
	var $DateStored;

//database field names - End

	function temp_cart()
	{
		
		$this->frm_name = 'temp_cart_detail_frm';
		
		$this->cls_tbl = 'temp_cart';
		
		$this->ref_tbl = "";
		
		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";
		
		$this->unique_flds = 'Id';
		
		$this->file_flds = '';
		
		$this->reference_tables = '';
		
		$this->primary_fld = 'Id';
		
		$this->register_email_id = 0;

		$this->fp_email_id = 0;
		
		$this->attachment_h = 0;
		
		$this->attachment_w = 0;
		
		$this->attachment_s = 0;
		
		$this->attachment_conditions = "";
		
		$this->image_copies = array();
		
		$this->upload_msgs = array();
		
		
		if(file_exists("../uploads/"))

			$this->attachment_path = '../uploads/product_files/';
			
		else
		
			$this->attachment_path = 'uploads/product_files/';
		
		$this->Id = array('frm_fldname' => 'Id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');

		$this->UserId = array('frm_fldname' => 'UserId', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->SessionId = array('frm_fldname' => 'SessionId', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product description!'), 'value' => '');
		
		$this->ProductId = array('frm_fldname' => 'ProductId', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount!'), 'value' => '');
		
		$this->ProdQty = array('frm_fldname' => 'ProdQty', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
		
		$this->DateStored = array('frm_fldname' => 'DateStored', 'fld_type' => 'text', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
		
				
			
	}
	
	
	/**********************************************************************************************

					Method To Register/Insert a user record.

	***********************************************************************************************/
	
	function insert()
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD temp_cart::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$chk_val = "";
		
		if(strlen(trim($this->unique_flds)) > 0)
		{
			$ufld_arr = explode(",", $this->unique_flds);
			foreach($ufld_arr as $key => $val)
			{
				if(isset($_REQUEST[$val]))
					$chk_val .= $_REQUEST[$val] . ",";
				else
					$chk_val .= $this->{$val}['value'] . ",";
			}
			
			$chk_val = substr($chk_val, 0, -1);
		}

		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))
		{
			$ret_val = false;
		}
		else
		{
			
			$resultset = database_manipulation::insert_record($this);

			$ret_val = true;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD temp_cart::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD temp_cart::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD temp_cart::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	function delete_cart($user_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD temp_cart::delete() - PARAMETER LIST : ', $param_array);
		
		if($user_id > 0)
		{
			$delete_qry = "DELETE FROM ".$this->cls_tbl." WHERE UserId=".$user_id;
			$GLOBALS['db_con_obj']->execute_sql($delete_qry,"delete");
			//$primary_fld = $this->primary_fld;
			//database_manipulation::delete_record($this, $rec_id);
			//frame_notices("Order details details successfully deleted !!", "greenfont");
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD temp_cart::delete() - Return Value : ', $ret_val);

		return $ret_val; 
	
	} 
	
	function cart_items_from_db($user_id){
		
		
		//$crtobj = new cart();
		$prod_obj = new products();
		$cur_key = 0;
		if(empty($_SESSION['ses_cart_items']) && count($_SESSION['ses_cart_items']) >=0)
			$_SESSION['ses_cart_items'] =array();
		//$GLOBALS['site_config']['debug']=1;
		$qry = "SELECT prod.*,temp.ProductId,temp.ProdQty FROM ".$this->cls_tbl." as temp ,".$prod_obj->cls_tbl. " as prod WHERE temp.UserId=".$user_id." and temp.ProductId = prod.Id and prod.ProdStatus=1"; 
		$res = $GLOBALS['db_con_obj']->execute_sql($qry,"select");
		while($data = mysql_fetch_object($res[0])){
		
			$availableQty = ProductQuantity($data->Id);
			
			if($availableQty >0){
				$temp_EnName = display_field_value($data,"Name");
				
				$array_obj ='';
				
				$Price = $data->Price;
				
				$Weight = $data->Weight;
				
				$array_obj['Id'] = $data->Id;
				
				$array_obj['prod_prnt_id'] = '';
				
				$array_obj['EnName'] = $data->EnName;
				
				$quantity = $data->ProdQty;	
				//checking available quantity now
				if($availableQty <	$quantity)
					$quantity = $availableQty;
			    
				    
				$array_obj['prod_quantity'] = $quantity;
				
				$array_obj['prod_unit_price'] = $Price;
				
				$array_obj['prod_thumb_path'] = $prod_obj->attachment_path . $data->Image;
				
				$array_obj['Weight'] = $data->Weight;
				
				$array_obj['last_added_prod'] = '';
				
				$array_obj['dis_coupon_code'] = '';
				$array_obj['dis_purpose'] = '';
				$array_obj['dis_value'] = '';
				$array_obj['gc_coupon_code'] = '';
				
				$array_obj['gc_used_amount'] = '';
				$array_obj['shipping_method'] = '';
				$array_obj['shipping_cost'] = '';
				$array_obj['payment_method'] = '';
				$array_obj['payment_value'] = '';
				$array_obj['prod_id'] = $data->Id;
				$array_obj['prod_name'] = $data->EnName;
				$array_obj['prod_code'] = $data->ProdCode;
				$array_obj['prod_type'] = $data->ProdType;
				
				$cur_key = 0;
				$exists = false;
				foreach($_SESSION['ses_cart_items'] as $key => $value)
				{
					//$obj_vars = get_object_vars($value);
					
					if($value['Id'] == $array_obj['Id'])
					{
						$exists = true;
						$cur_key = $key;
						$array_obj['prod_quantity'] = $quantity;
						break;
					}
					
				}
				if($exists)
				
					$_SESSION['ses_cart_items'][$cur_key] = $array_obj;
				
				else
				{
					$array_obj['prod_quantity'] = $quantity;
					$_SESSION['ses_cart_items'][] = $array_obj;
				}
			
			   // $_SESSION['ses_cart_items'][]= $array_obj;
				
				
				$crtobj->last_added_prod = end($_SESSION['ses_cart_items']);
				
				$_SESSION['ses_last_added_prod'] = $array_obj['last_added_prod'];
		
				}
		}
		
	}
	
	
	// CRON JOBS for Delete record from temp cart table	
	function delete_temp_cart(){		
		$delete_qry = "DELETE FROM ".$this->cls_tbl." WHERE dateStored <= NOW() - INTERVAL 1 DAY";
		$GLOBALS['db_con_obj']->execute_sql($delete_qry,"delete");
	}
	
	

}

?>
