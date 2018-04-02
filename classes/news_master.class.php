<?php

class news_master extends database_manipulation

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
		
		var $heading;
		
		var $news;
		
		var $status;
		
		var $date_entered;
		
		var $date_modified;
				
	
function news_master()
	{
		
		$this->frm_name = 'news_master_frm';
		
		$this->cls_tbl = 'news_master';
		
		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1";
		
		$this->unique_flds = 'heading,news';
		
		$this->file_flds = '';
		
		$this->primary_fld = 'id';
		
		//$this->register_email_id = 1;

		//$this->fp_email_id = 2;
	
	
	$this->id = array('frm_fldname' => 'id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');
	
	$this->heading = array('frm_fldname' => 'heading', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'String','minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter the news_master name !'), 'value' => '');
	
	$this->news = array('frm_fldname' => 'news', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'String','minlen' => '255', 'maxlen' => '255', 'msg' => 'Enter the news_master code!'), 'value' => '');
	
	$this->status = array("frm_fldname" => "status", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
	
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
		$GLOBALS['logger_obj']->debug('<br>METHOD news_master::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$ufld_arr = explode(",", $this->unique_flds);
		$chk_val = "";
		
		foreach($ufld_arr as $key => $val)
			{
			$news_master_ex[] = database_manipulation::record_exists($this->cls_tbl, $val, $_REQUEST[$val]);
			$chk_val .= $_REQUEST[$val] . ",";
			}
		$news_master_n_e = $news_master_ex[0];
		$news_master_c_e = $news_master_ex[1];
		
		$chk_val = substr($chk_val, 0, -1);
		
		
		//if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val,'','',"insert",'or'))
		 if (($news_master_n_e) ||($news_master_c_e))
		{
		if (($news_master_n_e ) && ($news_master_c_e ))
		frame_notices("News name and news_master code already exists  !!", "redfont");
		else if ($news_master_n_e ) 
		frame_notices("News name already exists  !!", "redfont");
		else if ($news_master_c_e )
		frame_notices("News code already exists  !!", "redfont");
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_news_master_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
			$resultset = database_manipulation::insert_record($this);
			
			unset($_SESSION['ses_temp_news_master_obj']);
			
			frame_notices("News successfully created!!", "greenfont");

			$ret_val = true;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD news_master:insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD news_master::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD news_master::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccount Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD news_master::update() - PARAMETER LIST : ', $param_array);
		
		if($id > 0)
		{
			//need to check the uniqueness for username and email...
			
			$ufld_arr = explode(",", $this->unique_flds);
			$chk_val = "";
			
			foreach($ufld_arr as $key => $val)
				{
			$news_master_ex[] = database_manipulation::record_exists($this->cls_tbl, $val, $_REQUEST[$val],$this->primary_fld, $id,"update");
				$chk_val .= $_REQUEST[$val] . ",";
			}
			$news_master_n_e = $news_master_ex[0];
			$news_master_c_e = $news_master_ex[1];
			
			$chk_val = substr($chk_val, 0, -1);
			
		if (($news_master_n_e) ||($news_master_c_e))
		{
		if (($news_master_n_e ) && ($news_master_c_e ))
		frame_notices("News name and news_master code already exists  !!", "redfont");
		else if ($news_master_n_e ) 
		frame_notices("News name already exists  !!", "redfont");
		else if ($news_master_c_e )
		frame_notices("News code already exists  !!", "redfont");

				//frame_notices("News already exists !!", "redfont");

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_news_master_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_temp_news_master_obj']);
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("News successfully updated !!", "greenfont");

				$ret_val = true;
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD news_master::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD news_master::delete() - PARAMETER LIST : ', $param_array);
		
		if($rec_id > 0)
		{
			
				frame_notices("News deleted !!", "redfont");
				database_manipulation::delete_record($this, $rec_id);
			
			
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD news_master::delete() - Return Value : ', $ret_val);

		return $ret_val;

	}
	
	

	


}

?>																									