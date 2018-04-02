<?php

class subscriber extends database_manipulation 
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

	var $name;

	var $email;
	
	var $display_order;

	var $status;

	var $date_entered;

	var $date_modified;

	function subscriber()
	{

		$this->frm_name = "subscriber_frm";

		$this->cls_tbl = "subscriber";

		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";

		$this->unique_flds = "email";

		$this->file_flds = "";

		$this->reference_tables = "";

		$this->primary_fld = "id";

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

		$this->id = array("frm_fldname" => "id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->name = array("frm_fldname" => "name", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->email = array("frm_fldname" => "email", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ContactNo = array("frm_fldname" => "ContactNo", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->status = array("frm_fldname" => "status", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->date_entered = array("frm_fldname" => "date_entered", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->date_modified = array("frm_fldname" => "date_modified", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

	}

	
	function fetch_record($id, $status_chk="-1")
	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD subscriber::fetch_record() - PARAMETER LIST : ', $param_array);
			
			if($status_chk > -1 && $_REQUEST['admin'] != 1)
				$condition = $this->primary_fld . " = '" . $id . "' and status = '" . $status_chk . "'";
			else
				$condition = $this->primary_fld . " = '" . $id . "'";
	
			$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
	
		$GLOBALS['logger_obj']->debug('<br>METHOD subscriber::fetch_record() - Return Value : ', $res);

		return $res;

	}
	
	function fetch_pages($pl_id)
	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD subscriber::fetch_pages() - PARAMETER LIST : ', $param_array);
			
		$condition = "pl_id = '" . $pl_id . "' and status='1'";

		$res = database_manipulation::fetch_flds($this->cls_tbl, "id,name", $condition);
	
		$GLOBALS['logger_obj']->debug('<br>METHOD subscriber::fetch_pages() - Return Value : ', $res);

		return $res;

	}
	
	
		
		/**********************************************************************************************


					Method To Register/Insert a user record.

	***********************************************************************************************/

	function insert()

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD subscriber::insert() - PARAMETER LIST : ', $param_array);

		$ufld_arr = explode(",", $this->unique_flds);

		$chk_val = "";

		foreach($ufld_arr as $key => $val)

			$chk_val .= $_REQUEST[$val] . ",";

		$chk_val = substr($chk_val, 0, -1);

		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))

		{

			frame_notices(EMAILALREADYEXIST, "redfont");

			foreach($_REQUEST as $ky => $vl)

			$_SESSION['ses_subscriber_obj'][$ky] = $vl;

			$ret_val = false;

		}

		else

		{
			
			$resultset = database_manipulation::insert_record($this);

			unset($_SESSION['ses_subscriber_obj']);
			frame_notices(THANKYOUFORSIGNUP, "greenfont");

			$ret_val = true;

		}

		$GLOBALS['logger_obj']->debug('<br>METHOD subscriber::insert() - Return Value : ', $ret_val);

		return $ret_val;

	}


	/**********************************************************************************************
					Method To update details of a particular user. 

					(Myaccount Edit Purpose - We need to update the details altered by the user).
	***********************************************************************************************/

	function update($id)

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD subscriber::update() - PARAMETER LIST : ', $param_array);

		if($id > 0)

		{

			$ufld_arr = explode(",", $this->unique_flds);

			$chk_val = "";

			foreach($ufld_arr as $key => $val)

				$chk_val .= $_REQUEST[$val] . ",";
			$chk_val = substr($chk_val, 0, -1);

			if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val, $this->primary_fld, $id,"update"))

			{
				frame_notices("Email already exists!!", "redfont");
				foreach($_REQUEST as $ky => $vl)

				$_SESSION['ses_subscriber_obj'][$ky] = $vl;
				$ret_val = false;

			}

			else

			{

			unset($_SESSION['ses_subscriber_obj']);

				$cond = $this->primary_fld . " = '" . $id . "'";
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Email successfully updated !!", "greenfont");
				$ret_val = true;

			}

		}

		$GLOBALS['logger_obj']->debug('<br>METHOD subscriber::update() - Return Value : ', $ret_val);

		return $ret_val;

	}

	/**********************************************************************************************

				Method To delete details of a particular user. 

					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/

	function delete($rec_id)

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD subscriber::delete() - PARAMETER LIST : ', $param_array);
		if($rec_id > 0)

		{
				frame_notices("Email successfully deleted!!", "greenfont");

				database_manipulation::delete_record($this, $rec_id);

		}
		$GLOBALS['logger_obj']->debug('<br>METHOD subscriber::delete() - Return Value : ', $ret_val);
		return $ret_val;

	}
	
	/**********************************************************************************************************************

									Searching for Subscriber

***********************************************************************************************************************/

	function search_query()
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD subscriber::search_qurey() - PARAMETER LIST : ', $param_array);
		
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_sub_srch_vars'][$ky] = $vl;
			
			$qry = "select * from " . $this->cls_tbl . " where 1 = 1";			
			
			$use_cond = " and ";
		
			$join_qry = " and (";
			
			$join_qry_st = 0;
			//search with Buyer name - Start
			if(!empty($_SESSION['ses_sub_srch_vars']['filter_srch_val']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
		
				$join_qry .= " (lower(" . $_SESSION['ses_sub_srch_vars']['filter_column'] . ") " . stripslashes(str_replace("#val#",strtolower($_SESSION['ses_sub_srch_vars']['filter_srch_val']), $_SESSION['ses_sub_srch_vars']['Nametype'])) . ")";
		
				$join_qry_st = 1;
			}
			
			if($join_qry_st != 1)
			$join_qry .= "1=1";
			
			$join_qry .= ")";
		
			//add sorting to the query - Start
			if(!empty($_SESSION['ses_sub_srch_vars']['sort_column']))
			{
				$join_qry .= " order by " . $_SESSION['ses_sub_srch_vars']['sort_column'] ;
			}
			//add sorting to the query - End
			
		
			$final_qry = $qry . $join_qry;
			
			
			$_SESSION['ses_sub_srch_qry'] = $final_qry;
			return $final_qry;
			
		$GLOBALS['logger_obj']->debug('<br>METHOD subscriber::search_qurey() - Return Value : ', $ret_val);
		return $ret_val;	
		
	
	}
	
}

?>