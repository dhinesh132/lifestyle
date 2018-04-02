<?php

class your_review extends database_manipulation

{

		
		
		var $frm_name; 
	
		var $cls_tbl; 
		
		var $cls_sql; 
	
		var $unique_flds; 
		
		var $file_flds; 
		
		var $attachment_path; 
		
		var $primary_fld; 
	
		//var $register_email_id; 
	
		//var $fp_email_id; 
		
		var $id;
		
		var $prod_id;
		
		var $user_id;
		
		var $heading;
		
		var $review_text;
		
		var $pros;
		
		var $cons;
		
		var $rating;
				
		var $status;
				
		var $created_datetime;
		
		var $modify_datetime;
				
	
function your_review()
	{
		
		$this->frm_name = 'your_review_frm';
		
		$this->cls_tbl = 'your_review';
		
		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1";
		
		$this->unique_flds = '';
		
		$this->file_flds = '';
		
		$this->primary_fld = 'id';
		
		//$this->register_email_id = 1;

		//$this->fp_email_id = 2;
	
	
	$this->id = array('frm_fldname' => 'id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');
	
	$this->prod_id = array('frm_fldname' => 'prod_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');
	
	$this->user_id = array('frm_fldname' => 'user_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');
	
		
	$this->heading= array('frm_fldname' => 'heading', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'String','minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter the your_review name !'), 'value' => '');
	
	$this->review_text= array('frm_fldname' => 'review_text', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'String','minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter the your_review name !'), 'value' => '');
	
	$this->pros= array('frm_fldname' => 'pros', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'String','minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter the your_review name !'), 'value' => '');
	
	$this->cons= array('frm_fldname' => 'cons', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'String','minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter the your_review name !'), 'value' => '');
	
	$this->rating= array('frm_fldname' => 'rating', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'String','minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter the your_review name !'), 'value' => '');
		
	$this->status = array('frm_fldname' => 'status', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil','minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter the your_review name !'), 'value' => '');
		
	$this->created_datetime = array('frm_fldname' => 'created_datetime', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false','value' => '');
		
		$this->modify_datetime = array('frm_fldname' => 'modify_datetime', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false','value' => '');	
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
		$GLOBALS['logger_obj']->debug('<br>METHOD your_review::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		$your_review_n_e = false;
		$your_review_c_e = false;
		if(strlen($this->unique_flds) > 0)
		{
		$ufld_arr = explode(",", $this->unique_flds);
		$chk_val = "";
		
		foreach($ufld_arr as $key => $val)
			{
			$your_review_ex[] = database_manipulation::record_exists($this->cls_tbl, $val, $_REQUEST[$val]);
			$chk_val .= $_REQUEST[$val] . ",";
			}
		$your_review_n_e = $your_review_ex[0];
		$your_review_c_e = $your_review_ex[1];
		
		$chk_val = substr($chk_val, 0, -1);
		}
		
		//if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val,'','',"insert",'or'))
		 if (($your_review_n_e) ||($your_review_c_e))
		{
		
		frame_notices("your_review already exists  !!", "redfont");
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_your_review_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
			$resultset = database_manipulation::insert_record($this);
			
			unset($_SESSION['ses_temp_your_review_obj']);
			
			frame_notices("Your review has been added. It will be publicly visible when approved!!  ", "greenfont");

			$ret_val = true;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD your_review:insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD your_review::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD your_review::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccount Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD your_review::update() - PARAMETER LIST : ', $param_array);
		
		if($id > 0)
		{
			//need to check the uniqueness for username and email...
			
			$your_review_n_e = false;
			$your_review_c_e = false;
			
			if(strlen($this->unique_flds) > 0)
			{
			$ufld_arr = explode(",", $this->unique_flds);
			$chk_val = "";
			
			foreach($ufld_arr as $key => $val)
				{
			$your_review_ex[] = database_manipulation::record_exists($this->cls_tbl, $val, $_REQUEST[$val],$this->primary_fld, $id,"update");
				$chk_val .= $_REQUEST[$val] . ",";
			}
			$your_review_n_e = $your_review_ex[0];
			$your_review_c_e = $your_review_ex[1];
			
			$chk_val = substr($chk_val, 0, -1);
			}
		if (($your_review_n_e) ||($your_review_c_e))
		{
		frame_notices("Your review already exists  !!", "redfont");

				//frame_notices("your_review already exists !!", "redfont");

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_your_review_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_temp_your_review_obj']);
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Your review successfully updated , It will be publicly visible when approved !!", "greenfont");

				$ret_val = true;
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD your_review::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD your_review::delete() - PARAMETER LIST : ', $param_array);
		
		if($rec_id > 0)
		{
			$primary_fld = $this->primary_fld;
			
				frame_notices("Your review details deleted !!", "redfont");
				database_manipulation::delete_record($this, $rec_id);
			
			
			
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD your_review::delete() - Return Value : ', $ret_val);

		return $ret_val;

	}
	
	

	


}

?>																									