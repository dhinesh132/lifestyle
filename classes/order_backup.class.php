<?php

class order_backup extends database_manipulation
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
	
	var $prod_quantity;
	
	var $prod_unit_price;

//database field names - End

	function order_backup()
	{
		
		$this->frm_name = 'order_backup_detail_frm';
		
		$this->cls_tbl = 'order_master_backup';
		
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
		
	}
	
	
	/**********************************************************************************************

					Method To Register/Insert a user record.

	***********************************************************************************************/
	
	function insert()
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD order_backup::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$ufld_arr = explode(",", $this->unique_flds);
		$chk_val = "";
		
		foreach($ufld_arr as $key => $val)
		{
			if(isset($_REQUEST[$val]))
				$chk_val .= $_REQUEST[$val] . ",";
			else
				$chk_val .= $this->{$val}['value'] . ",";
		}
		
		$chk_val = substr($chk_val, 0, -1);

		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))
		{
			$ret_val = false;
		}
		else
		{
			
			$resultset = database_manipulation::insert_record($this);

			$ret_val = true;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD order_backup::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD order_backup::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD order_backup::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	//***************************************************************************************************/
				//SEARCH on 160807
	//***************************************************************************************************/
	
	
	function search_query($search = "")

		{
		
				
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD order_backup::search_qurey() - PARAMETER LIST : ', $param_array);
		
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_ord_bac_srch'][$ky] = $vl;
			
			//$qry = "select order_id, date_entered, order_status, ship_email from " . $this->cls_tbl." where 1 = 1 ";
	
			$qry = "select concat(customer_master.cust_firstname,'&nbsp;',customer_master.cust_lastname) as cust_name, " . $this->cls_tbl.".order_id, " . $this->cls_tbl.".date_entered, " . $this->cls_tbl.".order_status, customer_master.cust_firstname, customer_master.cust_lastname from " . $this->cls_tbl.", customer_master where 1 = 1 and " . $this->cls_tbl.".user_id = customer_master.cust_id";
			
			
			$use_cond = " and ";
		
			$join_qry = " and (";
			
			$join_qry_st = 0;
			
			//search with order status - Start
			if(!empty($_SESSION['ses_ord_bac_srch']['order_status']))
			{
				$join_qry .= stripslashes($_SESSION['ses_ord_bac_srch']['order_status']);
				$join_qry_st = 1;
			}
			//search with order status - End
		
		
			//search with order date - Start
			if(!empty($_SESSION['ses_ord_bac_srch']['reportdate']) && !empty($_SESSION['ses_ord_bac_srch']['reportdate1']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
		
				$join_qry .= "(" . $this->cls_tbl.".date_entered >= '" . $_SESSION['ses_ord_bac_srch']['reportdate'] . " 00:00:00' and " . $this->cls_tbl.".date_entered <= '" . $_SESSION['ses_ord_bac_srch']['reportdate1'] . " 23:59:59')";
		
				$join_qry_st = 1;
			}
			//search with order date - End
		
			
			//search with order number - Start
			if(!empty($_SESSION['ses_ord_bac_srch']['start_order_num']) && !empty($_SESSION['ses_ord_bac_srch']['end_order_num']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
		
				$join_qry .= "(" . $this->cls_tbl.".order_id >= '" . $_SESSION['ses_ord_bac_srch']['start_order_num'] . "' and " . $this->cls_tbl.".order_id <= '" . $_SESSION['ses_ord_bac_srch']['end_order_num'] . "')";
		
				$join_qry_st = 1;
			}
			//search with order number - End
		
		
			//search with customer name - Start
			if(!empty($_SESSION['ses_ord_bac_srch']['filter_column']) && !empty($_SESSION['ses_ord_bac_srch']['filter_srch_typ']) && !empty($_SESSION['ses_ord_bac_srch']['filter_srch_val']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
		
				$join_qry .= "(lower(" . $_SESSION['ses_ord_bac_srch']['filter_column'] . ") " . stripslashes(str_replace("#val#",strtolower($_SESSION['ses_ord_bac_srch']['filter_srch_val']), $_SESSION['ses_ord_bac_srch']['filter_srch_typ'])) . ")";
		
				$join_qry_st = 1;
			}
			//search with customer name - End
			
			if($join_qry_st != 1)
			$join_qry .= "1=1";
			
			$join_qry .= ")";
		
			//add sorting to the query - Start
			if(!empty($_SESSION['ses_ord_bac_srch']['sort_column']))
			{
				$join_qry .= " order by " . $_SESSION['ses_ord_bac_srch']['sort_column'] ;
			}
			//add sorting to the query - End
		
		
			$final_qry = $qry . $join_qry;
			
			$_SESSION['ses_ord_bac_qry'] = $final_qry;
			return $final_qry;
			
		$GLOBALS['logger_obj']->debug('<br>METHOD order_backup::search_qurey() - Return Value : ', $ret_val);
		return $ret_val;	
		
	}

}

?>
