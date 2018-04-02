<?php
//for email
if(file_exists("classes/email.class.php")){
	require_once("classes/email.class.php");
	require_once("classes/subscriber.class.php");
}
else if(file_exists("./classes/email.class.php")){
	require_once("./classes/email.class.php");
	require_once("./classes/subscriber.class.php");
}
else if(file_exists("../classes/email.class.php")){
	require_once("../classes/email.class.php");
	require_once("../classes/subscriber.class.php");
}
		

class customers extends database_manipulation

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
		
		var $cust_id;
			
		var $cust_firstname;
			
		var $cust_lastname;
		
		var $cust_chinesename;
		
		var $cust_email;
		
		var $cust_password;		
	
		var $cust_recom_by;	
	
		var $cust_address1;
		
		var $cust_address2;
		
		var $cust_city;
		
		var $cust_state; 
		
		var $cust_country;
		
		var $cust_zip;
				
		var $cust_phone;
	
		var $cust_landline;
		
		var $cust_office;
	  
		var $cust_ic;
		
		var $cust_dob_day; 
		
		var $cust_dob_month; 
		
		var $cust_dob_year; 
	
		var $cust_dob;
		
		var $cust_profession;

		var $cust_income;
		
		var $cust_register_from;
	
		var $cust_status;
		
   	    var $cust_create_datetime;
		
		var $cust_modify_datetime;
		
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
	
function customers()
	{
		
		$this->frm_name = 'customer_frm';
		
		$this->cls_tbl = 'customer_master';
		
		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1";
		
		$this->unique_flds ='cust_email';
		
		$this->file_flds = '';
		
		$this->primary_fld = 'cust_id';
		
		//for email
		$this->register_email_id = 3;

		$this->fp_email_id = 4;

	    //for email
	     $this->cust_id = array('frm_fldname' => 'cust_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
	
		$this->cust_firstname = array('frm_fldname' => 'cust_firstname', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_lastname = array('frm_fldname' => 'cust_lastname', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_chinesename = array('frm_fldname' => 'cust_chinesename', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' =>'');
		$this->cust_autocode = array('frm_fldname' => 'cust_autocode', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' =>'');
		
		$this->cust_email = array('frm_fldname' => 'cust_email', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_password = array('frm_fldname' => 'cust_password', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_recom_by = array('frm_fldname' => 'cust_recom_by', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_address1 = array('frm_fldname' => 'cust_address1', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_address2 = array('frm_fldname' => 'cust_address2', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_unit = array('frm_fldname' => 'cust_unit', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_building = array('frm_fldname' => 'cust_building', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_city = array('frm_fldname' => 'cust_city', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_state = array('frm_fldname' => 'cust_state', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => ''); 
		
		$this->cust_country = array('frm_fldname' => 'cust_country', 'fld_type' => 'str', 'frm_fld_type' => 'select', 'save_todb' => 'false','value' => '');

		$this->cust_zip = array('frm_fldname' => 'cust_zip', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_phone = array('frm_fldname' => 'cust_phone', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
	
		$this->cust_landline = array('frm_fldname' => 'cust_landline', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
				
		$this->cust_office = array('frm_fldname' => 'cust_office', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_ic = array('frm_fldname' => 'cust_ic', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');

		$this->cust_dob_day = array('frm_fldname' => 'cust_dob_day', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_dob_month = array('frm_fldname' => 'cust_dob_month', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');	
		
		$this->cust_dob_month = array('frm_fldname' => 'cust_dob_month', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');	
		
		$this->cust_dob_year = array('frm_fldname' => 'cust_dob_year', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');
		
		$this->cust_dob = array('frm_fldname' => 'cust_dob', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => '');				
		
		$this->cust_profession = array('frm_fldname' => 'cust_profession', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => ''); 
		$this->cust_income = array('frm_fldname' => 'cust_income', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => ''); 	

        $this->cust_username = array('frm_fldname' => 'cust_username', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false','value' => ''); 
		
		$this->cust_register_from = array('frm_fldname' => 'cust_register_from', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false','value' => ''); 
		
		 $this->cust_newsletter = array('frm_fldname' => 'cust_newsletter', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false','value' => ''); 	
		 
		 $this->cust_terms_agreed = array('frm_fldname' => 'cust_terms_agreed', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false','value' => ''); 	
		 		
	    $this->cust_status = array('frm_fldname' => 'cust_status', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false','value' => ''); 	

	    $this->cust_added_by = array('frm_fldname' => 'cust_added_by', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false','value' => '');	
		
	    $this->cust_create_datetime = array('frm_fldname' => 'cust_create_datetime', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false','value' => '');
		
		$this->cust_modify_datetime = array('frm_fldname' => 'cust_modify_datetime', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false','value' => ''); 
		

		//parameters for search concept - Start
		
		$this->match_case = "no";
		
		$this->search_types = array(
		
		"contains" => array("tbl_fld_name" => "cont_list", "tbl_fld_value" => "contains_keyword"),
		
		"startswith" => array("tbl_fld_name" => "stw_list", "tbl_fld_value" => "stw_keyword"),
		
		"endswith" => array("tbl_fld_name" => "endw_list", "tbl_fld_value" => "endw_keyword"),
		
		"equalto" => array("tbl_fld_name" => "equal_list", "tbl_fld_value" => "equal_keyword"),
		
		"lessthan" => array("tbl_fld_name" => "lt_list", "tbl_fld_value" => "lt_keyword"),
		
		"greaterthan" => array("tbl_fld_name" => "gt_list", "tbl_fld_value" => "gt_keyword"),
		
		"between" => array("tbl_fld_name" => "bet_list", "tbl_fld_value_frm" => "bet_frm_keyword", "tbl_fld_value_to" => "bet_to_keyword"),
		
		"sort_by" => array("tbl_fld_name" => "sortby", "tbl_fld_value" => "sortby_val"),
		
		"save_todb" => "false"
		
		);
		
		$this->get_search_types = array("save_todb" => "false");
		
		$this->get_search_types[0] = array("search_condition" => "depend_object_setting");

		/* Second form of searching 
		
		$this->get_search_types[1] = array("search_condition" => "depend_request", "search_condition_tbl_fld_name" => "srch_tbl_fld", "search_condition_fld_name" => "srch_condition", "search_condition_tbl_fld_value" => "srch_tbl_fld_value");
		
		Second form of searching */		
		
		$this->search_sql = "select " . $this->cls_tbl . ".* from " . $this->cls_tbl . " where 1 = 1 ";

		$this->search_cond = "and";
		
		$this->srch_ses_val = "ses_cust_master_srch_vars";
		
		$this->srch_ses_qry_str = "ses_cust_master_srch_qry";
		
		if(!isset($_SESSION[$this->searched_ses_val]))
		$_SESSION[$this->searched_ses_val] = 0;
		
		//parameters for search concept - End
	
	
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
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$ufld_arr = explode(",", $this->unique_flds);
		$chk_val = "";
		
		foreach($ufld_arr as $key => $val)

			$chk_val .= $_REQUEST[$val] . ",";

		$chk_val = substr($chk_val, 0, -1);
		
		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))
		{
		
			frame_notices("Customer details already exists.Please use another email!!", "redfont");
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_cust_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
			if(empty($_REQUEST['cust_newsletter']) ||$_REQUEST['cust_newsletter'] <=0 ){
					$this->cust_newsletter['save_todb'] = "true";
					$this->cust_newsletter['value'] = "0";
					
					$delete_qry = "DELETE FROM".$sub_obj->cls_tbl." WHERE email='".$_REQUEST['cust_email']."'";
					$GLOBALS['db_con_obj']->execute_sql($delete_qry,"delete");
			}
			else{
				$check_id = $GLOBALS['db_con_obj']->fetch_field("subscriber","id","email='".$_REQUEST['cust_email']."'");
				if($check_id <=0){
					$sub_obj = new subscriber();
					
					$name = $_REQUEST['cust_firstname']." " .$_REQUEST['cust_lastname'];
					
					$sub_obj->name['save_todb']='true';
					$sub_obj->email['save_todb']='true';
					$sub_obj->ContactNo['save_todb']='true';
					$sub_obj->date_entered['save_todb']='true';
					$sub_obj->date_modified['save_todb']='true';
					
					$sub_obj->name['value']=$name;
					$sub_obj->email['value']=$_REQUEST['cust_email'];
					$sub_obj->ContactNo['value']=$_REQUEST['cust_phone'];
					$sub_obj->date_entered['value']=date("Y-m-d H:i:s");
					$sub_obj->date_modified['value']=date("Y-m-d H:i:s");
					$sub_obj->insert();
				}
			}
				
			$resultset = database_manipulation::insert_record($this);
			
			unset($_SESSION['ses_temp_cust_obj']);
			
			$eml_cls = new email();
			$obj = set_values($this);
			//print_r($resultset);
			
			//email class
			//$eml_cls->frame_email_body($this->register_email_id, array("#first_name#", "#last_name#","#username#","#password#","#CN#"), array($obj->cust_firstname['value'], $obj->cust_lastname['value'], $obj->cust_email['value'], $obj->cust_password['value'],$GLOBALS['site_config']['company_name']));
			
			$subject = "Member Register Confirmation From ".$GLOBALS['site_config']['company_name'];
			include("emails/registration_email.php");
			$Message = $content;
			$to_email = $obj->cust_email['value'];
			$from_email = "roreply@wayonnet.com";
			$eml_cls->pear_mail($subject,$Message,$to_email,$from_email);
			
			frame_notices("Customer account successfully created !!", "greenfont");

			$ret_val = true;
		}
		
		
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccount Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::update() - PARAMETER LIST : ', $param_array);
		
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

				frame_notices("Customer name already exists !!", "redfont");

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_cust_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{
	
				unset($_SESSION['ses_temp_cust_obj']);
				
				if($_REQUEST['cust_email'] ==''){
						$cust_email = $GLOBALS['db_con_obj']->fetch_field($this->cls_tbl,"cust_email","cust_id=".$id);
					}
					else{
					  $cust_email = $_REQUEST['cust_email'];
					}
				
				if(empty($_REQUEST['cust_newsletter']) ||$_REQUEST['cust_newsletter'] <=0 ){
					$this->cust_newsletter['save_todb'] = "true";
					$this->cust_newsletter['value'] = "0";
					
					
					$sub_obj = new subscriber();
					$delete_qry = "DELETE FROM ".$sub_obj->cls_tbl." WHERE email='".$cust_email."'";
					$GLOBALS['db_con_obj']->execute_sql($delete_qry,"delete");
			}
			else{
				$check_id = $GLOBALS['db_con_obj']->fetch_field("subscriber","id","email='".$cust_email."'");
				if($check_id <=0){
					$sub_obj = new subscriber();
					
					$name = $_REQUEST['cust_firstname']." " .$_REQUEST['cust_lastname'];
					
					$sub_obj->name['save_todb']='true';
					$sub_obj->email['save_todb']='true';
					$sub_obj->ContactNo['save_todb']='true';
					$sub_obj->date_entered['save_todb']='true';
					$sub_obj->date_modified['save_todb']='true';
					
					$sub_obj->name['value']=$name;
					$sub_obj->email['value']=$cust_email;
					$sub_obj->ContactNo['value']=$_REQUEST['cust_phone'];
					$sub_obj->date_entered['value']=date("Y-m-d H:i:s");
					$sub_obj->date_modified['value']=date("Y-m-d H:i:s");
					$sub_obj->insert();
				}
			}
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Customer account successfully updated !!", "greenfont");

				$ret_val = true;
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD customers::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete_record($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::delete() - PARAMETER LIST : ', $param_array);
		
		if($rec_id > 0)
		{
			$primary_fld = $this->primary_fld;
			database_manipulation::delete_record($this, $rec_id);
			frame_notices("Customer account details successfully deleted !!", "greenfont");
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::delete() - Return Value : ', $ret_val);

		return $ret_val; 
	
	} 

	/**********************************************************************************************

					Method To email the password to the user. Forgot password feature.

	***********************************************************************************************/

	function forgot_password()
	{
		
		//$GLOBALS['site_config']['debug'] =1;
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::forgot_password() - PARAMETER LIST : ', $param_array);

		//22012007 - upon account creation send email to that user.. - Start
		
		$qry = "select " . $this->primary_fld . ", cust_firstname, cust_lastname, cust_password, cust_email from " . $this->cls_tbl . " where cust_email = '" . wrap_values($_REQUEST['email']) . "' ";
		
		$res = database_manipulation::execute_sql($qry);
		
		if($res[1] > 0)
		{

		$eml_cls = new email();

		$data = mysql_fetch_object($res[0]);

		/*$eml_cls->email_cc = array();
		$eml_cls->email_bcc = array();

		$eml_cls->frame_email_body($this->fp_email_id, array("#first_name#", "#last_name#", "#email#", "#cust_password#", "#CN#"), array($data->cust_firstname, $data->cust_lastname, $data->cust_email, $data->cust_password, $GLOBALS['site_config']['company_name']));
		
		$eml_cls->send_email($data->cust_email); */
		    frame_notices("The password will be sent to your email shortly", "greenfont");
		    $subject = "Password Retrieval From ".$GLOBALS['site_config']['company_name'];
			include("emails/password_email.php");
			$Message = $content;
			$to_email = $data->cust_email;
			$from_email = "roreply@wayonnet.com";
			$eml_cls->pear_mail($subject,$Message,$to_email,$from_email);
		
		$ret_val = 1;
		
		}
		else
		{
			frame_notices("Email/Username does not exists in our database!!", "redfont");
			$ret_val = 0;
		}					
		//22012007 - upon account creation send email to that user.. - End
		
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::forgot_password() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To allow the user to login. 

	***********************************************************************************************/

	function login()
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::login() - PARAMETER LIST : ', $param_array);




		$qry = "select " . $this->primary_fld . " from " . $this->cls_tbl . " where cust_email = '" . wrap_values($_REQUEST['cust_email']) . "' and cust_password = '" . wrap_values($_REQUEST['cust_password']) . "' and cust_status=1";
		
		$res = database_manipulation::execute_sql($qry);
		
		if($res[1] == 1)
		{//username and password are valid for that user...
			$data = mysql_fetch_object($res[0]);
			$fld = $this->primary_fld;
			$_SESSION['ses_customer_id'] = $data->$fld;
			$ret_val = true;
		}
		else
		{//invalid username/password...
			frame_notices("Invalid username / Password, please try again!","redfont");
			$ret_val = false;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::login() - Return Value : ', $ret_val);

		return $ret_val;
		
	}
	
/**********************************************************************************************************************

									Searching for customer

***********************************************************************************************************************/

	function search_query()
	{
	
		
		
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD customer_master::search_qurey() - PARAMETER LIST : ', $param_array);
		
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_cust_srch_vars'][$ky] = $vl;
			
			$qry = "select cust_id, cust_firstname, cust_lastname, cust_username, cust_email, cust_create_datetime,cust_phone,cust_status from " . $this->cls_tbl." where 1 = 1";
			
			
			$use_cond = " and ";
		
			$join_qry = " and (";
			
			$join_qry_st = 0;
			
			//search with order status - Start
			if($_SESSION['ses_cust_srch_vars']['cust_status'] !='')
			{
				$join_qry .= "cust_status = ".stripslashes($_SESSION['ses_cust_srch_vars']['cust_status']);
				$join_qry_st = 1;
			}		
		
			if(!empty($_SESSION['ses_cust_srch_vars']['register_from']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
		
				$join_qry .= " cust_register_from = '".stripslashes($_SESSION['ses_cust_srch_vars']['register_from'])."'";
		
				$join_qry_st = 1;
			}
		
			//search with Buyer name - Start
			if(!empty($_SESSION['ses_cust_srch_vars']['filter_srch_val']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
		
				$join_qry .= " (lower(" . $_SESSION['ses_cust_srch_vars']['filter_column'] . ") " . stripslashes(str_replace("#val#",strtolower($_SESSION['ses_cust_srch_vars']['filter_srch_val']), $_SESSION['ses_cust_srch_vars']['Nametype'])) . ")";
		
				$join_qry_st = 1;
			}
			
			if($join_qry_st != 1)
			$join_qry .= "1=1";
			
			$join_qry .= ")";
		
			//add sorting to the query - Start
			if(!empty($_SESSION['ses_cust_srch_vars']['sort_column']))
			{
				$join_qry .= " order by " . $_SESSION['ses_cust_srch_vars']['sort_column'] ;
			}
			//add sorting to the query - End
			
		
			$final_qry = $qry . $join_qry;
			
			
			$_SESSION['ses_cust_srch_qry'] = $final_qry;
			return $final_qry;
			
		$GLOBALS['logger_obj']->debug('<br>METHOD customer_master::search_qurey() - Return Value : ', $ret_val);
		return $ret_val;	
		
	
	}
	
	/**********************************************************************************************************************

									Update password for customer

	***********************************************************************************************************************/

	
	function update_pwd($id)
	{
		
		//$GLOBALS['site_config']['debug'] =1;
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::forgot_password() - PARAMETER LIST : ', $param_array);

		//22012007 - upon account creation send email to that user.. - Start
		
		$qry = "select " . $this->primary_fld . ", cust_id from " . $this->cls_tbl . " where cust_password = '" . wrap_values($_REQUEST['old_password']) . "' ";
		
		$res = database_manipulation::execute_sql($qry);
		
		if($res[1] > 0)
		{

			
					$this->cust_password['save_todb'] = "true";
					$this->cust_password['value'] = wrap_values($_REQUEST['password']);
				
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("New password successfully updated !!", "greenfont");

				$ret_val = true;
		
		}
		else
		{
			frame_notices("Password does not exists in our database!!", "redfont");
			$ret_val = 0;
		}					
		//22012007 - upon account creation send email to that user.. - End
		
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::forgot_password() - Return Value : ', $ret_val);

		return $ret_val;
		
	}
	
	
	function cust_activate(){
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::forgot_password() - PARAMETER LIST : ', $param_array);

		//22012007 - upon account creation send email to that user.. - Start
		
		
		$qry = "select " . $this->primary_fld . " from " . $this->cls_tbl . " where cust_autocode = '" . wrap_values($_REQUEST['code']) . "' and cust_id = '" . wrap_values($_REQUEST['id']) . "'";
		
		$res = database_manipulation::execute_sql($qry);
		
		if($res[1] == 1)
		{//username and password are valid for that user...
			$update = "UPDATE " . $this->cls_tbl . " set cust_status=1 WHERE cust_id=".$_REQUEST['id'];
			$GLOBALS['db_con_obj']->execute_sql($update, "update");
			frame_notices("Your account successfully activated. Please login!!","redfont");
			$ret_val = true;
		}
		else
		{//invalid username/password...
			frame_notices("Sorry. Invalid data !!","redfont");
			$ret_val = false;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD customers::forgot_password() - Return Value : ', $ret_val);

		return $ret_val;
		
	}	
	

}

?>																									