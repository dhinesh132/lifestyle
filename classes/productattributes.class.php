<?php

class productattributes extends database_manipulation
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
	
	var $cat_name;
	
	var $cat_desc;
	
	var $parent_id;
	
	var $date_entered;
	
	var $date_modified;
	
//database field names - End

	function productattributes()
	{
		
		$this->frm_name = 'productattributes_detail_frm';
		
		$this->cls_tbl = 'productattributes';
		
		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1";
		
		$this->unique_flds = 'parent_id,attr_name';
		
		$this->file_flds = '';
		
		$this->reference_tables = ''; //tablename|reference_fld_name|file_field_exists,tablename|reference_fld_name|file_field_exists
		
		$this->primary_fld = 'attr_id';
		
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
		
		$this->attr_id = array('frm_fldname' => 'attr_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');

		$this->attr_name = array('frm_fldname' => 'attr_name', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter attribute!'), 'value' => '');
		
		$this->parent_id = array('frm_fldname' => 'parent_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount!'), 'value' => '');
		
		$this->date_entered = array('frm_fldname' => 'date_entered', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		$this->date_modified = array('frm_fldname' => 'date_modified', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		
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
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD productattributes::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$ufld_arr = explode(",", $this->unique_flds);
		$chk_val = "";
		
		foreach($ufld_arr as $key => $val)

			$chk_val .= $_REQUEST[$val] . ",";

		$chk_val = substr($chk_val, 0, -1);
		
		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))
		{
		
			frame_notices("Product attribute already exists !!", "redfont");
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_productattributes_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
			$resultset = database_manipulation::insert_record($this);
			
			unset($_SESSION['ses_temp_productattributes_obj']);
			
			frame_notices("Product attribute successfully added !!", "greenfont");

			$ret_val = true;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD productattributes::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD productattributes::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD productattributes::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccount Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD productattributes::update() - PARAMETER LIST : ', $param_array);
		
		if($id > 0)
		{
			//need to check the uniqueness for username and email...
			
			$ufld_arr = explode(",", $this->unique_flds);
			$chk_val = "";
			
			foreach($ufld_arr as $key => $val)
	
				$chk_val .= $_REQUEST[$val] . ",";
	
			$chk_val = substr($chk_val, 0, -1);
			
			if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val, $this->primary_fld, $id,"update"))
			{

				frame_notices("Product attribute name already exists !!", "redfont");

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_productattributes_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_temp_productattributes_obj']);
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Product attribute details successfully updated !!", "greenfont");

				$ret_val = true;
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD productattributes::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD productattributes::delete() - PARAMETER LIST : ', $param_array);
		
		if($rec_id > 0)
		{
			$primary_fld = $this->primary_fld;
			database_manipulation::delete_record($this, $rec_id);
			frame_notices("Product attribute deleted !!", "redfont");
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD productattributes::delete() - Return Value : ', $ret_val);

		return $ret_val;
	}

	/******************************************************************************************************************
	
				Method To List Category In Heirarchy.
				
	******************************************************************************************************************/
	
	function get_attributes($show_selected=0, $parent_id=0, $level=1)
	{
	
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD productattributes::get_attributes() - PARAMETER LIST : ', $param_array);
		
		$options = "";
		$hyphen_ctr = $level;
		
		$qry = "select attr_name, attr_id from " . $this->cls_tbl . " where parent_id = '" . $parent_id . "' order by cat_name asc";
		
		//commented on 30-04-2007
		//$res = mysql_query($qry);

		//added on 30-04-2007
		$res = database_manipulation::execute_sql($qry);
		
		$level = ($level + 1);
		$hyphen_str = '';
		
		for($i = 0; $i < $hyphen_ctr; $i++)
		$hyphen_str .= "-";
		
		//commented on 30-04-2007
		//while($data = mysql_fetch_object($res))

		//added on 30-04-2007
		while($data = mysql_fetch_object($res[0]))
		{
			
			$sel_txt = ($data->category_id == $show_selected)?"selected":"";
			
			$options .= "<option value='" . $data->category_id . "' $sel_txt>" . stripslashes($hyphen_str . " " . $data->cat_name) . "</option>";
	
			$sub_qry = "select attr_name, attr_id from " . $this->cls_tbl . " where parent_id = '" . $data->attr_id . "'";
			//commented on 30-04-2007
			//$sub_res = mysql_query($sub_qry);
			
			//added on 30-04-2007
			$sub_res = database_manipulation::execute_sql($sub_qry);
	
			//commented on 30-04-2007
			//if(mysql_num_rows($sub_res) > 0)

			//added on 30-04-2007
			if($sub_res[1] > 0)
			$options .= $this->get_categories($show_selected, $data->attr_id, $level);
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD productattributes::get_attributes() - Return Value : ', $options);

		return $options;
	}
	
	/*******************************************************************************************
								Frame Attributes As Drop Down
	*******************************************************************************************/
	
	function frame_attribute_types_asdropdown($parent_id=0,$selected_id=0)
	{
	
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD productattributes::frame_attribute_types_asdropdown() - PARAMETER LIST : ', $param_array);

		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", "parent_id = '" . $parent_id . "'");
		
		$ret_str = "";
		
		while($data = mysql_fetch_object($res[0]))
		{
			$sel_txt = ($selected_id == $data->attr_id)?"selected":"";
			
			$ret_str .= "<option value='" . $data->attr_id . "' $sel_txt>" . stripslashes($data->attr_name) . "</option>\n";
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD productattributes::frame_attribute_types_asdropdown() - Return Value : ', $ret_str);

		return $ret_str;
	}
	
}

?>
