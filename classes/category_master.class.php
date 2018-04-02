<?php

class category_master extends database_manipulation
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

	var $cat_id;

	var $cat_name;

	var $cat_desc;

	var $cat_status;
	
	var $display_order;
	
	var $date_entered;

	var $date_modified;

	function category_master()
	{

		$this->frm_name = "category_master_frm";

		$this->cls_tbl = "category_master";

		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";

		$this->unique_flds = "cat_name";

		$this->file_flds = "";

		$this->reference_tables = "";

		$this->primary_fld = "cat_id";

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

		$this->cat_id = array("frm_fldname" => "cat_id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->cat_name = array("frm_fldname" => "cat_name", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->cat_desc = array("frm_fldname" => "cat_desc", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->cat_status = array("frm_fldname" => "cat_status", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->display_order = array("frm_fldname" => "display_order", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->parent_id = array("frm_fldname" => "parent_id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->date_entered = array("frm_fldname" => "date_entered", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->date_modified = array("frm_fldname" => "date_modified", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

	}


	/**********************************************************************************************

					Method To Register/Insert a user record.

	***********************************************************************************************/
	
	function insert()
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD category_maser::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$ufld_arr = explode(",", $this->unique_flds);
		$chk_val = "";
		
		foreach($ufld_arr as $key => $val)

			$chk_val .= $_REQUEST[$val] . ",";

		$chk_val = substr($chk_val, 0, -1);
		
		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))
		{
		
			frame_notices("Category name already exists !!", "redfont");
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_category_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
			$resultset = database_manipulation::insert_record($this);
			
			frame_notices("Category successfully added !!", "greenfont");
			
			unset($_SESSION['ses_temp_category_obj']);
			
			
			
			$ret_val = true;
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD category_maser::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD category_maser::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD category_maser::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccount Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD category_maser::update() - PARAMETER LIST : ', $param_array);
		
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

				frame_notices("Category name already exists !!", "redfont");

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_category_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_temp_category_obj']);
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Category details successfully updated !!", "greenfont");

				$ret_val = true;
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD category_maser::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete($rec_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD category_maser::delete() - PARAMETER LIST : ', $param_array);
		
		
		if($rec_id > 0)
		{
			$primary_fld = $this->primary_fld;
			
			/*$delete ="delete from ".$this->cls_tbl." where parent_id ='".$rec_id ."'";
			$GLOBALS['db_con_obj']->execute_sql($delete,"delete");
			
			database_manipulation::delete_record($this, $rec_id);
			frame_notices("Category details successfully deleted !!", "greenfont");*/
			
			

		$subcat = $GLOBALS['db_con_obj']->fetch_flds($this->cls_tbl,"cat_id","parent_id='".$rec_id."'");
		
		$parentid_res = $GLOBALS['db_con_obj']->fetch_flds($this->cls_tbl,"parent_id","cat_id='".$rec_id."'");
		
		$parentid_data = mysql_fetch_object($parentid_res[0]);
		
		$parentid = $parentid_data->parent_id;
		
		
			if($subcat[1] >= 1)
			{

				frame_notices("Subcategories for this category should be deleted before deleting it !!", "redfont");

			}

			else

			{
			
				$product = $GLOBALS['db_con_obj']->fetch_flds("product_master","prod_id","category_id='".$rec_id."'");
			
				if($product[1] >= 1)
				{
	
					frame_notices("Products for this category should be deleted before deleting it !!", "redfont");
	
				}
				else
				{
					if($parentid ==0)
					frame_notices("Category successfully deleted!!", "greenfont");
					else
					frame_notices("Sub category successfully deleted!!", "greenfont");
	
					database_manipulation::delete_record($this, $rec_id);
				}

			}

		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD category_maser::delete() - Return Value : ', $ret_val);

		return $ret_val; 
	
	} 

	function frame_category_heirarchy($cat_id, $str="", $where="product_list")
	{
		
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD productcategory::frame_category_heirarchy() - PARAMETER LIST : ', $param_array);
	
		$res = $this->fetch_flds($this->cls_tbl, "*", $this->primary_fld . " = '" . $cat_id . "'");
		
		$t_str = $str;
		
		if($data = mysql_fetch_object($res[0]))
		{
		
			if(($data->parent_id >= 0 && $where == "category_list" ) || ($data->parent_id >= 0 && $where == "product_list") || ($where == "topcategory") )
			{
				if($where == "category_list")
					
					$cat_str = "&nbsp;<a href='category_list.php?cat_id=" . $data->category_id . "' class='maroonlink'>" . stripslashes($data->cat_name) . "</a>&nbsp;&gt;";
				
				//020607 for admin section heirarchy 
				else if($where == "topcategory")
						
					$cat_str = "&nbsp;<a href='select_category.php?parent_id=" . $data->category_id."' class='blue_link'>" .  stripslashes($data->cat_name) . "</a>&nbsp;&gt;";
				// End of admin section
					
				else
				
					$cat_str = "&nbsp;" . stripslashes($data->cat_name) . "&nbsp;&gt;&gt;";
					
					//$cat_str = "&nbsp;<a href='product_lists.php?cat_id=" . $data->category_id . "' class='maroonlink'>" . stripslashes($data->cat_name) . "</a>&nbsp;&gt;&gt;";
					
					$t_str = $cat_str . $t_str;
					
					$t_str = $this->frame_category_heirarchy($data->parent_id, $t_str, $where);
					
			}
		}
	
		$GLOBALS['logger_obj']->debug('<br>METHOD productcategory::frame_category_heirarchy() - Return Value : ', $t_str);

		return $t_str;
	}	
	

}

?>