<?php

class country extends database_manipulation

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
		
		var $countryid;
		
		var $countryname;
		
		var $countrycode;
		
		var $country_status;
		
		var $created_datetime;
		
		var $modify_datetime;
				
	
function country()
	{
		
		$this->frm_name = 'country_frm';
		
		$this->cls_tbl = 'country';
		
		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1";
		
		$this->unique_flds = 'countryname,countrycode';
		
		$this->file_flds = '';
		
		$this->primary_fld = 'countryid';
		
		//$this->register_email_id = 1;

		//$this->fp_email_id = 2;
	
	
	$this->countryid = array('frm_fldname' => 'countryid', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');
	
	$this->countryname = array('frm_fldname' => 'countryname', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'String','minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter the country name !'), 'value' => '');
	
	$this->countrycode = array('frm_fldname' => 'countrycode', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'String','minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter the country code!'), 'value' => '');
	
	$this->country_status = array('frm_fldname' => 'country_status', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'value' => '');
	
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
		$GLOBALS['logger_obj']->debug('<br>METHOD country::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$ufld_arr = explode(",", $this->unique_flds);
		$chk_val = "";
		
		foreach($ufld_arr as $key => $val)
			{
			$country_ex[] = database_manipulation::record_exists($this->cls_tbl, $val, $_REQUEST[$val]);
			$chk_val .= $_REQUEST[$val] . ",";
			}
		$country_n_e = $country_ex[0];
		$country_c_e = $country_ex[1];
		
		$chk_val = substr($chk_val, 0, -1);
		
		
		//if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val,'','',"insert",'or'))
		 if (($country_n_e) ||($country_c_e))
		{
		if (($country_n_e ) && ($country_c_e ))
		frame_notices("Country name and country code already exists  !!", "redfont");
		else if ($country_n_e ) 
		frame_notices("Country name already exists  !!", "redfont");
		else if ($country_c_e )
		frame_notices("Country code already exists  !!", "redfont");
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_country_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
		
			$resultset = database_manipulation::insert_record($this);
			
			unset($_SESSION['ses_temp_country_obj']);
			
			frame_notices("Country successfully created!!", "greenfont");

			$ret_val = true;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD country:insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD country::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD country::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccount Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD country::update() - PARAMETER LIST : ', $param_array);
		
		if($id > 0)
		{
			//need to check the uniqueness for username and email...
			
			$ufld_arr = explode(",", $this->unique_flds);
			$chk_val = "";
			
			foreach($ufld_arr as $key => $val)
				{
			$country_ex[] = database_manipulation::record_exists($this->cls_tbl, $val, $_REQUEST[$val],$this->primary_fld, $id,"update");
				$chk_val .= $_REQUEST[$val] . ",";
			}
			$country_n_e = $country_ex[0];
			$country_c_e = $country_ex[1];
			
			$chk_val = substr($chk_val, 0, -1);
			
		if (($country_n_e) ||($country_c_e))
		{
		if (($country_n_e ) && ($country_c_e ))
		frame_notices("Country name and country code already exists  !!", "redfont");
		else if ($country_n_e ) 
		frame_notices("Country name already exists  !!", "redfont");
		else if ($country_c_e )
		frame_notices("Country code already exists  !!", "redfont");

				//frame_notices("Country already exists !!", "redfont");

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_country_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_temp_country_obj']);
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Country successfully updated !!", "greenfont");

				$ret_val = true;
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD country::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD country::delete() - PARAMETER LIST : ', $param_array);
		
		if($rec_id > 0)
		{
			$primary_fld = $this->primary_fld;
			
			if(file_exists("../classes/state.class.php"))
				
				require_once("../classes/state.class.php");
			
			else
			
				require_once("classes/state.class.php");
				
			$state_obj = new state();
			
			if(database_manipulation::record_exists($state_obj->cls_tbl, "countryid", $rec_id))
		{
				frame_notices("State for this country should be deleted before deleting it !!", "redfont");
			}
			else
			{
				frame_notices("Country deleted !!", "redfont");
				database_manipulation::delete_record($this, $rec_id);
			}
			
			
			
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD country::delete() - Return Value : ', $ret_val);

		return $ret_val;

	}
	
	

	


}

?>																									