<?php


class admin extends database_manipulation
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

	var $admin_id;
	
	var $admin_uname;
	
	
	
	var $priority;
	
	var $admin_password;
	
	var $assigned_modules;
	
	var $date_entered;
	
	var $date_modified;
	
//database field names - End

	function admin()
	{
		
		$this->frm_name = 'admin_detail_frm';
		
		$this->cls_tbl = 'admin';
		
		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 and priority < '" . $_SESSION['ses_admin_priority'] . "'";
		
		$this->unique_flds = 'admin_uname';
		
		$this->file_flds = '';
		
		$this->primary_fld = 'admin_id';
		
	
		
		if(file_exists("../upload/"))

			$this->attachment_path = '../upload/admin_files/';
			
		else
		
			$this->attachment_path = 'upload/admin_files/';
		
		//$this->database_fld_name = array( - adminvariables should be the database field names...
		
		$this->admin_id = array('frm_fldname' => 'admin_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');

		$this->admin_uname = array('frm_fldname' => 'admin_uname', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '11', 'maxlen' => '11', 'msg' => 'Enter Admin name!'), 'value' => '');
		
		$this->priority = array('frm_fldname' => 'priority', 'fld_type' => 'str', 'frm_fld_type' => 'select', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select a Priority!'), 'value' => '');
				
		$this->admin_password = array('frm_fldname' => 'admin_password', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'passwrd', 'minlen' => '4', 'maxlen' => '12', 'msg' => 'Enter your password!|Passwords do not match!|Password should be have a minimum of 4 and a maximum of 12 characters!'), 'value' => '');
		
		$this->assigned_modules = array('frm_fldname' => 'assigned_modules', 'fld_type' => 'str', 'frm_fld_type' => 'select', 'save_todb' => 'true', 'ismandatory' => array(), 'value' => '');
		
		$this->project = array('frm_fldname' => 'project', 'fld_type' => 'str', 'frm_fld_type' => 'select', 'save_todb' => 'true', 'ismandatory' => array(), 'value' => '');	
			
		$this->access_level = array('frm_fldname' => 'access_level', 'fld_type' => 'str', 'frm_fld_type' => 'select', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select a Priority!'), 'value' => '');
				
		$this->date_entered = array('frm_fldname' => 'date_entered', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		$this->date_modified = array('frm_fldname' => 'date_modified', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		
	}
	
	
	/**********************************************************************************************

				Method To Frame Javascript Validation for the mandatory fields.

	***********************************************************************************************/
	
	function frame_validation_script()
	{
	
		$admin_var_arr = get_object_vars($this);
		
		$script_str = '<script language="javascript">';
		
		$script_str .= 'function check_validate() {';

		$script_str .= 'error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";';
		
		foreach($admin_var_arr as $key => $value)
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
		$GLOBALS['logger_obj']->debug('<br>METHOD admin::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$ufld_arr = explode(",", $this->unique_flds);
		$chk_val = "";
		
		foreach($ufld_arr as $key => $val)

			$chk_val .= $_REQUEST[$val] . ",";

		$chk_val = substr($chk_val, 0, -1);
		
		if(database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))
		{
		
			frame_notices("Admin already exists in our database !!", "redfont");
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_admin_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
			//$this->assigned_modules['value'] = implode(",", $_REQUEST['modules']);
			
			$resultset = database_manipulation::insert_record($this);
			
			unset($_SESSION['ses_temp_admin_obj']);
			
			//22012007 - upon account creation send email to that user.. - Start
			
		///	$eml_cls = new email();
			/*
			 If required add specific cc and bcc emails with this methods
			$eml_cls->add_ccemail("apr_emp@hotmail.com");
			
			$eml_cls->add_bccemail("apr_emp@sify.com");
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
			
			frame_notices("Admin account successfully created !!", "greenfont");

			$ret_val = true;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD admin::insert() - Return Value : ', $ret_val);

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
		$GLOBALS['logger_obj']->debug('<br>METHOD admin::update() - PARAMETER LIST : ', $param_array);
		
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

				frame_notices("Admin already exists in our database !!", "redfont");

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_admin_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_temp_admin_obj']);
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				//$this->assigned_modules['value'] = implode(",", $_REQUEST['modules']);
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Admin account details successfully updated !!", "greenfont");

				$ret_val = true;
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD admin::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function changepwd($id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD admin::changepwd() - PARAMETER LIST : ', $param_array);
		
		if($id > 0)
		{
			
			if($_SESSION['ses_admin_password'] != $_REQUEST['admin_pass'])
			{

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_admin_obj'][$ky] = $vl;
				
				frame_notices("The Given Password is Wrong !!", "redfont");
				
				$ret_val = false;
			}
			else
			{
				
				
				
				unset($_SESSION['ses_temp_admin_obj']);
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$this->assigned_modules['save_todb'] = "false";
				
				$resultset = database_manipulation::update_record($this, $cond);
				$_SESSION['ses_admin_password'] = $_REQUEST['admin_password'];
				frame_notices("Password Successfully updated !!", "greenfont");

				$ret_val = true;
				
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD admin::changepwd() - Return Value : ', $ret_val);
		
		return $ret_val;
	
	}
	
	/**********************************************************************************************

					Method To allow the user to login. 

	***********************************************************************************************/

	function login()
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD admin::login() - PARAMETER LIST : ', $param_array);

		$qry = "select " . $this->primary_fld . ", priority , admin_password,access_level from " . $this->cls_tbl . " where (project = 1 or project = 0) and admin_uname = '" . wrap_values($_REQUEST['admin_uname']) . "' and admin_password = '" . wrap_values($_REQUEST['admin_password']) . "'";
		
		$res = database_manipulation::execute_sql($qry);
		
		if($res[1] == 1)
		{//username and password are valid for that user...
			$data = mysql_fetch_object($res[0]);
			$fld = $this->primary_fld;
			$_SESSION['ses_admin_id'] = $data->$fld;
			$_SESSION['ses_admin_priority'] = $data->priority;
			$_SESSION['ses_admin_password'] = $data->admin_password;
			$_SESSION['ses_admin_access_level'] = $data->access_level;
			$ret_val = true;
		}
		else
		{//invalid username/password...
			frame_notices("Invalid Username/Password, Try Again !!","redfont");
			$ret_val = false;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD admin::login() - Return Value : ', $ret_val);

		return $ret_val;
		
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

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD admin::forgot_password() - PARAMETER LIST : ', $param_array);

		//22012007 - upon account creation send email to that user.. - Start
		
		$qry = "select " . $this->primary_fld . ", first_name, last_name, cust_password, email from " . $this->cls_tbl . " where email = '" . wrap_values($_REQUEST['email']) . "'";
		
		$res = database_manipulation::execute_sql($qry);
		
		if($res[1] > 0)
		{

		$eml_cls = new email();

		$data = mysql_fetch_object($res[0]);

		$eml_cls->email_cc = array();
		$eml_cls->email_bcc = array();

		$eml_cls->frame_email_body($this->fp_email_id, array("#first_name#", "#last_name#", "#email#", "#cust_password#", "#CN#"), array($data->first_name, $data->last_name, $data->email, $data->cust_password, $GLOBALS['site_config']['company_name']));
		
		$eml_cls->send_email($data->email);
		
		$ret_val = 1;
		
		}
		else
		{
			frame_notices("Admin does not exists in our database!!", "redfont");
			$ret_val = 0;
		}					
		//22012007 - upon account creation send email to that user.. - End
		
		$GLOBALS['logger_obj']->debug('<br>METHOD admin::forgot_password() - Return Value : ', $ret_val);

		return $ret_val;
		
	}
	
	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD admin::delete() - PARAMETER LIST : ', $param_array);
		
		if($rec_id > 0)
		{
			$primary_fld = $this->primary_fld;
			frame_notices("Admin account  successfully deleted  !!", "redfont");
			$ret_val=database_manipulation::delete_record($this, $rec_id);
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD admin::delete() - Return Value : ', $ret_val);

		return $ret_val;
	}


}





?>
