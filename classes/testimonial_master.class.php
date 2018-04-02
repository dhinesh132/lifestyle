<?php
if(file_exists("classes/email.class.php"))
	require_once("classes/email.class.php");
else if(file_exists("./classes/email.class.php"))
	require_once("./classes/email.class.php");
else if(file_exists("../classes/email.class.php"))
	require_once("../classes/email.class.php");
	
class testimonial_master extends database_manipulation
{

	var $frm_name;

	var $cls_tbl;

	var $cls_sql;

	var $unique_flds;

	var $file_flds;

	var $reference_tables;

	var $primary_fld;

	var $attachment_h;

	var $attachment_w;

	var $attachment_s;

	var $attachment_conditions;

	var $image_copies;

	var $upload_msgs;

	var $attachment_path;

	var $testimonial_id;

	var $testimonial_title;

	var $testimonial_text;

	var $testimonial_status;
	
	var $posted_by;
	
	var $posted_usrtyp;
	
	var $date_entered;

	var $date_modified;

	function testimonial_master()
	{

		$this->frm_name = "testimonial_master_frm";

		$this->cls_tbl = "testimonial_master";

		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";

		$this->unique_flds = "";

		$this->file_flds = "";

		$this->reference_tables = "";

		$this->primary_fld = "testimonial_id";

		$this->attachment_h = "110";

		$this->attachment_w = "110";

		$this->attachment_s = "524288";

		$this->attachment_conditions = "shw";

		$this->image_copies = array();

		$this->upload_msgs = array();
		
		$this->register_email_id = 32;

		$this->testimonial_id = array("frm_fldname" => "testimonial_id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");


		$this->testimonial_text = array("frm_fldname" => "testimonial_text", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->posted_by = array("frm_fldname" => "posted_by", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->address = array("frm_fldname" => "address", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->testimonial_status = array("frm_fldname" => "testimonial_status", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		

		$this->date_entered = array("frm_fldname" => "date_entered", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->date_modified = array("frm_fldname" => "date_modified", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

	}


	/**********************************************************************************************

					Method To Register/Insert a user record.

	***********************************************************************************************/
	
	function insert()
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD testimonial_maser::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$ufld_arr = explode(",", $this->unique_flds);
		$chk_val = "";
		
		foreach($ufld_arr as $key => $val)

			$chk_val .= $_REQUEST[$val] . ",";

		$chk_val = substr($chk_val, 0, -1);
		
		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))
		{
		
			frame_notices("Testimonial title already exists !!", "redfont");
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_testimonial_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
			$resultset = database_manipulation::insert_record($this);
			
			unset($_SESSION['ses_temp_testimonial_obj']);
			
			$eml_cls = new email();
			$obj = set_values($this);
			
			//email class
			$eml_cls->frame_email_body($this->register_email_id, array("#name#", "#comments#", "#CN#"), array($obj->posted_by['value'], $obj->testimonial_text['value'],$GLOBALS['site_config']['company_name']));
			
			$eml_cls->send_email($GLOBALS['site_config']['admin_email']);
			
			
			$ret_val = true;
			
			frame_notices("Testimonial added successfully. Testimonial will be displayed in site once admin approves it !!", "greenfont");
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD testimonial_maser::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD testimonial_maser::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD testimonial_maser::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccount Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD testimonial_maser::update() - PARAMETER LIST : ', $param_array);
		
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

				frame_notices("Testimonial title already exists !!", "redfont");

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_testimonial_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_temp_testimonial_obj']);
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Testimonial details successfully updated !!", "greenfont");

				$ret_val = true;
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD testimonial_maser::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD testimonial_maser::delete() - PARAMETER LIST : ', $param_array);
		
		
		if($rec_id > 0)
		{
			$primary_fld = $this->primary_fld;
			
			//for delete message box for respective testimonial.
			
			database_manipulation::delete_record($this, $rec_id);
			frame_notices("Testimonial details successfully deleted !!", "greenfont");
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD testimonial_maser::delete() - Return Value : ', $ret_val);

		return $ret_val; 
	
	} 

		
	

}

?>