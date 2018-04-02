<?php

class functions extends database_manipulation
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

	var $FunId;

	var $FunName;

	var $FunStatus;

	function functions()
	{

		$this->frm_name = "functions_frm";

		$this->cls_tbl = "functions";

		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";

		$this->unique_flds = "FunName";

		$this->file_flds = "";

		$this->reference_tables = "";

		$this->primary_fld = "FunId";

		$this->attachment_h = "110";

		$this->attachment_w = "110";

		$this->attachment_s = "524288";

		$this->attachment_conditions = "shw";

		$this->image_copies = array();

		$this->upload_msgs = array();

		if(file_exists("uploads/static_files/"))
			$this->attachment_path = "uploads/static_files/";
		else
			$this->attachment_path = "../uploads/static_files/";

		$this->FunId = array("frm_fldname" => "FunId", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->EnName = array("frm_fldname" => "EnName", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->UniqueKey = array("frm_fldname" => "UniqueKey", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->FunStatus = array("frm_fldname" => "FunStatus", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->MetaTitle = array("frm_fldname" => "MetaTitle", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->MetaKey = array("frm_fldname" => "MetaKey", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->MetaDesc = array("frm_fldname" => "MetaDesc", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->DisplayOrder = array("frm_fldname" => "DisplayOrder", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ChName = array("frm_fldname" => "ChName", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

	}

	
	function fetch_record($id, $FunStatus_chk="-1")
	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD functions::fetch_record() - PARAMETER LIST : ', $param_array);
			
			if($FunStatus_chk > -1 && $_REQUEST['admin'] != 1)
				$condition = $this->primary_fld . " = '" . $id . "' and FunStatus = '" . $FunStatus_chk . "'";
			else
				$condition = $this->primary_fld . " = '" . $id . "'";
	
			$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
	
		$GLOBALS['logger_obj']->debug('<br>METHOD functions::fetch_record() - Return Value : ', $res);

		return $res;

	}
	
	function fetch_pages($pl_id)
	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD functions::fetch_pages() - PARAMETER LIST : ', $param_array);
			
		$condition = "pl_id = '" . $pl_id . "' and FunStatus='1'";

		$res = database_manipulation::fetch_flds($this->cls_tbl, "FunId,FunName", $condition);
	
		$GLOBALS['logger_obj']->debug('<br>METHOD functions::fetch_pages() - Return Value : ', $res);

		return $res;

	}
	
	
		
		/**********************************************************************************************


					Method To Register/Insert a user record.

	***********************************************************************************************/

	function insert()

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD functions::insert() - PARAMETER LIST : ', $param_array);

		$ufld_arr = explode(",", $this->unique_flds);

		$chk_val = "";

		foreach($ufld_arr as $key => $val)

			$chk_val .= $_REQUEST[$val] . ",";

		$chk_val = substr($chk_val, 0, -1);

		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))

		{

			frame_notices("Function already exists!!", "redfont");

			foreach($_REQUEST as $ky => $vl)

			$_SESSION['ses_temp_fun_obj'][$ky] = $vl;

			$ret_val = false;

		}

		else

		{
			$order = $GLOBALS['db_con_obj']->fetch_field($this->cls_tbl,"DisplayOrder","1=1 order by DisplayOrder desc limit 0,1");
			$this->DisplayOrder['save_todb'] = 'true';
			$displayorder = $order+1;
			$this->DisplayOrder['value'] =$displayorder;
			if(isset($_REQUEST['UniqueKey_temp']) && $_REQUEST['UniqueKey_temp'] !=''){

				$uniquekey = GenerateUniqueKey($_REQUEST['UniqueKey_temp'],$this->cls_tbl );		

				
			}else{
				$uniquekey = GenerateUniqueKey($_REQUEST['EnName'],$this->cls_tbl );

			}
			
			
			$this->UniqueKey['save_todb'] = 'true';

			$this->UniqueKey['value'] =$uniquekey;
			$resultset = database_manipulation::insert_record($this);

			unset($_SESSION['ses_temp_fun_obj']);
			
			frame_notices("Function successfully added !!", "greenfont");

			$ret_val = true;

		}

		$GLOBALS['logger_obj']->debug('<br>METHOD functions::insert() - Return Value : ', $ret_val);

		return $ret_val;

	}


	/**********************************************************************************************
					Method To update details of a particular user. 

					(Myaccount Edit Purpose - We need to update the details altered by the user).
	***********************************************************************************************/

	function update($id)

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD functions::update() - PARAMETER LIST : ', $param_array);

		if($id > 0)

		{

			$ufld_arr = explode(",", $this->unique_flds);

			$chk_val = "";

			foreach($ufld_arr as $key => $val)

				$chk_val .= $_REQUEST[$val] . ",";
			$chk_val = substr($chk_val, 0, -1);

			if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val, $this->primary_fld, $id,"update"))

			{
				frame_notices("Function already exists!!", "redfont");
				foreach($_REQUEST as $ky => $vl)

				$_SESSION['ses_temp_fun_obj'][$ky] = $vl;
				$ret_val = false;

			}

			else

			{

			unset($_SESSION['ses_temp_fun_obj']);
			if(isset($_REQUEST['UniqueKey_temp']) && $_REQUEST['UniqueKey_temp'] !=''){

				$uniquekey = GenerateUniqueKey($_REQUEST['UniqueKey_temp'],$this->cls_tbl );		

				
			}else{
				$uniquekey = GenerateUniqueKey($_REQUEST['EnName'],$this->cls_tbl );

			}
			
			
			$this->UniqueKey['save_todb'] = 'true';

			$this->UniqueKey['value'] =$uniquekey;

				$cond = $this->primary_fld . " = '" . $id . "'";
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Function successfully updated !!", "greenfont");
				$ret_val = true;

			}

		}

		$GLOBALS['logger_obj']->debug('<br>METHOD functions::update() - Return Value : ', $ret_val);

		return $ret_val;

	}

	/**********************************************************************************************

				Method To delete details of a particular user. 

					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/

	function delete($rec_id)

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD functions::delete() - PARAMETER LIST : ', $param_array);
		if($rec_id > 0)

		{
				frame_notices("Function successfully deleted!!", "greenfont");

				database_manipulation::delete_record($this, $rec_id);

		}
		$GLOBALS['logger_obj']->debug('<br>METHOD functions::delete() - Return Value : ', $ret_val);
		return $ret_val;

	}
	
}

?>