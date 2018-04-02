<?php

class productrefcategory extends database_manipulation
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

	var $category_id;
	
	var $product_id;
	
//database field names - End

	function productrefcategory()
	{
		
		$this->frm_name = 'productrefcategory_detail_frm';
		
		$this->cls_tbl = 'productrefcategory';
		
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
		
		$this->category_id = array('frm_fldname' => 'category_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');

		$this->product_id = array('frm_fldname' => 'product_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter category name!'), 'value' => '');
		
	}
	
	
}

?>
