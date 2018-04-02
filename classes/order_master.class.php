<?php
//for discount history
if(from_page == "payaction")
{
	require_once("../../../classes/order_details.class.php");	
	require_once("../../../classes/order_master.class.php");
	require_once("../../../classes/customers.class.php");
}
else if(file_exists("classes/order_details.class.php"))
{
	require_once("classes/order_details.class.php");
	require_once("classes/order_master.class.php");
	require_once("classes/customers.class.php");
}
else if(file_exists("./classes/order_details.class.php"))
{
	require_once("./classes/order_details.class.php");
	require_once("./classes/order_master.class.php");
	require_once("./classes/customers.class.php");
}
else if(file_exists("../classes/order_details.class.php"))
{
	require_once("../classes/order_details.class.php");	
	require_once("../classes/order_master.class.php");
	require_once("../classes/customers.class.php");
}

class order_master extends database_manipulation
{


	var $frm_name; //name of the form from where the details are collected.

	var $cls_tbl; //name of the table which this class uses.

	var $cls_sql; //default sql statement for the class.

	var $unique_flds; //unique fields for the table delimited with commas(,).

	var $file_flds; //file fields for the table delimited with commas(,).

	var $attachment_path; //where the files for this table should be uploaded.

	var $attachment_h; //the file to be uploaded should be with this height, if not reqd set to 0, if set to 0 config default values will be taken.

	var $attachment_w; //the file to be uploaded should be with this width, if not reqd set to 0, if set to 0 config default values will be taken.

	var $attachment_s; //the file to be uploaded should be with this size, if not reqd set to 0, if set to 0 config default values will be taken.

	var $attachment_conditions; //what are all the conditions to be handled in the file upload, s for size, h for height, w for width

	var $image_copies; //number of copies to be generated from the image field.

	var $primary_fld; //primary fields name of the table.

	var $register_email_id; //primary id from the emails table which contains the registration email.

	var $fp_email_id; //primary id from the emails table which contains the forgot password email.

	var $reference_tables; //tables that have the records related to the table of this class...
	
	var $order_email_ids;
	
//database field names - Start

	var $order_id;
	
	var $user_id;
	
	var $shipping_cost;
	
	var $ship_method;
	
	var $tax_collected;
	
	var $payable_amount;
	
	var $discount_amount;
	
	var $giftcertificate_amt;
	
	var $giftcert_id;
	
	var $discount_id;
	
	var $handling_msg;
	
	var $callback_number;
	
	var $pay_method;
	
	var $order_status;
	
	var $approved_dt;
	
	var $shipment_appdt;
	
	var $cancel_dt;
	
	var $ship_fname;
	
	var $ship_lname;
	
	var $ship_ads1;

	var $ship_ads2;

	var $ship_city;

	var $ship_state;

	var $ship_country;

	var $ship_zip;

	var $bill_fname;
	
	var $bill_lname;
	
	var $bill_ads1;

	var $bill_ads2;

	var $bill_city;

	var $bill_state;

	var $bill_country;

	var $bill_zip;

	var $error_reason;

	var $trans_id;
	
	var $approval_email_ids;
	
	var $notificatio_email_id;
	

//database field names - End

	function order_master()
	{
		
		$this->frm_name = 'order_master_detail_frm';
		
		$this->cls_tbl = 'order_master';
		
		$this->ref_tbl = "productrefcategory";
		
		if($_SESSION['ses_selected_prnt_prod'] > 0)
			
			$additional_qry = "and prod_parent_id = '" . $_SESSION['ses_selected_prnt_prod'] . "'";
		
		else
		
			$additional_qry = "and prod_parent_id <= '0'";

		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 " . $additional_qry;
		
		$this->unique_flds = '';
		
		$this->file_flds = '';
		
		$this->reference_tables = 'order_master|order_id|0';
		
		$this->primary_fld = 'order_id';
		
		$this->register_email_id = 0;

		$this->fp_email_id = 0;
		
		$this->attachment_h = 0;
		
		$this->attachment_w = 0;
		
		$this->attachment_s = 0;
		
		$this->attachment_conditions = "shw";
		
		$this->image_copies = array();
		
		$this->upload_msgs = array();
		
		$this->order_email_ids = array("1" => 5, "2" => 5, "3" => 5, "4" => 5, "5" => 5, 'save_todb' => 'false');
		
		$this->approval_email_ids = array("pay_app" => 6, "ship_app" => 7, 'save_todb' => 'false');
		
		$this->notificatio_email_id = 8;
		
		
		if(file_exists("../uploads/"))

			$this->attachment_path = '../uploads/product_files/';
			
		else
		
			$this->attachment_path = 'uploads/product_files/';
		
		//$this->database_fld_name = array( - membervariables should be the database field names...
		
		$this->order_id = array('frm_fldname' => 'order_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');

		$this->user_id = array('frm_fldname' => 'user_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->shipping_cost = array('frm_fldname' => 'shipping_cost', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product description!'), 'value' => '');
		
		$this->ship_method = array('frm_fldname' => 'ship_method', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product description!'), 'value' => '');
		
		$this->ship_tracking_number = array('frm_fldname' => 'ship_tracking_number', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product description!'), 'value' => '');
		
		$this->tax_collected = array('frm_fldname' => 'tax_collected', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount!'), 'value' => '');
		
		$this->payable_amount = array('frm_fldname' => 'payable_amount', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
		
		$this->discount_amount = array('frm_fldname' => 'discount_amount', 'fld_type' => 'text', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
		
		$this->giftcertificate_amt = array('frm_fldname' => 'giftcertificate_amt', 'fld_type' => 'text', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
		
		$this->giftcert_id = array('frm_fldname' => 'giftcert_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		$this->discount_id = array('frm_fldname' => 'discount_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'numeric', 'minlen' => '1', 'maxlen' => '20', 'msg' => 'Enter product retail price!'), 'value' => '');
		
		$this->handling_msg = array('frm_fldname' => 'handling_msg', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '2', 'maxlen' => '255', 'msg' => 'Enter product wholesale price!'), 'value' => '');
		
		$this->callback_number = array('frm_fldname' => 'callback_number', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter postalcode!'), 'value' => '0');
		
		$this->pay_method = array('frm_fldname' => 'pay_method', 'fld_type' => 'str', 'frm_fld_type' => 'select', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->order_status = array('frm_fldname' => 'order_status', 'fld_type' => 'str', 'frm_fld_type' => 'select', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->approved_dt = array('frm_fldname' => 'approved_dt', 'fld_type' => 'str', 'frm_fld_type' => 'select', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->shipment_appdt = array('frm_fldname' => 'shipment_appdt', 'fld_type' => 'str', 'frm_fld_type' => 'select', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->cancel_dt = array('frm_fldname' => 'cancel_dt', 'fld_type' => 'str', 'frm_fld_type' => 'select', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->ship_fname = array('frm_fldname' => 'ship_fname', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->ship_lname = array('frm_fldname' => 'ship_lname', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->ship_ads1 = array('frm_fldname' => 'ship_ads1', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->ship_ads2 = array('frm_fldname' => 'ship_ads2', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->ship_city = array('frm_fldname' => 'ship_city', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->ship_state = array('frm_fldname' => 'ship_state', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->ship_zip = array('frm_fldname' => 'ship_zip', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->ship_country = array('frm_fldname' => 'ship_country', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->ship_email = array('frm_fldname' => 'ship_email', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->bill_fname = array('frm_fldname' => 'bill_fname', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->bill_lname = array('frm_fldname' => 'bill_lname', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->bill_ads1 = array('frm_fldname' => 'bill_ads1', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->bill_ads2 = array('frm_fldname' => 'bill_ads2', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->bill_city = array('frm_fldname' => 'bill_city', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->bill_state = array('frm_fldname' => 'bill_state', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->bill_zip = array('frm_fldname' => 'bill_zip', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->bill_country = array('frm_fldname' => 'bill_country', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->date_entered = array('frm_fldname' => 'date_entered', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		$this->trans_id = array('frm_fldname' => 'trans_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->error_reason = array('frm_fldname' => 'error_reason', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->ship_mobile = array('frm_fldname' => 'ship_mobile', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->ship_landline = array('frm_fldname' => 'ship_landline', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->bill_mobile = array('frm_fldname' => 'bill_mobile', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->bill_landline = array('frm_fldname' => 'bill_landline', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->ship_unit  = array('frm_fldname' => 'ship_unit', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->ship_building = array('frm_fldname' => 'ship_building', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->bill_unit  = array('frm_fldname' => 'bill_unit', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->bill_building = array('frm_fldname' => 'bill_building', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');		
		
		$this->bill_email = array('frm_fldname' => 'bill_email', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		
	}
	
	
	/**********************************************************************************************

					Method To Register/Insert a user record.

	***********************************************************************************************/
	
function insert()
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::insert() - PARAMETER LIST : ', $param_array);

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
			
			$this->insert_order_details($resultset[2]);
			
			$ret_val = $resultset;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccount Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::update() - PARAMETER LIST : ', $param_array);

		if($id > 0)
		{
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
			
			if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val, $this->primary_fld, $id,"update"))
			{
				$ret_val = false;
			}
			else
			{

				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);
				
				$ret_val = true;

			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete($rec_id)
	{
	
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::delete() - PARAMETER LIST : ', $param_array);
		
		if($rec_id > 0)
		{
			// for insert into backup table 25062007 - START CODE
			$insert_qry="insert into order_master_backup select * from ".$this->cls_tbl." where order_id = '".$rec_id."'";
			$GLOBALS['db_con_obj']->execute_sql($insert_qry, "insert");
			
			/*$select_qry = "select detail_id from order_details where order_id = '".$rec_id."'";
			$sel_res = $GLOBALS['db_con_obj']->execute_sql($select_qry, "select");
			while($sel_data = mysql_fetch_object($sel_res[0]))
			{ */			
			$qry1="insert into order_details_backup select * from order_details where order_id = '".$rec_id."'";
			$GLOBALS['db_con_obj']->execute_sql($qry1, "insert");
			
			$del_order_details = "delete from order_details where order_id = '".$rec_id."'";				
			$GLOBALS['db_con_obj']->execute_sql($del_order_details , "delete");
			//}
			// for insert into backup table 25062007 - END CODE
			
			database_manipulation::delete_record($this, $rec_id);
			frame_notices("Order details deleted successfully !!", "greenfont");
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::delete() - Return Value : ', $ret_val);

		return $ret_val;
	}

	/******************************************************************************************************
			Method To Maintain Reference between product category and products..
	******************************************************************************************************/
	
	function insert_order_details($current_ord_id)
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::insert_order_details() - PARAMETER LIST : ', $param_array);
		
		if($GLOBALS['from_page'] == "payaction")
		require_once("../../../classes/order_details.class.php");
		
		$temp_orddets_obj = new order_details();
		
		foreach($_SESSION['ses_cart_items'] as $k => $v)
		{
				$temp_orddets_obj->order_id['value'] = $current_ord_id;
				$temp_orddets_obj->prod_id['value'] = $v['prod_id'];
				$temp_orddets_obj->prod_name['value'] = $v['prod_name'];
				$temp_orddets_obj->prod_quantity['value'] = $v['prod_quantity'];
				$temp_orddets_obj->prod_unit_price['value'] = $v['prod_unit_price'];
				$temp_orddets_obj->size['value'] = $v['size'];
				$temp_orddets_obj->colour['value'] = $v['colour'];
				
				$temp_orddets_obj->Weight['value'] = $_SESSION['ses_cart_items1']['Weight'];
				$temp_orddets_obj->prod_code['value'] = $_SESSION['ses_cart_items1']['prod_code'];
				
				
				$temp_orddets_obj->insert();
		}		

		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::insert_order_details() - Return Value : ', $ret_val);
		
		return $ret_val;
	}
	

//*******************************************************************************************************************
	//Search fucction
//*******************************************************************************************************************
	
	function search_query()

		{
		
		
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::search_qurey() - PARAMETER LIST : ', $param_array);
		
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_ord_srch_vars'][$ky] = $vl;
			
			$qry = "select concat(customer_master.cust_firstname,'&nbsp;',customer_master.cust_lastname) as cust_name, " . $this->cls_tbl.".order_id, " . $this->cls_tbl.".date_entered, " . $this->cls_tbl.".order_status," . $this->cls_tbl.".payable_amount, customer_master.cust_firstname, customer_master.cust_lastname from " . $this->cls_tbl.", customer_master where 1 = 1 and " . $this->cls_tbl.".user_id = customer_master.cust_id";
	
			//$qry="select * from " . $this->cls_tbl." where ";
			
			
			$use_cond = " and ";
		
			$join_qry = " and (";
			
			$join_qry_st = 0;
			
			//search with order status - Start
			if(!empty($_SESSION['ses_ord_srch_vars']['order_status']))
			{
				$join_qry .= stripslashes($_SESSION['ses_ord_srch_vars']['order_status']);
				$join_qry_st = 1;
			}
			//search with order status - End
		
		
			//search with order date - Start
			if(!empty($_SESSION['ses_ord_srch_vars']['reportdate']) && !empty($_SESSION['ses_ord_srch_vars']['reportdate1']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
		
				$join_qry .= "(" . $this->cls_tbl.".date_entered >= '" . $_SESSION['ses_ord_srch_vars']['reportdate'] . " 00:00:00' and " . $this->cls_tbl.".date_entered <= '" . $_SESSION['ses_ord_srch_vars']['reportdate1'] . " 23:59:59')";
		
				$join_qry_st = 1;
			}
			//search with order date - End
		
			
			//search with order number - Start
			if(!empty($_SESSION['ses_ord_srch_vars']['start_order_num']) && !empty($_SESSION['ses_ord_srch_vars']['end_order_num']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
		
				$join_qry .= "(" . $this->cls_tbl.".order_id >= '" . $_SESSION['ses_ord_srch_vars']['start_order_num'] . "' and " . $this->cls_tbl.".order_id <= '" . $_SESSION['ses_ord_srch_vars']['end_order_num'] . "')";
		
				$join_qry_st = 1;
			}
			//search with order number - End
		
		
			//search with Buyer name - Start
			if(!empty($_SESSION['ses_ord_srch_vars']['filter_column']) && !empty($_SESSION['ses_ord_srch_vars']['filter_srch_typ']) && !empty($_SESSION['ses_ord_srch_vars']['filter_srch_val']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
		
				$join_qry .= "(lower(" . $_SESSION['ses_ord_srch_vars']['filter_column'] . ") " . stripslashes(str_replace("#val#",strtolower($_SESSION['ses_ord_srch_vars']['filter_srch_val']), $_SESSION['ses_ord_srch_vars']['filter_srch_typ'])) . ")";
		
				$join_qry_st = 1;
			}
			//search with Buyer name - End
			
			if($join_qry_st != 1)
			$join_qry .= "1=1";
			
			$join_qry .= ")";
		
			//add sorting to the query - Start
			if(!empty($_SESSION['ses_ord_srch_vars']['sort_column']))
			{
				$join_qry .= " order by " . $_SESSION['ses_ord_srch_vars']['sort_column'] ;
			}
			//add sorting to the query - End
		
		
			$final_qry = $qry . $join_qry;
			
			$_SESSION['ses_ord_srch_qry'] = $final_qry;
			return $final_qry;
			
		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::search_qurey() - Return Value : ', $ret_val);
		return $ret_val;	
		
	}
	
	//300507 Payment approval email(cron jobs) code START
	function payment_approval_email($num_emails=10)
		{	
				
				//$GLOBALS[site_config][debug] = 1;
				$i=0;
				$result1  .= "<table width=75%  cellpadding=0 cellspacing=0><tr><td width = '15%' align ='left'><b> Order Id </b>&nbsp;</td><td width = '30%' align ='left'><b> Buyer Name </b>&nbsp;</td><td width = '30%' align ='left'>  <b>Buyer Emails  </b></td></tr></table>";
				$param_array = func_get_args();
				$GLOBALS['logger_obj']->debug('<br>METHOD order_master::payment_approval_email() - PARAMETER LIST : ', $param_array);
				
				$failed_result = "<p><strong>Emails not sent for the following orders :</strong> </p><table width=75%  cellpadding=0 cellspacing=0><tr><td width = '15%' align ='left'><b> Order Id </b>&nbsp;</td><td width = '30%' align ='left'><b> Buyer Name </b>&nbsp;</td><td width = '30%' align ='left'>  <b>Buyer Emails  </b></td></tr>";
		
				$qry = "select * from temp_cron_table where method = 'payment' order by id asc limit 0, " . $num_emails;
	
				//$wres = mysql_query($qry);
				$wres = $GLOBALS['db_con_obj']->execute_sql($qry);
				
				if($wres[1] > 0)
				{
				
				while($data_id = mysql_fetch_object($wres[0]))
				
				{
					$val = $data_id->order_id;
					
					
					$ord_d_obj = new order_details();
					
					$cust_obj = new customer_master();
					
					$master_res = $this->fetch_record($val);
					
					$detail_res = $this->fetch_flds($ord_d_obj->cls_tbl, "*", "order_id = '" . $val . "'");
					
					$master_data = mysql_fetch_object($master_res[0]);
										
					include("../forms/invoice_email_dets.php");
					
					//$ser_obj = set_values($ser_obj,"db", $res[0]);
					
					
					$res = $cust_obj->fetch_record($master_data->user_id);
					
					$cust_obj = set_values($cust_obj, "db", $res[0]);
					//email class
					$eml_cls = new email();
					
					$eml_cls->frame_email_body($this->approval_email_ids['pay_app'], array("#firstname#", "#lastname#", "#CN#", "#ordercontent#","#orderno#"), array($cust_obj->cust_firstname['value'], $cust_obj->cust_lastname['value'], $GLOBALS['site_config']['company_name'], $string, $master_data->order_id));
							
					
					$mail_sent =  $eml_cls->send_email($cust_obj->cust_email['value']);
//download link email - Start
		unset($eml_cls);
		
		$eml_cls = new email();
		
		$email_content = "<p>Dear " . stripslashes($cust_obj->cust_firstname['value'] . " " . $cust_obj->cust_lastname['value']) . ", </p>";
		$email_content .= "<table border='0' cellpadding='3' cellspacing='2' width='100%'><tr><td>";
		$email_content .= "Thank you for purchasing ebooks through " . $GLOBALS['site_config']['company_name'] . ".</td></tr><tr><td>";
		$email_content .= "Download links for the purchased ebooks are : </td></tr><tr><td>";
		
		$qry = "select * from " . $ord_d_obj->cls_tbl . " where order_id = '" . $val . "' and download_status = '0' and prod_id not in (" . implode(",", $GLOBALS['consultations_prod_id']) . ")";
		$res = $GLOBALS['db_con_obj']->execute_sql($qry);
		$downloadinfo = "<table border='0' cellpadding='3' cellspacing='1' width='100%'>";
		
		$download_prefix = "download" . $cust_obj->cust_id['value'] . "-" . $val;
		
		$dwnld_link_email = $master_data->ship_email;
		$normal_str = "";
		while($dwn_data = mysql_fetch_object($res[0]))
		{
			$book_name = $GLOBALS['db_con_obj']->fetch_field("product_master","prod_name","prod_id = '" . $dwn_data->prod_id . "'");
			
			$uqry = "update product_master set purchase_count = (purchase_count + 1) where prod_id = '" . $dwn_data->prod_id . "'";
			$GLOBALS['db_con_obj']->execute_sql($uqry,"update");

			$normal_str	= $normal_str . "-" . $dwn_data->prod_id;
			
			//$downloadinfo .= "<tr><td>" . stripslashes($book_name) . "</td><td><a href='" . trim($GLOBALS['site_config']['site_path']) . "download_login.php?bkid=" . $dwn_data->detail_id . "&arg=" . $encrypt_str . "'>Download</a></td></tr>";	
		}
		
					
		$final_str = $download_prefix . $normal_str;

		$encrypt_str = md5($final_str);

		$downloadinfo .= "<tr><td><a href='" . trim($GLOBALS['site_config']['site_path']) . "download_login.php?bkid=" . $val . "&arg=" . $encrypt_str . "'>Click here to Download the ebooks you have purchased</a></td></tr>";	
		
		$downloadinfo .= "</table>";
		
		$email_content .= $downloadinfo . "</td></tr>";
		$email_content .= "<tr><td><p>Thank you</p><p>" . $GLOBALS['site_config']['company_name'] . "</td></tr></table>";
		
		
		$eml_cls->email_type = 'html';
		$eml_cls->email_subject = "Download links for your purchase at " . $GLOBALS['site_config']['company_name'] . " !!";
		$eml_cls->email_message = $email_content;
	
		$eml_cls->send_email($dwnld_link_email); 

//download link email - End

					$failed = 0;
					
					if($mail_sent == 1)
					{
					$i++;
					$result  .= "<table width=75%  cellpadding=0 cellspacing=0><tr><td width = '15%' align ='left'>".$master_data->order_id."&nbsp;</td><td width = '30%' align ='left'>".$cust_obj->cust_firstname['value'].$cust_obj->cust_lastname['value']."&nbsp;</td><td width = '30%' align ='left'>".$cust_obj->cust_email['value']."</td></tr></table>";
					/*
					$email.=$cust_obj->cust_email['value']."<br>";
					$order_id .= $master_data->order_id."<br>";
					$name.= $cust_obj->cust_firstname['value'].$cust_obj->cust_lastname['value']."<br>";
					*/
					}
					else
					{
					$failed = 1;
					$failed_result .= "<tr><td width = '15%' align ='left'>".$master_data->order_id."&nbsp;</td><td width = '30%' align ='left'>".$cust_obj->cust_firstname['value'].$cust_obj->cust_lastname['value']."&nbsp;</td><td width = '30%' align ='left'>".$cust_obj->cust_email['value']."</td></tr>";
					}			
					
					
					//31052007 - implemented log - Start
		
						$error_title = "Payment Approval Email Details";
						
						$err_str = "\n" . "<PaymentApprovalEmail>" . "\n";
						$err_str .= date("Y-m-d H:i:s") . "<br>\n";
						$err_str .= "Order Id : " . $master_data->order_id . "<br>";
						$err_str .= "Name : " . $cust_obj->cust_firstname['value'] . $cust_obj->cust_lastname['value']. "<br>";
						$err_str .= "Email ID : ".$cust_obj->cust_email['value'];
						if($failed == 1)
							$err_str .= "Email Status : Email not sent.";
						else
							$err_str .= "Email Status : Email sent.";
						
						
						$GLOBALS['logger_obj']->error($error_title, $err_str, 'cron');
		
					//31052007 - implemented log - End
					
					$del_query="delete from temp_cron_table where order_id = '".$val."'";
					
					$GLOBALS['db_con_obj']->execute_sql($del_query, "delete");
					
					unset($eml_cls);
					unset($cust_obj);
					
				$GLOBALS['logger_obj']->debug('<br>METHOD order_master::payment_approval_email() - Return Value : ', $ret_val);	
			}
			
			// notification email for admin 
			
			$eml_cls_obj = new email();
			
			$fail = $wres[1]-$i;
			if($fail > 0)
				$failed_result .= "</table>";
			else
				$failed_result = "";
			
			$eml_cls_obj->frame_email_body($this->notificatio_email_id, array("#Date#", "#Number#", "#Number fail#","#email#","#Title#"), array(date("Y-m-d H:i:s"), $i, $fail,$result1.$result.$failed_result,'Payment Approval '));
			
			//echo "Admin Email Id".$GLOBALS['site_config']['admin_email']."<br>";
			
			//echo $result1.$result."<br>";				
										
			$eml_cls_obj->send_email($GLOBALS['site_config']['admin_email']);
			
			// notification email for admin 
			}
		
		}	
	//300507 Payment approval email(cron jobs) code START
	
	
	
	//300507 Shipment approval email(cron jobs) code START
	
	function shipment_approval_email($num_emails=10)
		{	
				$i=0;
				$result1  .= "<table width=75%  cellpadding=0 cellspacing=0><tr><td width = '15%' align ='left'><b> Order Id </b>&nbsp;</td><td width = '30%' align ='left'><b> Buyer Name </b>&nbsp;</td><td width = '30%' align ='left'>  <b>Buyer Emails  </b></td></tr></table>";
				$param_array = func_get_args();
				$GLOBALS['logger_obj']->debug('<br>METHOD order_master::shipment_approval_email() - PARAMETER LIST : ', $param_array);
				
				$qry = "select * from temp_cron_table where method = 'shipment' order by id asc limit 0, " . $num_emails;
	
				//$wres = mysql_query($qry);
				$wres = $GLOBALS['db_con_obj']->execute_sql($qry);
				
				if($wres[1] > 0)
				{
	
				while($data_id = mysql_fetch_object($wres))
				
				{
					$val = $data_id->order_id;
					
					$ord_d_obj = new order_details();
					
					$cust_obj = new order_master();
					
					$master_res = $this->fetch_record($val);
					
					$detail_res = $this->fetch_flds($ord_d_obj->cls_tbl, "*", "order_id = '" . $val . "'");
					
					$master_data = mysql_fetch_object($master_res[0]);
					
					include("../forms/invoice_email_dets.php");
					
					//$ser_obj = set_values($ser_obj,"db", $res[0]);
					
					$res = $cust_obj->fetch_record($master_data->user_id);
					
					$cust_obj = set_values($cust_obj, "db", $res[0]);
					//$GLOBALS[site_config][debug] = 1;
					//email class
					$eml_cls = new email();
					
					$eml_cls->frame_email_body($this->approval_email_ids['ship_app'], array("#firstname#", "#lastname#", "#CN#", "#ordercontent#","#orderno#"), array($cust_obj->cust_firstname['value'], $cust_obj->cust_lastname['value'], $GLOBALS['site_config']['company_name'], $string, $master_data->order_id));
							
					
									
					$mail_sent = $eml_cls->send_email($cust_obj->cust_email['value']);
					
					if($mail_sent == 1)
					//if(1 == 1)					
					{
					$i++; 
					$result  .= "<table width=75%  cellpadding=0 cellspacing=0><tr><td width = '15%' align ='left'>".$master_data->order_id."&nbsp;</td><td width = '30%' align ='left'>".$cust_obj->cust_firstname['value'].$cust_obj->cust_lastname['value']."&nbsp;</td><td width = '30%' align ='left'>".$cust_obj->cust_email['value']."</td></tr></table>";
					/*$email.=$cust_obj->cust_email['value']."<br>";
					$order_id .= $master_data->order_id."<br>";
					$name.= $cust_obj->cust_firstname['value'].$cust_obj->cust_lastname['value']."<br>";*/
					}
					
					//31052007 - implemented log - Start
		
						$cron_title = "Shipment Approval email Details";
						
						$err_str = "\n" . "<ShipmentApprovalEmail>" . "\n";
						$err_str .= date("Y-m-d H:i:s") . "<br>\n";
						$err_str .= "Order Id : " . $master_data->order_id . "<br>";
						$err_str .= "Name : " . $cust_obj->cust_firstname['value'] . $cust_obj->cust_lastname['value']. "<br>";
						$err_str .= "Email ID:".$cust_obj->cust_email['value'];
						
						$GLOBALS['logger_obj']->error($cron_title, $err_str, 'cron');
		
					//31052007 - implemented log - End
					
					$del_query="delete  from temp_cron_table where order_id = '".$val."'";
					
					 $GLOBALS['db_con_obj']->execute_sql($del_query, "delete");
					
					unset($eml_cls);
					unset($cust_obj);
					
					$GLOBALS['logger_obj']->debug('<br>METHOD order_master::shipment_approval_email() - Return Value : ', $ret_val);
					//return $ret_val;
			}
			// notification email for admin 
			
			$eml_cls_obj = new email();
			
			$fail = $num_emails-$i;
			
			$eml_cls_obj->frame_email_body($this->notificatio_email_id, array("#Date#", "#Number#", "#Number fail#","#email#","#Title#"), array(date("Y-m-d H:i:s"), $i, $fail, $result1.$result,'Shipment Approval '));
							
			//echo "Admin Email Id".$GLOBALS['site_config']['admin_email']."<br>";
			//echo $result1.$result."<br>";
									
			$eml_cls_obj->send_email($GLOBALS['site_config']['admin_email']);
			
			}
			// notification email for admin 
			
				
	}
	function delete_record($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::delete() - PARAMETER LIST : ', $param_array);
		
		if($rec_id > 0)
		{
			
			
			$primary_fld = $this->primary_fld;
			database_manipulation::delete_record($this, $rec_id);
			frame_notices("Order details details successfully deleted !!", "greenfont");
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD order_master::delete() - Return Value : ', $ret_val);

		return $ret_val; 
	
	} 
	
	
			
	
			
}

?>

