<?php
//for email
if(file_exists("classes/email.class.php"))
	require_once("classes/email.class.php");
else if(file_exists("./classes/email.class.php"))
	require_once("./classes/email.class.php");
else if(file_exists("../classes/email.class.php"))
	require_once("../classes/email.class.php");

class courses extends database_manipulation

{

		var $frm_name; 
	
		var $cls_tbl; 
		
		var $cls_sql; 
	
		var $unique_flds; 
		
	    var $file_flds; //file fields for the table delimited with commas(,).

		var $attachment_path; //where the files for this table should be uploaded.
	
		var $attachment_h; //the file to be uploaded should be with this height, if not reqd set to 0, if set to 0 config default values will be taken.
	
		var $attachment_w; //the file to be uploaded should be with this width, if not reqd set to 0, if set to 0 config default values will be taken.
	
		var $attachment_s; //the file to be uploaded should be with this size, if not reqd set to 0, if set to 0 config default values will be taken.
	
		var $attachment_conditions; //what are all the conditions to be handled in the file upload, s for size, h for height, w for width
		
		var $primary_fld; 
	
		//for email
		var $register_email_id; 
	
	    var $reference_tables; //tables that have the records related to the table of this class...
		
		var $fp_email_id; 
		//for email
		
		var $course_id;
		
		var $course_school;
		
		var $course_catid;
			
		var $course_title;
		
		var $course_credit;
					
		var $course_lab;
		
		var $course_weight;
		
		var $date_modified;
		
		var $date_entered;
		
			
function courses()
	{
		
		$this->frm_name = 'courses_frm';
		
		$this->cls_tbl = 'courses';
		
		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1";
		
		$this->unique_flds ="course_catid,course_title,course_school";
		
		$this->file_flds = '';
		
		$this->primary_fld = 'course_id';
		
		//for email
		$this->register_email_id = 3;

		$this->fp_email_id = 4;

	    //for email
	     $this->course_id = array('frm_fldname' => 'course_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		
		$this->course_catid = array('frm_fldname' => 'course_catid', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->course_school = array('frm_fldname' => 'course_school', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->course_title = array('frm_fldname' => 'course_title', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->course_credit = array('frm_fldname' => 'course_credit', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		
		$this->course_lab = array('frm_fldname' => 'course_lab', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true','value' => '0');

		$this->course_weight = array('frm_fldname' => 'course_weight', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->date_entered = array('frm_fldname' => 'date_entered', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false','value' => '');
		
		$this->date_modified = array('frm_fldname' => 'date_modified', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false','value' => ''); 
		

		
		
	
	
	}
	
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
		$GLOBALS['logger_obj']->debug('<br>METHOD courses::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$ufld_arr = explode(",", $this->unique_flds);
		$chk_val = "";
		
		foreach($ufld_arr as $key => $val)

			$chk_val .= $_REQUEST[$val] . ",";

		$chk_val = substr($chk_val, 0, -1);
				
		 if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))
		{
		
			frame_notices("Course already exists for this school !!", "redfont");
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_cour_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
			$resultset = database_manipulation::insert_record($this);
			
			unset($_SESSION['ses_temp_cour_obj']);
			
			frame_notices("Course successfully created !!", "greenfont");

			$ret_val = true;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD courses::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccourset Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD courses::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD courses::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccourset Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD courses::update() - PARAMETER LIST : ', $param_array);
		
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

				frame_notices("Course already exists for this school !!", "redfont");

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_cour_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_temp_cour_obj']);
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Course successfully updated !!", "greenfont");

				$ret_val = true;
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD courses::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete_record($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD courses::delete() - PARAMETER LIST : ', $param_array);
		
		if($rec_id > 0)
		{
			$primary_fld = $this->primary_fld;
			database_manipulation::delete_record($this, $rec_id);
			frame_notices("Course details successfully deleted !!", "greenfont");
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD courses::delete() - Return Value : ', $ret_val);

		return $ret_val; 
	
	} 

	
	

}

?>																									