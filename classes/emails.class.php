<?php


class emails extends database_manipulation
{


	var $frm_name; //name of the form from where the details are collected.

	var $cls_tbl; //name of the table which this class uses.

	var $cls_sql; //default sql statement for the class.

	var $unique_flds; //unique fields for the table delimited with commas(,).

	var $file_flds; //file fields for the table delimited with commas(,).

	var $attachment_path; //where the files for this table should be uploaded.

	var $primary_fld; //primary fields name of the table.

	var $register_email_id; //primary id from the emails table which contains the registration email.

	var $fp_email_id; //primary id from the emails table which contains the forgot password email.

//database field names - Start

	var $emails_id;
	
	var $emails_title;
	
	var $emails_subject;
	
	var $emails_body;
	
	var $emails_type;
	
	var $emails_purpose;
	
	var $emails_format;
	
	var $date_entered;
	
	var $date_modified;
	

	
//database field names - End

	function emails()
	{
		
		$this->frm_name = 'emails_detail_frm';
		
		$this->cls_tbl = 'emails';
		
		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1";
		
		$this->unique_flds = 'emails_id';
		
		$this->file_flds = '';
		
		$this->primary_fld = 'emails_id';
		
	
		
		if(file_exists("../upload/"))

			$this->attachment_path = '../upload/emails_files/';
			
		else
		
			$this->attachment_path = 'upload/emails_files/';
		
		//$this->database_fld_name = array( - emailsvariables should be the database field names...
			
		$this->emails_id = array('frm_fldname' => 'emails_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');

		$this->emails_title = array('frm_fldname' => 'emails_title', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '11', 'maxlen' => '11', 'msg' => 'Enter Email Title!'), 'value' => '');
		
		$this->emails_subject = array('frm_fldname' => 'emails_subject', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter Email Subject!'), 'value' => '');
		
		$this->emails_body = array('frm_fldname' => 'emails_body', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter Email Body!'), 'value' => '');
		
				
		$this->emails_type = array('frm_fldname' => 'emails_type', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter Email Type!'), 'value' => '');
		
		$this->emails_purpose = array('frm_fldname' => 'emails_purpose', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter Email Purpose!'), 'value' => '');
		
		$this->emails_format = array('frm_fldname' => 'emails_format', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select Email Format!'), 'value' => '');
			
		$this->date_entered = array('frm_fldname' => 'date_entered', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		$this->date_modified = array('frm_fldname' => 'date_modified', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		
	}
	
	
	/**********************************************************************************************

				Method To Frame Javascript Validation for the mandatory fields.

	***********************************************************************************************/
	
	function frame_validation_script()
	{
	
		$emails_var_arr = get_object_vars($this);
		
		$script_str = '<script language="javascript">';
		
		$script_str .= 'function check_validate() {';

		$script_str .= 'error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";';
		
		foreach($emails_var_arr as $key => $value)
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
		$GLOBALS['logger_obj']->debug('<br>METHOD email::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$ufld_arr = explode(",", $this->unique_flds);
		$chk_val = "";
		
		foreach($ufld_arr as $key => $val)

			$chk_val .= $_REQUEST[$val] . ",";

		$chk_val = substr($chk_val, 0, -1);
		
		if(database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))
		{
		
			frame_notices("Email Information already exists !!", "redfont");
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temails_emails_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
			$resultset = database_manipulation::insert_record($this);
			
			unset($_SESSION['ses_temails_emails_obj']);
			
			//22012007 - upon account creation send email to that user.. - Start
			
		///	$eml_cls = new email();
			/*
			 If required add specific cc and bcc emails with this methods
			$eml_cls->add_ccemail("apr_emails@hotmail.com");
			
			$eml_cls->add_bccemail("apr_emails@sify.com");
			*/
						
			//$res = $this->fetch_record($resultset[2]);
			
		///	$obj = set_values($this);
			
			
			//$fld_arr = get_object_vars($this);
			
	/*		$state_arr = database_manipulation::fetch_flds("state", "statename", "stateid = '" . $obj->state['value'] . "'");
			
			$state_d = mysql_fetch_array($state_arr[0]);
			$state_val = $state_d[0];
				
			$ctry_arr = database_manipulation::fetch_flds("country", "countryname", "countryid = '" . $obj->country['value'] . "'");

			$ctry_d = mysql_fetch_array($ctry_arr[0]);
			$ctry_val = $ctry_d[0];
				
			
			$eml_cls->frame_email_body($this->register_email_id, array("#first_name#", "#last_name#", "#address1#", "#address2#", "#city#", "#state#", "#country#", "#postalcode#", "#phone#", "#email#", "#cust_password#", "#CN#"), array($obj->first_name['value'], $obj->last_name['value'], $obj->address1['value'], $obj->address2['value'], $obj->city['value'], $state_val, $ctry_val, $obj->postalcode['value'], $obj->phone['value'], $obj->email['value'], $obj->cust_password['value'], $GLOBALS['site_config']['company_name']));
			
			$eml_cls->send_email($obj->email['value']); */
			
			//22012007 - upon account creation send email to that user.. - End
			
			frame_notices("Email Information Successfully Created !!", "greenfont");

			$ret_val = true;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD email::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD admin::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD admin::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccount Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD email::update() - PARAMETER LIST : ', $param_array);
		
		if($id > 0)
		{
			//need to check the uniqueness for username and email...
			
			$ufld_arr = explode(",", $this->unique_flds);
			$chk_val = "";
			
			foreach($ufld_arr as $key => $val)
	
				$chk_val .= $_REQUEST[$val] . ",";
	
			$chk_val = substr($chk_val, 0, -1);
			
			if(database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val, $this->primary_fld, $id,"update"))
			{

				frame_notices("Email Information Already Exists !!", "redfont");

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temails_emails_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_temails_emails_obj']);
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Email Information Successfully Updated !!", "greenfont");

				$ret_val = true;
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD email::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete($emails_id)
	{
	$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD state::delete() - PARAMETER LIST : ', $param_array);
		
		if($emails_id > 0)
		{
		
			$primary_fld = $this->primary_fld;
			
				frame_notices("Email Information Successfully Deleted!!", "redfont");
				
				$ret_val = database_manipulation::delete_record($this, $emails_id);
			
		}
	
	}
	
	/**********************************************************************************************

					Method To allow the user to login. 

	***********************************************************************************************/

	function login()
	{
		
	/*	$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD email::login() - PARAMETER LIST : ', $param_array);

		$qry = "select " . $this->primary_fld . ", priority from " . $this->cls_tbl . " where emails_uname = '" . wrap_values($_REQUEST['emails_uname']) . "' and emails_password = '" . wrap_values($_REQUEST['emails_password']) . "'";
		
		$res = database_manipulation::execute_sql($qry);
		
		if($res[1] == 1)
		{//username and password are valid for that user...
			$data = mysql_fetch_object($res[0]);
			$fld = $this->primary_fld;
			$_SESSION['ses_emails_id'] = $data->$fld;
			$_SESSION['ses_emails_priority'] = $data->priority;
			$ret_val = true;
		}
		else
		{//invalid username/password...
			frame_notices("Invalid Username/Password, Try Again !!","redfont");
			$ret_val = false;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD email::login() - Return Value : ', $ret_val);

		return $ret_val; */
		
	}
	
	/**********************************************************************************************

					Method To email the username to the user. Forgot username feature.

	***********************************************************************************************/

	function forgot_username()
	{
	
	
	}
	
	/**********************************************************************************************

					Method To email the password to the user. Forgot password feature.

	***********************************************************************************************/

	function forgot_password()
	{

		
		
	}


}





?>
