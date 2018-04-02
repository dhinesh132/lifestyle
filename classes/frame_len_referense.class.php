<?php

class frame_len_referense extends database_manipulation
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

	var $frame_id;

	var $len_id;

	function frame_len_referense()
	{

		$this->frm_name = "frame_len_referense_frm";

		$this->cls_tbl = "frame_len_referense";

		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";

		$this->unique_flds = "frame_id";

		$this->file_flds = "";

		$this->reference_tables = "";

		$this->primary_fld = "frame_id";

		$this->attachment_h = "110";

		$this->attachment_w = "110";

		$this->attachment_s = "5524288";

		$this->attachment_conditions = "shw";

		$this->image_copies = array();

		$this->upload_msgs = array();
		
		$this->attachment_path = "";

		$this->frame_id = array("frm_fldname" => "frame_id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->len_id = array("frm_fldname" => "products", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

	}


	/**********************************************************************************************

					Method To Register/Insert a user record.

	***********************************************************************************************/
	
	function insert()
	{
		
		$GLOBALS['site_config']['debug'] = 1;
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD frame_len_referense::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$ufld_arr = explode(",", $this->unique_flds);
		$chk_val = "";
		
		foreach($ufld_arr as $key => $val)

			$chk_val .= $_REQUEST[$val] . ",";

		$chk_val = substr($chk_val, 0, -1);
		
		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))
		{
		
			frame_notices("Product already exists !!", "redfont");
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_relprod_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
			$resultset = database_manipulation::insert_record($this);
			
			unset($_SESSION['ses_temp_relprod_obj']);
			
			frame_notices("Related len_id successfully assigned !!", "greenfont");

			$ret_val = true;
		}
		exit;
		
		$GLOBALS['logger_obj']->debug('<br>METHOD frame_len_referense::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD frame_len_referense::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD frame_len_referense::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccount Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id)
	{
		//$GLOBALS['site_config']['debug'] = 1;
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD frame_len_referense::update() - PARAMETER LIST : ', $param_array);
		
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

				frame_notices("Product already exists !!", "redfont");

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_relprod_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_temp_relprod_obj']);
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Lens type assigned to selected frame details successfully updated !!", "greenfont");

				$ret_val = true;
			}
			
		}
		//exit;

		$GLOBALS['logger_obj']->debug('<br>METHOD frame_len_referense::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete_record($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD frame_len_referense::delete() - PARAMETER LIST : ', $param_array);
		
		if($rec_id > 0)
		{
			$primary_fld = $this->primary_fld;
			database_manipulation::delete_record($this, $rec_id);
			frame_notices("Related len_id group successfully deleted !!", "greenfont");
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD frame_len_referense::delete() - Return Value : ', $ret_val);

		return $ret_val; 
	
	} 

}

?>