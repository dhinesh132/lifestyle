<?php

class products extends database_manipulation
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

	var $EnName;

	var $ProdStatus;

	function products()
	{

		$this->frm_name = "products_frm";

		$this->cls_tbl = "products";

		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";

		$this->unique_flds = "ProdCode";

		$this->file_flds = "Image";

		$this->reference_tables = "";

		$this->primary_fld = "Id";

		$this->attachment_h = "110";

		$this->attachment_w = "110";

		$this->attachment_s = "20480000";

		$this->attachment_conditions = "s";

		$this->image_copies = array();

		$this->upload_msgs = array();

		if(file_exists("uploads/product_files/"))
			$this->attachment_path = "uploads/product_files/";
		else
			$this->attachment_path = "../uploads/product_files/";

		$this->Id = array("frm_fldname" => "Id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ProdCode = array("frm_fldname" => "ProdCode", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ProdType = array("frm_fldname" => "ProdType", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->EnName = array("frm_fldname" => "EnName", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->UniqueKey = array("frm_fldname" => "UniqueKey", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->EnShortDesc = array("frm_fldname" => "EnShortDesc", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->Price = array("frm_fldname" => "Price", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->Quantity = array("frm_fldname" => "Quantity", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->Weight = array("frm_fldname" => "Weight", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ProdStatus = array("frm_fldname" => "ProdStatus", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->Types = array("frm_fldname" => "Types", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->Material = array("frm_fldname" => "Material", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->Function = array("frm_fldname" => "Function", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->Groups = array("frm_fldname" => "Groups", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->Image = array("frm_fldname" => "Image", "fld_type" => "str", "frm_fld_type" => "img", "save_todb" => "false", "value" => "");
		
		$this->IsFeatured = array("frm_fldname" => "IsFeatured", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->Video = array("frm_fldname" => "Video", "fld_type" => "str", "frm_fld_type" => "file", "save_todb" => "false", "value" => "");
		
		$this->Created = array("frm_fldname" => "Created", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->Modified = array("frm_fldname" => "Modified", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->DisplayOrder = array("frm_fldname" => "DisplayOrder", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->EnLongDesc = array("frm_fldname" => "EnLongDesc", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->EnInfo = array("frm_fldname" => "EnInfo", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->EnShipping = array("frm_fldname" => "EnShipping", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ChName = array("frm_fldname" => "ChName", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ChShortDesc = array("frm_fldname" => "ChShortDesc", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ChLongDesc = array("frm_fldname" => "ChLongDesc", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ChInfo = array("frm_fldname" => "ChInfo", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ChShipping = array("frm_fldname" => "ChShipping", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->serach_tags = array("frm_fldname" => "serach_tags", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->MetaTitle = array("frm_fldname" => "MetaTitle", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->MetaKey = array("frm_fldname" => "MetaKey", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->MetaDesc = array("frm_fldname" => "MetaDesc", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->AuthorId = array("frm_fldname" => "AuthorId", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->admin_star = array("frm_fldname" => "admin_star", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

	}

	
	function fetch_record($id, $TypeProdStatus_chk="-1")
	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD products::fetch_record() - PARAMETER LIST : ', $param_array);
			
			if($TypeProdStatus_chk > -1 && $_REQUEST['admin'] != 1)
				$condition = $this->primary_fld . " = '" . $id . "' and TypeProdStatus = '" . $TypeProdStatus_chk . "'";
			else
				$condition = $this->primary_fld . " = '" . $id . "'";
	
			$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
	
		$GLOBALS['logger_obj']->debug('<br>METHOD products::fetch_record() - Return Value : ', $res);

		return $res;

	}
	
	function fetch_pages($pl_id)
	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD products::fetch_pages() - PARAMETER LIST : ', $param_array);
			
		$condition = "pl_id = '" . $pl_id . "' and TypeProdStatus='1'";

		$res = database_manipulation::fetch_flds($this->cls_tbl, "Id,EnName", $condition);
	
		$GLOBALS['logger_obj']->debug('<br>METHOD products::fetch_pages() - Return Value : ', $res);

		return $res;

	}
	
	
		
		/**********************************************************************************************


					Method To Register/Insert a user record.

	***********************************************************************************************/

	function insert()

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD products::insert() - PARAMETER LIST : ', $param_array);

		$ufld_arr = explode(",", $this->unique_flds);

		$chk_val = "";

		foreach($ufld_arr as $key => $val)

			$chk_val .= $_REQUEST[$val] . ",";

		$chk_val = substr($chk_val, 0, -1);

		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))

		{

			frame_notices("Product already exists!!", "redfont");

			foreach($_REQUEST as $ky => $vl)

			$_SESSION['ses_temp_type_obj'][$ky] = $vl;

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

			unset($_SESSION['ses_temp_type_obj']);
			
			frame_notices("Product successfully added !!", "greenfont");

			$ret_val = true;

		}

		$GLOBALS['logger_obj']->debug('<br>METHOD products::insert() - Return Value : ', $ret_val);

		return $ret_val;

	}


	/**********************************************************************************************
					Method To update details of a particular user. 

					(Myaccount Edit Purpose - We need to update the details altered by the user).
	***********************************************************************************************/

	function update($id)

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD products::update() - PARAMETER LIST : ', $param_array);

		if($id > 0)

		{

			$ufld_arr = explode(",", $this->unique_flds);

			$chk_val = "";

			foreach($ufld_arr as $key => $val)

				$chk_val .= $_REQUEST[$val] . ",";
			$chk_val = substr($chk_val, 0, -1);

			if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val, $this->primary_fld, $id,"update"))

			{
				frame_notices("Product already exists!!", "redfont");
				foreach($_REQUEST as $ky => $vl)

				$_SESSION['ses_temp_type_obj'][$ky] = $vl;
				$ret_val = false;

			}

			else

			{

			unset($_SESSION['ses_temp_type_obj']);
			
			if(isset($_REQUEST['UniqueKey_temp']) && $_REQUEST['UniqueKey_temp'] !=''){

				$uniquekey = GenerateUniqueKey($_REQUEST['UniqueKey_temp'],$this->cls_tbl );		

				
			}else{
				$uniquekey = GenerateUniqueKey($_REQUEST['EnName'],$this->cls_tbl );

			}
			
			
			$this->UniqueKey['save_todb'] = 'true';

			$this->UniqueKey['value'] =$uniquekey;

				$cond = $this->primary_fld . " = '" . $id . "'";
				$resultset = database_manipulation::update_record($this, $cond);

				frame_notices("Product successfully updated !!", "greenfont");
				$ret_val = true;

			}

		}

		$GLOBALS['logger_obj']->debug('<br>METHOD products::update() - Return Value : ', $ret_val);

		return $ret_val;

	}

	/**********************************************************************************************

				Method To delete details of a particular user. 

					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/

	function delete($rec_id)

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD products::delete() - PARAMETER LIST : ', $param_array);
		if($rec_id > 0)

		{
				frame_notices("Product successfully deleted!!", "greenfont");

				database_manipulation::delete_record($this, $rec_id);

		}
		$GLOBALS['logger_obj']->debug('<br>METHOD products::delete() - Return Value : ', $ret_val);
		return $ret_val;

	}
	
	
	//*******************************************************************************************************************
	//Search fucction
//*******************************************************************************************************************
	
	function search_query()

		{
		
		
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD products::search_qurey() - PARAMETER LIST : ', $param_array);
		
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_prod_srch_vars'][$ky] = $vl;
			
			if(isset($_SESSION['ses_prod_srch_vars']['ProdType']) && $_SESSION['ses_prod_srch_vars']['ProdType'] ==2)
				$qry = "select Id, EnName,Price,Quantity,AuthorId,ProdStatus,DisplayOrder from " . $this->cls_tbl." where ProdType=2 ";
			else
				$qry = "select Id, EnName,Price,Quantity,Types,Material,Function,ProdStatus,DisplayOrder from " . $this->cls_tbl." where ProdType=1 ";
	
			//$qry="select * from " . $this->cls_tbl." where ";
			
			
			$use_cond = " and ";
		
			$join_qry = " and (";
			
			$join_qry_st = 0;
			
			
			if(isset($_SESSION['ses_prod_srch_vars']['ProdStatus']) && $_SESSION['ses_prod_srch_vars']['ProdStatus'] !='')
			{
				$join_qry .= " ProdStatus=".$_SESSION['ses_prod_srch_vars']['ProdStatus'];
				$join_qry_st = 1;
			}
			
			if(isset($_SESSION['ses_prod_srch_vars']['Function']) && $_SESSION['ses_prod_srch_vars']['Function'] !='')
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
					
				$join_qry .= "concat(',',Function,',') like '%".$_SESSION['ses_prod_srch_vars']['Function']."%'";
				$join_qry_st = 1;
			}
			
			if(isset($_SESSION['ses_prod_srch_vars']['Types']) && $_SESSION['ses_prod_srch_vars']['Types'] !='')
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
					
				$join_qry .= " concat(',',Types,',') like '%".$_SESSION['ses_prod_srch_vars']['Types']."%'";
				$join_qry_st = 1;
			}
			
			if(isset($_SESSION['ses_prod_srch_vars']['Material']) && $_SESSION['ses_prod_srch_vars']['Material'] !='')
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
					
				$join_qry .= " concat(',',Material,',') like '%".$_SESSION['ses_prod_srch_vars']['Material']."%'";
				$join_qry_st = 1;
			}
			
			if(isset($_SESSION['ses_prod_srch_vars']['EnName']) && $_SESSION['ses_prod_srch_vars']['EnName'] !='')
			{
				
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
		
				$join_qry .= "(lower(EnName) " . stripslashes(str_replace("#val#",strtolower($_SESSION['ses_prod_srch_vars']['EnName']), $_SESSION['ses_prod_srch_vars']['Nametype'])) . ")";
		
				$join_qry_st = 1;
			}
			
			if(isset($_SESSION['ses_prod_srch_vars']['ProdCode']) && $_SESSION['ses_prod_srch_vars']['ProdCode'] !='')
			{
				
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
					
				$join_qry .= " ProdCode = '".$_SESSION['ses_prod_srch_vars']['ProdCode']."'";
				$join_qry_st = 1;
			}
			
			if(isset($_SESSION['ses_prod_srch_vars']['Author']) && $_SESSION['ses_prod_srch_vars']['Author'] !='')
			{
				
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
					
				$join_qry .= " AuthorId = ".$_SESSION['ses_prod_srch_vars']['Author'];
				$join_qry_st = 1;
			}
			
			if($join_qry_st != 1)
			$join_qry .= "1=1";
			
			$join_qry .= ")";
		
			//add sorting to the query - Start
			if(!empty($_SESSION['ses_prod_srch_vars']['sort_column']) && $_SESSION['ses_prod_srch_vars']['sort_column'] !='')
			{
				$join_qry .= " order by EnName " . $_SESSION['ses_prod_srch_vars']['sort_column'] ;
			} else{
				$join_qry .= " order by DisplayOrder desc" ;
			}
			//add sorting to the query - End
		
		
			$final_qry = $qry . $join_qry;
			
			
			
			
			$_SESSION['ses_prod_srch_qry'] = $final_qry;
			return $final_qry;
			
		$GLOBALS['logger_obj']->debug('<br>METHOD products::search_qurey() - Return Value : ', $ret_val);
		return $ret_val;	
		
	}
	
}

?>