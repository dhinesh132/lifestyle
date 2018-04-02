<?php

class shipping_details extends database_manipulation
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

	var $id;

	var $zone;

	var $countries;

	var $shipping_table;
	
	function shipping_details()
	{

		$this->frm_name = "shipping_details_frm";

		$this->cls_tbl = "shipping_details";

		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";

		$this->unique_flds = "zone";

		$this->file_flds = "";

		$this->reference_tables = "";

		$this->primary_fld = "id";

		$this->attachment_h = "110";

		$this->attachment_w = "110";

		$this->attachment_s = "524288";

		$this->attachment_conditions = "shw";

		$this->image_copies = array();

		$this->upload_msgs = array();

		if(file_exists("uploads/category_files/"))
			$this->attachment_path = "uploads/category_files/";
		else
			$this->attachment_path = "../uploads/category_files/";

		$this->id = array("frm_fldname" => "id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->WeightFrom = array("frm_fldname" => "WeightFrom", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->WeightTo = array("frm_fldname" => "WeightTo", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->ZoneACountry = array("frm_fldname" => "ZoneACountry", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ZoneAPrice = array("frm_fldname" => "ZoneAPrice", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ZoneBCountry = array("frm_fldname" => "ZoneBCountry", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ZoneBPrice = array("frm_fldname" => "ZoneBPrice", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ZoneCCountry = array("frm_fldname" => "ZoneCCountry", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ZoneCPrice = array("frm_fldname" => "ZoneCPrice", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ZoneDCountry = array("frm_fldname" => "ZoneDCountry", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ZoneDPrice = array("frm_fldname" => "ZoneDPrice", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ZoneECountry = array("frm_fldname" => "ZoneECountry", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ZoneEPrice = array("frm_fldname" => "ZoneEPrice", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");;
		
		
	}


	/**********************************************************************************************

					Method To Register/Insert a user record.

	***********************************************************************************************/
	
	function insert()
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD shipping_details::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$ufld_arr = explode(",", $this->unique_flds);
		$chk_val = "";
		
		foreach($ufld_arr as $key => $val)

			$chk_val .= $_REQUEST[$val] . ",";

		$chk_val = substr($chk_val, 0, -1);
		
		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))
		{
		
			frame_notices("Zone already exists !!", "redfont");
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_shipping_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
		
			
			$resultset = database_manipulation::insert_record($this);
			
			frame_notices("Shipping details successfully added !!", "greenfont");
			
			unset($_SESSION['ses_temp_shipping_obj']);
			
			
			
			$ret_val = true;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD shipping_details::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD shipping_details::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD shipping_details::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccount Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD shipping_details::update() - PARAMETER LIST : ', $param_array);
		
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

				frame_notices("Zone already exists !!", "redfont");

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_shipping_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_temp_shipping_obj']);
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Shipping details successfully updated !!", "greenfont");

				$ret_val = true;
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD shipping_details::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD shipping_details::delete() - PARAMETER LIST : ', $param_array);
		
		
		if($rec_id > 0)
		{
			$primary_fld = $this->primary_fld;
			database_manipulation::delete_record($this, $rec_id);
			
			
		$GLOBALS['logger_obj']->debug('<br>METHOD shipping_details::delete() - Return Value : ', $ret_val);

		return $ret_val; 
	}
	} 

	
	
	
	
		
	
	
	
	
}

?>