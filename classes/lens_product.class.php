<?php

class lens_product extends database_manipulation
{


	var $frm_name; //name of the form from where the details are collected.

	var $cls_tbl; //name of the table which this class uses.

	var $cls_sql; //default sql statement for the class.

	var $unique_flds; //unique fields for the table delimited with commas(,).

	var $file_flds; //file fields for the table delimited with commas(,).

	var $attachment_path; //where the files for this table should be uploaded.

	var $books_path; //where the books will be uploaded.

	var $attachment_h; //the file to be uploaded should be with this height, if not reqd set to 0, if set to 0 config default values will be taken.

	var $attachment_w; //the file to be uploaded should be with this width, if not reqd set to 0, if set to 0 config default values will be taken.

	var $attachment_s; //the file to be uploaded should be with this base_price, if not reqd set to 0, if set to 0 config default values will be taken.

	var $attachment_conditions; //what are all the conditions to be handled in the file upload, s for base_price, h for height, w for width

	var $image_copies; //number of copies to be generated from the image field.

	var $primary_fld; //primary fields name of the table.

	var $register_email_id; //primary id from the emails table which contains the registration email.

	var $fp_email_id; //primary id from the emails table which contains the forgot password email.

	var $reference_tables; //tables that have the records related to the table of this class...
	
//database field names - Start

	var $lens_id;
	
	var $lenstype_id;
	
	var $lens_no;
	
	var $lens_desc;
	
	var $base_price;
	
	var $sph_from;
	
	var $sph_to;
	
	var $sph_base_pasitive;
	
	var $sph_base_negative;
	
	var $sph_at_pasi;
	
	var $sph_at_pasi_price;
	
	var $sph_atat_pasi;
	
	var $sph_atat_pasi_price;
	
	var $sph_at_naga;
	
	var $sph_at_naga_price;
	
	var $sph_atat_naga;
	
	var $sph_atat_naga_price;
	
	var $cyl_from;
	
	var $cyl_to;
	
	var $cyl_base_pasitive;
	
	var $cyl_base_negative;
	
	var $cyl_at_pasi;
	
	var $cyl_at_pasi_price;
	
	var $cyl_atat_pasi;
	
	var $cyl_atat_pasi_price;
	
	var $cyl_at_naga;
	
	var $cyl_at_naga_price;
	
	var $cyl_atat_naga;
	
	var $cyl_atat_naga_price;
	
	var $date_entered;
	
	var $date_modified;
	
	
	var $prod_status;
	
	//parameters for search concept - Start
	
	var $search_types;
	
	var $get_search_types;
	
	var $match_case;
	
	var $search_sql;
	
	var $search_cond;
	
	var $srch_ses_val;
	
	var $srch_ses_qry_str;
	
	var $srch_ses_searched_bool;
	
	//parameters for search concept - End

//database field names - End

	function lens_product()
	{
		
		$this->frm_name = 'lens_product_detail_frm';
		
		$this->cls_tbl = 'lens_product';
		
		$this->ref_tbl = "productrefcategory";
		
		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";
		
		$this->unique_flds = 'lens_no';
		
		
		$this->reference_tables = 'productrefcategory|product_id|0,prod_discount_history|lens_id|0'; //tablename|reference_fld_name|file_field_exists,tablename|reference_fld_name|file_field_exists
		
		$this->primary_fld = 'lens_id';
		
		$this->register_email_id = 0;

		$this->fp_email_id = 0;

		//$this->database_fld_name = array( - membervariables should be the database field names...
		
		$this->lens_id = array('frm_fldname' => 'lens_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');
		
		$this->lenstype_id = array('frm_fldname' => 'lenstype_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

		$this->lens_no = array('frm_fldname' => 'lens_no', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

		$this->lens_desc = array('frm_fldname' => 'lens_desc', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

		$this->base_price = array('frm_fldname' => 'base_price', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->sph_from = array('frm_fldname' => 'sph_from', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->sph_to = array('frm_fldname' => 'sph_to', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->sph_base_pasitive = array('frm_fldname' => 'sph_base_pasitive', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->sph_base_negative = array('frm_fldname' => 'sph_base_negative', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

		$this->sph_at_pasi = array('frm_fldname' => 'sph_at_pasi', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->sph_at_pasi_price = array('frm_fldname' => 'sph_at_pasi_price', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
				$this->sph_atat_pasi = array('frm_fldname' => 'sph_atat_pasi', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->sph_atat_pasi_price = array('frm_fldname' => 'sph_atat_pasi_price', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

			$this->sph_at_naga = array('frm_fldname' => 'sph_at_naga', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->sph_at_naga_price = array('frm_fldname' => 'sph_at_naga_price', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
				$this->sph_atat_naga = array('frm_fldname' => 'sph_atat_naga', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->sph_atat_naga_price = array('frm_fldname' => 'sph_atat_naga_price', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

			$this->cyl_from = array('frm_fldname' => 'cyl_from', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->cyl_to = array('frm_fldname' => 'cyl_to', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->cyl_base_pasitive = array('frm_fldname' => 'cyl_base_pasitive', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->cyl_base_negative = array('frm_fldname' => 'cyl_base_negative', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

		$this->cyl_at_pasi = array('frm_fldname' => 'cyl_at_pasi', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->cyl_at_pasi_price = array('frm_fldname' => 'cyl_at_pasi_price', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
				$this->cyl_atat_pasi = array('frm_fldname' => 'cyl_atat_pasi', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->cyl_atat_pasi_price = array('frm_fldname' => 'cyl_atat_pasi_price', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

			$this->cyl_at_naga = array('frm_fldname' => 'cyl_at_naga', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->cyl_at_naga_price = array('frm_fldname' => 'cyl_at_naga_price', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
				$this->cyl_atat_naga = array('frm_fldname' => 'cyl_atat_naga', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');
		
		$this->cyl_atat_naga_price = array('frm_fldname' => 'cyl_atat_naga_price', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

		

	
		$this->date_entered = array('frm_fldname' => 'date_entered', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		$this->date_modified = array('frm_fldname' => 'date_modified', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');

		$this->prod_status = array('frm_fldname' => 'prod_status', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '1');

		$this->match_case = "no";
		
		$this->search_types = array(
		
		array("tbl_fld_name" => "cont_list", "tbl_fld_value" => "contains_keyword", "srch_type" => "contains", "cond_typ" => "or"),
		
		array("tbl_fld_name" => "cont_list1", "tbl_fld_value" => "contains_keyword", "srch_type" => "contains", "cond_typ" => "or"),
		
		array("tbl_fld_name" => "equal_list", "tbl_fld_value" => "equal_keyword", "srch_type" => "equalto", "cond_typ" => "and"),
		
		"save_todb" => 'false'
		
		);
		
		$this->get_search_types = array("save_todb" => "false");
		
		$this->get_search_types[0] = array("search_condition" => "depend_object_setting");

		$this->search_sql = "select " . $this->cls_tbl . ".* from " . $this->cls_tbl . " where 1 = 1 ";

		$this->search_cond = "or";
		
		$this->srch_ses_val = "ses_prod_master_srch_vars";
		
		$this->srch_ses_qry_str = "ses_prod_master_srch_qry";
		
		if(!isset($_SESSION[$this->searched_ses_val]))
		$_SESSION[$this->searched_ses_val] = 0;
		

		
	}
	
	
	/**********************************************************************************************

				Method To Frame Javascript Validation for the mandatory fields.

	***********************************************************************************************/
	
	function frame_validation_script()
	{
	
		$member_var_arr = get_object_vars($this);
		
		$script_str = '<script language="javascript">';
		
		$script_str .= 'function check_validate() {';

		$script_str .= 'error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";';
		
		foreach($member_var_arr as $key => $value)
		{
		
			if(is_array($value) && array_key_exists('ismandatory', $value) && $value['ismandatory']['fld_type'] != 'nil')
			{
			
				
				switch (strtolower($value['ismandatory']['fld_type']))
				{

					case 'email':
						$fun_name = "check_email";
						break;

					case 'numeric':
						$script_str .= 'check_empty(form.elements["' . $value['frm_fldname'] . '"].name,"' . $value['ismandatory']['msg'] . '");';
						$fun_name = "check_numeric";
						break;

					case 'string':
						$fun_name = "check_empty";
						break;

					case 'passwrd':
						$fun_name = "check_match";
						break;

				}//end switch
				
				if($value['ismandatory']['fld_type'] == "passwrd")
				{
					
					$msg_arr = explode("|", $value['ismandatory']['msg']);
					
					$script_str .= 'check_empty(form.elements["' . $value['frm_fldname'] . '"].name, "' . $msg_arr['0'] . '");';

					$script_str .= $fun_name . '(form.elements["' . $value['frm_fldname'] . '"].name, form.elements["c' . $value['frm_fldname'] . '"].name, "' . $msg_arr['1'] . '");';
					
					$script_str .= 'Check_Lengthlow(form.elements["' . $value['frm_fldname'] . '"].name, "' . $msg_arr['2'] . '", "' . $value['ismandatory']['minlen'] . '");';

					$script_str .= 'Check_Lengthhigh(form.elements["' . $value['frm_fldname'] . '"].name, "' . $msg_arr['2'] . '", "' . $value['ismandatory']['maxlen'] . '");';
					
				}
				else
				
					$script_str .= $fun_name . '(form.elements["' . $value['frm_fldname'] . '"].name,"' . $value['ismandatory']['msg'] . '");';
				
			
			}
		
		}
		
		$script_str .= '}';
		
		$script_str .= '</script>';
		
		return $script_str;

	}



	/**********************************************************************************************

					Method To Register/Insert a user record.

	***********************************************************************************************/
	
	function insert()
	{
		
		//print_r($_REQUEST);
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::insert() - PARAMETER LIST : ', $param_array);

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
		
			frame_notices("Product already exists !!", "redfont",1);
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_lens_product_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
			
			$resultset = database_manipulation::insert_record($this);
			
			$t = count($resultset);
			$ret_val = true;
			//echo $t . "<hr>";
			if($t == 1)
			{
				$ret_val = false;
				frame_notices("Product not added due to the following reasons!!", "redfont",1);
				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_lens_product_obj'][$ky] = $vl;
			}
			else
			{	
			
				unset($_SESSION['ses_lens_product_obj']);
						
				
				
				frame_notices("Product successfully added !!", "greenfont", 1);
	
				$ret_val = true;
			}
		}
		//exit;
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccount Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id,$where_notice="outside")
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::update() - PARAMETER LIST : ', $param_array);
	
	//$GLOBALS['site_config']['debug'] =1;
	
	
		
		if($id > 0)
		{
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
			
			if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val, $this->primary_fld, $id,"update"))
			{

				frame_notices("Product name already exists !!", "redfont", 1);

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_lens_product_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_lens_product_obj']);

				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);
				$t = count($resultset);
				$ret_val = true;
				if($t == 1)
				{
					$ret_val = false;
					frame_notices("Product details not updated due to the following reasons!!", "redfont",1);
					foreach($_REQUEST as $ky => $vl)
					$_SESSION['ses_lens_product_obj'][$ky] = $vl;
				}
				else
				{
					
				unset($_SESSION['ses_lens_product_obj']);
						
				
				if($where_notice == "outside")
				frame_notices("Product details successfully updated !!", "greenfont", 1);

				$ret_val = true;
				}
			}
			
		}
//exit;
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::delete() - PARAMETER LIST : ', $param_array);
		
		if($rec_id > 0)
		{
			$primary_fld = $this->primary_fld . " = '" . $rec_id . "'";
			$prnt_id = $this->fetch_field($this->cls_tbl, "prod_parent_id", $primary_fld);
			
			if($prnt_id == -1)
			{
				$this->delete_child_products($rec_id);
			}
			
			database_manipulation::delete_record($this, $rec_id);
			frame_notices("Book deleted !!", "greenfont");
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::delete() - Return Value : ', $ret_val);

		return $ret_val;
	}

	/******************************************************************************************************
			Method To Maintain Reference between product category and products..
	******************************************************************************************************/
	
	function insert_update_reference($selected_category_id, $product_id,$loop=0)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::insert_update_reference() - PARAMETER LIST : ', $param_array);
		
		$temp_prod_cat_obj = new productcategory();
		
		if($loop == 0)
		{
			$del_qry = "delete from " . $this->ref_tbl ." where product_id = '" . $product_id . "'";
			$this->execute_sql($del_qry, "delete");
		}
		$qry = "select category_id, parent_id from " . $temp_prod_cat_obj->cls_tbl . " where category_id = '" . $selected_category_id . "'";
		$res = $this->execute_sql($qry);
		
		if($data = mysql_fetch_object($res[0]))
		{

			$ins_qry = "insert into " . $this->ref_tbl . " (category_id, product_id) values ('" . $selected_category_id . "', '" . $product_id . "')";
			$this->execute_sql($ins_qry, "insert");
			
			$loop++;

			if($data->parent_id > 0)
			$this->insert_update_reference($data->parent_id, $product_id, $loop);

		}
	
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::insert_update_reference() - Return Value : ', $ret_val);
		
		return $ret_val;
	}
	
	/**********************************************************************************************
				Method to delete child products...
	**********************************************************************************************/
	
	function delete_child_products($lens_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::delete_child_products() - PARAMETER LIST : ', $param_array);
		
		$res = $this->fetch_flds($this->cls_tbl,"*", "prod_parent_id = '" . $lens_id . "'");
		
		while($data = mysql_fetch_object($res[0]))
		{
			$this->delete($data->lens_id);
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::insert_update_reference() - Return Value : ', 'Deleted all the child products and returning void');
		
	}

	/**********************************************************************************************
				Method To Dissolve Parent/Children Related Products. This method deletes all child 
				products and makes the parent product a self standing one.
	***********************************************************************************************/
	
	function dissolve_group($prnt_lens_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::dissolve_group() - PARAMETER LIST : ', $param_array);
		
		if($prnt_lens_id > 0)
		{
			$this->delete_child_products($prnt_lens_id); //delete all children products
			$this->prod_parent_id['save_todb'] = true;
			$this->prod_parent_id['value'] = 0;
			$this->update($prnt_lens_id, "self");
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::dissolve_group() - Return Value : ', 'Dissolved the group of the parent and returning void');

	}//end function dissolve_group
	
	/***********************************************************************************************************************
				Method To Record Product Individual Discount History
	*************************************************************************************************************************/
	
	function record_product_individual_discount($lens_id,$purpose="insert")
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::record_product_individual_discount() - PARAMETER LIST : ', $param_array);
		
			$prod_dishist_obj = new prod_discount_history();
			
			$prod_dishist_obj->lens_id['save_todb'] = 'true';
			$prod_dishist_obj->lens_id['value'] = $lens_id;
			
			
			 $dis_qry=database_manipulation::execute_sql("select * from " . $prod_dishist_obj->cls_tbl . " where lens_id = $lens_id and dis_end_dt > now() order by dis_id desc limit 0,1");
			 
			if($dis_qry[1] > 0)
			{
			$data=mysql_fetch_object($dis_qry[0]);
			 $res_id1=$data->dis_id;
			$prod_dishist_obj->update($res_id1);
			}
			else
			{
			$prod_dishist_obj->insert();
			}
			
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::record_product_individual_discount() - Return Value : ', '');

	}
	
	function product_user_search($purpose="search")
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::product_user_search() - PARAMETER LIST : ', $param_array);
		
		if($purpose == "search")
		{
		
			$qry = "select * from " . $this->cls_tbl . " where 1 = 1 and prod_status = '1' and lens_id not in (" . implode(",", $GLOBALS['consultations_lens_id']) . ")";
			
			foreach($_REQUEST as $key => $value)
				$_SESSION['ses_prod_srch_vars'][$key] = $value;
			
			$tmp_qry = " and (";	
			$prev_criteria = 0;
							
			if(strlen(trim($_SESSION['ses_prod_srch_vars']['contains_keyword'])) > 0)
			{
				$prev_criteria = 1;
				$tmp_qry .= "(lower(prod_name) like '%" . wrap_values(strtolower($_SESSION['ses_prod_srch_vars']['contains_keyword'])) . "%' or lower(prod_desc) like '%" . wrap_values(strtolower($_SESSION['ses_prod_srch_vars']['contains_keyword'])) . "%')";
			}		
			
			if(strlen(trim($_SESSION['ses_prod_srch_vars']['equal_keyword'])) > 0)
			{
				if($prev_criteria == 1)
					$tmp_qry .= " and (";
						
				$tmp_qry .= "author = '" . wrap_values($_SESSION['ses_prod_srch_vars']['equal_keyword']) . "'";
				
				if($prev_criteria == 1)
				$tmp_qry .= ")";
				$prev_criteria = 1;
			}
			
			$tmp_qry .= ")";
			
			if($prev_criteria == 1)
			$qry .= $tmp_qry . " order by lens_id desc";
			
			$_SESSION['ses_prod_usr_srch_qry'] = $qry;
			
		}
		else if($purpose == "clearsearch")
		{
			$_SESSION['ses_prod_usr_srch_qry'] = "";
			unset($_SESSION['ses_prod_usr_srch_qry']);
			unset($_SESSION['ses_prod_srch_vars']);
		}
				
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::product_user_search() - Return Value : ', '');

	}
	
	function get_total_downloads($lens_id)
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::get_total_downloads() - PARAMETER LIST : ', $param_array);
		
		if(file_exists("classes/order_details.class.php"))
			require_once("classes/order_details.class.php");
		else
			require_once("../classes/order_details.class.php");
		
		$ord_dobj = new order_details();
		
		$qry = "select detail_id from " . $ord_dobj->cls_tbl . " where lens_id = '" . $lens_id . "' and download_status = '1'";
		$res = $GLOBALS['db_con_obj']->execute_sql($qry);
		
		$download_cnt = $res[1];
		
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::get_total_downloads() - Return Value : ', $download_cnt);

		return $download_cnt;
	
	}
	
	function get_product_rating($lens_id)
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::get_product_rating() - PARAMETER LIST : ', $param_array);
		
		if(file_exists("classes/your_review.class.php"))
			require_once("classes/your_review.class.php");
		else
			require_once("../classes/your_review.class.php");
		
		$urrev_obj = new your_review();
		
		$qry = "select avg(rating) as avg_rating from " . $urrev_obj->cls_tbl . " where lens_id = '" . $lens_id . "' and status = '1'";
		$res = $GLOBALS['db_con_obj']->execute_sql($qry);
		
		$data = mysql_fetch_object($res[0]);

		$avg_rating = $data->avg_rating;
		
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::get_product_rating() - Return Value : ', $avg_rating);

		return $avg_rating;
	
	}
	
	function display_rating($rating_val)
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::display_rating() - PARAMETER LIST : ', $param_array);
		
		$star_rating_str = "";
		
		for($i = 1; $i <= floor($rating_val); $i++)
			$star_rating_str .= "<img src='images/ssmall2.gif' border='0'>";
		
		if(floor($rating_val) < $rating_val)
		$star_rating_str .= "<img src='images/ssmall3.gif' border='0'>";
		
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::display_rating() - Return Value : ', $star_rating_str);

		return $star_rating_str;
	
	}

	//functions added on 24062007 - End

	function check_insert_author($txt_fld_val='', $dd_fld_val='', $adv_id=0)
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::check_insert_author() - PARAMETER LIST : ', $param_array);
		
		if(file_exists("../classes/author.class.php"))
			require_once("../classes/author.class.php");
		else
			require_once("classes/author.class.php");
		
		$auth_obj = new author();
		
		if(strlen(trim($txt_fld_val)) > 0)
		{
			$qry = "select " . $auth_obj->primary_fld . " from " . $auth_obj->cls_tbl . " where lower(name) = '" . wrap_values(strtolower($txt_fld_val)) . "'";
			$res = $GLOBALS['db_con_obj']->execute_sql($qry);
		}
		else if(strlen(trim($dd_fld_val)) > 0)
		{
			$qry = "select " . $auth_obj->primary_fld . " from " . $auth_obj->cls_tbl . " where " . $auth_obj->primary_fld . " = '" . wrap_values(strtolower($dd_fld_val)) . "'";
			$res = $GLOBALS['db_con_obj']->execute_sql($qry);
		}
		
		if($res[1] > 0)
		{
			$data = mysql_fetch_object($res[0]);
			$ret_val = $data->{$auth_obj->primary_fld};
		}
		else if(strlen(trim($txt_fld_val)) > 0)
		{
			
			$qry = "insert into " . $auth_obj->cls_tbl . " (name, created_datetime, modify_datetime) values ('" . wrap_values($txt_fld_val) . "', now(), now())";
			
			$ins_res = $GLOBALS['db_con_obj']->execute_sql($qry, "insert");
			
			$ret_val = $ins_res[2];
	
		}
		
		$uqry = "update " . $this->cls_tbl . " set author = '" . $ret_val . "' where " . $this->primary_fld . " = '" . $adv_id . "'";
		
		$GLOBALS['db_con_obj']->execute_sql($uqry, "update");
		
		$GLOBALS['logger_obj']->debug('<br>METHOD lens_product::check_insert_author() - Return Value : ', 'Returning void');

	}
	//functions added on 24062007 - End
				
}

?>
