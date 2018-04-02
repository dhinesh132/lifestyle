<?php

class prod_discount_history extends database_manipulation
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
	
//database field names - Start

	var $dis_id;

	var $prod_discount_val;
	
	var $prod_discount_typ;
	
	var $dis_st_dt;
	
	var $dis_end_dt;
	
	var $prod_id;
	
	var $date_entered;
	
	var $date_modified;
	
//database field names - End

	function prod_discount_history()
	{
		
		$this->frm_name = 'prod_discount_history_detail_frm';
		
		$this->cls_tbl = 'prod_discount_history';
		
		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1";
		
		$this->unique_flds = '';
		
		$this->file_flds = '';
		
		$this->reference_tables = ''; //tablename|reference_fld_name|file_field_exists,tablename|reference_fld_name|file_field_exists
		
		$this->primary_fld = '';
		
		$this->register_email_id = 0;

		$this->fp_email_id = 0;
		
		$this->attachment_h = 110;
		
		$this->attachment_w = 110;
		
		$this->attachment_s = 512000;
		
		$this->attachment_conditions = "shw"; //any of the following values can be set to this. - s - size,h - height,w - width,sh - size and height,sw - size and width,hw - height and width,shw - size, height and width.
		
		$this->image_copies = array();
		
		$this->upload_msgs = array();
		
		//$this->image_copies_fld_names = "thumb_photo1|th|60|60,photo1|med|110|110,large_photo1|large|300|300";//database field_name|suffix_in_file_name|width|large
		
		if(file_exists("../uploads/"))

			$this->attachment_path = '../uploads/category_files/';
			
		else
		
			$this->attachment_path = 'uploads/category_files/';
		
		//$this->database_fld_name = array( - membervariables should be the database field names...
		
		$this->dis_id = array('frm_fldname' => 'dis_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');

		$this->prod_id = array('frm_fldname' => 'prod_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter category name!'), 'value' => '');
		
		$this->prod_discount_val = array('frm_fldname' => 'prod_discount_val', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount!'), 'value' => '');
		
		$this->prod_discount_typ = array('frm_fldname' => 'prod_discount_typ', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
		
		$this->dis_st_dt = array('frm_fldname' => 'dis_st_dt', 'fld_type' => 'date', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
		
		$this->dis_end_dt = array('frm_fldname' => 'dis_end_dt', 'fld_type' => 'date', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
		
		$this->date_entered = array('frm_fldname' => 'date_entered', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		$this->date_modified = array('frm_fldname' => 'date_modified', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		
	}
	
	/***************************************************************************************************************
							Method To Insert Record For Discount History
	***************************************************************************************************************/
	
	function insert()
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD prod_discount_history::insert() - PARAMETER LIST : ', $param_array);

		$resultset = database_manipulation::insert_record($this);
		$ret_val = true;

		$GLOBALS['logger_obj']->debug('<br>METHOD prod_discount_history::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	
	/***************************************************************************************************************
							Method To Update Record For Discount History
	***************************************************************************************************************/
	
	function update($res_id1)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD prod_discount_history::update() - PARAMETER LIST : ', $param_array);

		$resultset = database_manipulation::update_record($this,"dis_id='$res_id1'");
		$ret_val = true;

		$GLOBALS['logger_obj']->debug('<br>METHOD prod_discount_history::update() - Return Value : ', $ret_val);

		return $ret_val;
	
	}

/*
	function delete($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD prod_discount_history::delete() - PARAMETER LIST : ', $param_array);
		
		if($rec_id > 0)
		{
			database_manipulation::delete_record($this, $rec_id);
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD prod_discount_history::delete() - Return Value : ', $ret_val);

		return $ret_val;
	}
*/

}

?>
