<?php

class static_pages extends database_manipulation 
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

	var $Id;

	var $EnTitle;

	var $page_content;

	var $parent_id;
	
	var $display_order;

	var $display_status;

	var $date_entered;

	var $date_modified;

	function static_pages()
	{

		$this->frm_name = "static_pages_frm";

		$this->cls_tbl = "static_pages";

		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";

		$this->unique_flds = "EnTitle,menu_type";

		$this->file_flds = "banner_image";

		$this->reference_tables = "";

		$this->primary_fld = "Id";

		$this->attachment_w = 110;
		
		$this->attachment_s = 512000;
		
		$this->attachment_conditions = "s"; //any of the following values can be set to this. - s - size,h - height,w - width,sh - size and height,sw - size and width,hw - height and width,shw - size, height and width.
		
		$this->image_copies = array();

		$this->upload_msgs = array();

		if(file_exists("uploads/static_files/"))
			$this->attachment_path = "uploads/static_files/";
		else
			$this->attachment_path = "../uploads/static_files/";

		$this->Id = array("frm_fldname" => "Id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->EnTitle = array("frm_fldname" => "EnTitle", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");		

		$this->ChTitle = array("frm_fldname" => "ChTitle", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->UniqueKey = array("frm_fldname" => "UniqueKey", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->EnContent = array("frm_fldname" => "EnContent", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ChContent = array("frm_fldname" => "ChContent", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->menu_type = array("frm_fldname" => "menu_type", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->meta_title = array("frm_fldname" => "meta_title", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->meta_keywords = array("frm_fldname" => "meta_keywords", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->meta_description = array("frm_fldname" => "meta_description", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->parent_id = array("frm_fldname" => "parent_id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->page_link = array("frm_fldname" => "page_link", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->banner_type = array("frm_fldname" => "banner_type", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->banner_image = array("frm_fldname" => "banner_image", "fld_type" => "str", "frm_fld_type" => "img", "save_todb" => "false", "value" => "");
		
		$this->display_order = array("frm_fldname" => "display_order", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->display_status = array("frm_fldname" => "display_status", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->rights_to_visible = array("frm_fldname" => "rights_to_visible", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->date_entered = array("frm_fldname" => "date_entered", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->date_modified = array("frm_fldname" => "date_modified", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

	}

	
	function fetch_record($id, $display_status_chk="-1")
	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD static_pages::fetch_record() - PARAMETER LIST : ', $param_array);
			
			if($display_status_chk > -1 && $_REQUEST['admin'] != 1)
				$condition = $this->primary_fld . " = '" . $id . "' and display_status = '" . $display_status_chk . "'";
			else
				$condition = $this->primary_fld . " = '" . $id . "'";
	
			$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
	
		$GLOBALS['logger_obj']->debug('<br>METHOD static_pages::fetch_record() - Return Value : ', $res);

		return $res;

	}
	
	function fetch_pages($parent_id)
	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD static_pages::fetch_pages() - PARAMETER LIST : ', $param_array);
			
		$condition = "parent_id = '" . $parent_id . "' and display_status='1'";

		$res = database_manipulation::fetch_flds($this->cls_tbl, "Id,EnTitle", $condition);
	
		$GLOBALS['logger_obj']->debug('<br>METHOD static_pages::fetch_pages() - Return Value : ', $res);

		return $res;

	}
	
	
		
		/**********************************************************************************************


					Method To Register/Insert a user record.

	***********************************************************************************************/

	function insert()

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD static_pages::insert() - PARAMETER LIST : ', $param_array);

		$ufld_arr = explode(",", $this->unique_flds);

		$chk_val = "";

		foreach($ufld_arr as $key => $val)

			$chk_val .= $_REQUEST[$val] . ",";

		$chk_val = substr($chk_val, 0, -1);

		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))

		{

			frame_notices("Content already exists!!", "redfont");

			foreach($_REQUEST as $ky => $vl)

			$_SESSION['ses_temp_spg_obj'][$ky] = $vl;

			$ret_val = false;

		}

		else

		{
		
			
			$order = $GLOBALS['db_con_obj']->fetch_field($this->cls_tbl,"display_order","1=1 order by display_order desc limit 0,1");
			$this->display_order['save_todb'] = 'true';
			$displayorder = $order+1;
			$this->display_order['value'] =$displayorder;
			
			if(isset($_REQUEST['UniqueKey_temp']) && $_REQUEST['UniqueKey_temp'] !=''){
				$uniquekey = GenerateUniqueKey($_REQUEST['UniqueKey_temp'],$this->cls_tbl );				
			}else{
				$uniquekey = GenerateUniqueKey($_REQUEST['EnTitle'],$this->cls_tbl );
			}			
			
			$this->UniqueKey['save_todb'] = 'true';
			$this->UniqueKey['value'] =$uniquekey;
			
			$resultset = database_manipulation::insert_record($this);

			unset($_SESSION['ses_temp_spg_obj']);
			frame_notices("Content successfully added !!", "greenfont");

			$ret_val = true;

		}

		$GLOBALS['logger_obj']->debug('<br>METHOD static_pages::insert() - Return Value : ', $ret_val);

		return $ret_val;

	}


	/**********************************************************************************************
					Method To update details of a particular user. 

					(Myaccount Edit Purpose - We need to update the details altered by the user).
	***********************************************************************************************/

	function update($id)

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD static_pages::update() - PARAMETER LIST : ', $param_array);

		if($id > 0)

		{

			$ufld_arr = explode(",", $this->unique_flds);

			$chk_val = "";

			foreach($ufld_arr as $key => $val)

				$chk_val .= $_REQUEST[$val] . ",";
			$chk_val = substr($chk_val, 0, -1);

			if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val, $this->primary_fld, $id,"update"))

			{
				frame_notices("Content already exists!!", "redfont");
				foreach($_REQUEST as $ky => $vl)

				$_SESSION['ses_temp_spg_obj'][$ky] = $vl;
				$ret_val = false;

			}

			else

			{
			if(isset($_REQUEST['UniqueKey_temp']) && $_REQUEST['UniqueKey_temp'] !=''){
				$uniquekey = GenerateUniqueKey($_REQUEST['UniqueKey_temp'],$this->cls_tbl );				
			}else{
				$uniquekey = GenerateUniqueKey($_REQUEST['EnTitle'],$this->cls_tbl );
			}			
			
			$this->UniqueKey['save_todb'] = 'true';
			$this->UniqueKey['value'] =$uniquekey;	
			
			unset($_SESSION['ses_temp_spg_obj']);

				$cond = $this->primary_fld . " = '" . $id . "'";
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Content successfully updated !!", "greenfont");
				$ret_val = true;

			}

		}

		$GLOBALS['logger_obj']->debug('<br>METHOD static_pages::update() - Return Value : ', $ret_val);

		return $ret_val;

	}

	/**********************************************************************************************

				Method To delete details of a particular user. 

					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/

	function delete($rec_id)

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD static_pages::delete() - PARAMETER LIST : ', $param_array);
		if($rec_id > 0)

		{
				$page_link = $GLOBALS['db_con_obj']->fetch_field($this->cls_tbl,"page_link","Id='".$rec_id."'");
				unlink('../'.$page_link);
				
				frame_notices("Content successfully deleted!!", "greenfont");

				database_manipulation::delete_record($this, $rec_id);

		}
		$GLOBALS['logger_obj']->debug('<br>METHOD static_pages::delete() - Return Value : ', $ret_val);
		return $ret_val;

	}
	
}

?>