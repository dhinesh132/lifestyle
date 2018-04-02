<?php
if(file_exists("classes/email.class.php"))
	require_once("classes/email.class.php");
else if(file_exists("./classes/email.class.php"))
	require_once("./classes/email.class.php");
else if(file_exists("../classes/email.class.php"))
	require_once("../classes/email.class.php");
	
class minimum_qty_products extends database_manipulation
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

	var $TypeName;

	var $ProdId;

	function minimum_qty_products()
	{

		$this->frm_name = "minimum_qty_products_frm";

		$this->cls_tbl = "minimum_qty_products";

		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";

		$this->unique_flds = "ProdId";

		$this->file_flds = "";

		$this->reference_tables = "";

		$this->primary_fld = "QId";

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

		$this->QId = array("frm_fldname" => "QId", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ProdId = array("frm_fldname" => "ProdId", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "true", "value" => "");
		
		$this->Qty = array("frm_fldname" => "Qty", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->DateStored = array("frm_fldname" => "DateStored", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");


	}

	
	function fetch_record($id, $ProdId_chk="-1")
	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD minimum_qty_products::fetch_record() - PARAMETER LIST : ', $param_array);
			
			if($ProdId_chk > -1 && $_REQUEST['admin'] != 1)
				$condition = $this->primary_fld . " = '" . $id . "' and ProdId = '" . $ProdId_chk . "'";
			else
				$condition = $this->primary_fld . " = '" . $id . "'";
	
			$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
	
		$GLOBALS['logger_obj']->debug('<br>METHOD minimum_qty_products::fetch_record() - Return Value : ', $res);

		return $res;

	}
	
	function fetch_pages($pl_id)
	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD minimum_qty_products::fetch_pages() - PARAMETER LIST : ', $param_array);
			
		$condition = "pl_id = '" . $pl_id . "' and ProdId='1'";

		$res = database_manipulation::fetch_flds($this->cls_tbl, "Id,TypeName", $condition);
	
		$GLOBALS['logger_obj']->debug('<br>METHOD minimum_qty_products::fetch_pages() - Return Value : ', $res);

		return $res;

	}
	
	
		
		/**********************************************************************************************


					Method To Register/Insert a user record.

	***********************************************************************************************/

	function insert()

	{
		//$GLOBALS['site_config']['debug']=1;
		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD minimum_qty_products::insert() - PARAMETER LIST : ', $param_array);

		$ufld_arr = explode(",", $this->unique_flds);

		$chk_val = "";

		
		$chk_val = $this->UserId['value'] . ",".$this->ProdId['value'] . ",".$this->EmailStatus['value'] . ",";
		$chk_val = substr($chk_val, 0, -1);

		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))

		{

			frame_notices("Sorry. You have been informed us before!!", "redfont");

			foreach($_REQUEST as $ky => $vl)

			$_SESSION['ses_temp_type_obj'][$ky] = $vl;

			$ret_val = false;

		}

		else

		{
			
			$resultset = database_manipulation::insert_record($this);

			unset($_SESSION['ses_temp_type_obj']);
			
			//frame_notices("Thank you. You will be updated!!", "greenfont");

			$ret_val = true;

		}

		$GLOBALS['logger_obj']->debug('<br>METHOD minimum_qty_products::insert() - Return Value : ', $ret_val);

		return $ret_val;

	}


	/**********************************************************************************************
					Method To update details of a particular user. 

					(Myaccount Edit Purpose - We need to update the details altered by the user).
	***********************************************************************************************/

	function update($id)

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD minimum_qty_products::update() - PARAMETER LIST : ', $param_array);

		if($id > 0)

		{

			$ufld_arr = explode(",", $this->unique_flds);

			$chk_val = "";

			foreach($ufld_arr as $key => $val)

				$chk_val .= $_REQUEST[$val] . ",";
			$chk_val = substr($chk_val, 0, -1);

			if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val, $this->primary_fld, $id,"update"))

			{
				frame_notices("Type already exists!!", "redfont");
				foreach($_REQUEST as $ky => $vl)

				$_SESSION['ses_temp_type_obj'][$ky] = $vl;
				$ret_val = false;

			}

			else

			{

			unset($_SESSION['ses_temp_type_obj']);

				$cond = $this->primary_fld . " = '" . $id . "'";
				$resultset = database_manipulation::update_record($this, $cond);

				//frame_notices("Type successfully updated !!", "greenfont");
				$ret_val = true;

			}

		}

		$GLOBALS['logger_obj']->debug('<br>METHOD minimum_qty_products::update() - Return Value : ', $ret_val);

		return $ret_val;

	}

	/**********************************************************************************************

				Method To delete details of a particular user. 

					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/

	function delete($rec_id)

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD minimum_qty_products::delete() - PARAMETER LIST : ', $param_array);
		if($rec_id > 0)

		{
				frame_notices("Type successfully deleted!!", "greenfont");

				database_manipulation::delete_record($this, $rec_id);

		}
		$GLOBALS['logger_obj']->debug('<br>METHOD minimum_qty_products::delete() - Return Value : ', $ret_val);
		return $ret_val;

	}
	
	/**********************************************************************************************

				Method To delete details of a particular user. 

					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/

	function send_notification($prod_id)

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD minimum_qty_products::delete() - PARAMETER LIST : ', $param_array);
		if($prod_id > 0)

		{		$eml_cls = new email();
				$select_qry = "SELECT C.cust_id,C.cust_firstname,C.cust_lastname,C.cust_email,Q.QId,P.Id,P.EnName FROM customer_master as C,minimum_qty_products as Q,Products as P WHERE Q.UserId = C.cust_id and Q.ProdId= P.Id and Q.ProdId=".$prod_id." and EmailStatus =0 GROUP BY Q.UserId ";
				$notify_res = $GLOBALS['db_con_obj']->execute_sql($select_qry,"select");
				$prod_url = $GLOBALS['site_config']['site_path']."product_detail.php?prod_id=".$prod_id;
				
				while($notify_data = mysql_fetch_object($notify_res[0])){				
					
					$subject = $notify_data->EnName." is available at ".$GLOBALS['site_config']['company_name'];
					if(file_exists("emails/quantity_notification.php"))
						require_once("emails/quantity_notification.php");
					else if(file_exists("./emails/quantity_notification.php"))
						require_once("./emails/quantity_notification.php");
					else if(file_exists("../emails/quantity_notification.php"))
						require_once("../emails/quantity_notification.php");
					
					$Message = $content;
					$to_email = $notify_data->cust_email;
					$from_email = "roreply@wayonnet.com";
					$eml_cls->pear_mail($subject,$Message,$to_email,$from_email);
					$this->ProdId['value'] =$prod_id;
					$this->UserId['value'] =$notify_data->cust_id;
					$this->EmailStatus['save_todb'] = 'true';
					$this->EmailStatus['value'] =1;
					$this->update($notify_data->QId);
				}

		}
		$GLOBALS['logger_obj']->debug('<br>METHOD minimum_qty_products::delete() - Return Value : ', $ret_val);
		return $ret_val;

	}
	
	// CRON JOBS for Delete record from temp cart table	
	function delete_records_from_table(){		
		$delete_qry = "DELETE FROM ".$this->cls_tbl." WHERE dateStored <= NOW() - INTERVAL 1 DAY";
		$GLOBALS['db_con_obj']->execute_sql($delete_qry,"delete");
	}
	
	
}

?>