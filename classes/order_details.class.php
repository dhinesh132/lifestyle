<?php

class order_details extends database_manipulation
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

	var $detail_id;
	
	var $order_id;
	
	var $prod_id;
	
	var $prod_name;
	
	//var $prod_name;
	
	var $prod_quantity;
	
	var $prod_unit_price;
	
	var $Weight;
	
	var $prod_code;

//database field names - End

	function order_details()
	{
		
		$this->frm_name = 'order_details_detail_frm';
		
		$this->cls_tbl = 'order_details';
		
		$this->ref_tbl = "";
		
		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";
		
		$this->unique_flds = '';
		
		$this->file_flds = '';
		
		$this->reference_tables = '';
		
		$this->primary_fld = 'detail_id';
		
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
		
		$this->detail_id = array('frm_fldname' => 'detail_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');

		$this->order_id = array('frm_fldname' => 'order_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->prod_id = array('frm_fldname' => 'prod_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product description!'), 'value' => '');
		
		$this->prod_name = array('frm_fldname' => 'prod_name', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount!'), 'value' => '');
		
		$this->prod_quantity = array('frm_fldname' => 'prod_quantity', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
		
		$this->prod_unit_price = array('frm_fldname' => 'prod_unit_price', 'fld_type' => 'text', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
		
			$this->Weight = array('frm_fldname' => 'Weight', 'fld_type' => 'text', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
			
			$this->prod_code = array('frm_fldname' => 'prod_code', 'fld_type' => 'text', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
			
			$this->size = array('frm_fldname' => 'size', 'fld_type' => 'text', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
			
			$this->colour = array('frm_fldname' => 'colour', 'fld_type' => 'text', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
			
	}
	
	
	/**********************************************************************************************

					Method To Register/Insert a user record.

	***********************************************************************************************/
	
	function insert()
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD order_details::insert() - PARAMETER LIST : ', $param_array);

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
		
		$GLOBALS['logger_obj']->debug('<br>METHOD order_details::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD order_details::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD order_details::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	

}

?>
