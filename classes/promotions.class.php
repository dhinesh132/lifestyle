<?php



class promotions extends database_manipulation

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



	var $Code;



	var $ban_status;



	var $EnBanimage;



	function promotions()

	{



		$this->frm_name = "promotions_frm";



		$this->cls_tbl = "promotions";



		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";



		$this->unique_flds = "Code";



		$this->file_flds = "";



		$this->reference_tables = "";



		$this->primary_fld = "Id";



		$this->attachment_h = 110;

		

		$this->attachment_w = 110;

		

		$this->attachment_s = 2048000;

		

		$this->attachment_conditions = "s"; //any of the following values can be set to this. - s - size,h - height,w - width,sh - size and height,sw - size and width,hw - height and width,shw - size, height and width.

		

		$this->image_copies = array();



		$this->upload_msgs = array();

		

		//$this->files = "EnBanimage";



		$this->upload_msgs = array();

		

		if(file_exists("uploads/banners/"))

			$this->attachment_path = "uploads/banners/";

		else

			$this->attachment_path = "../uploads/banners/";

		$this->Id = array("frm_fldname" => "Id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->Code = array("frm_fldname" => "Code", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->Type = array("frm_fldname" => "Type", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->Value = array("frm_fldname" => "Value", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->StartDate = array("frm_fldname" => "StartDate", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ExpiryDate = array("frm_fldname" => "ExpiryDate", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->MinAmountVal = array("frm_fldname" => "MinAmountVal", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");		
		
		$this->MinAmount = array("frm_fldname" => "MinAmount", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->CustomerLogin = array("frm_fldname" => "CustomerLogin", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->NoOfUseByCustomer = array("frm_fldname" => "NoOfUseByCustomer", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ReUse = array("frm_fldname" => "ReUse", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");		
		
		$this->ApplyFor = array("frm_fldname" => "ApplyFor", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->CateId = array("frm_fldname" => "CateId", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->ItemId = array("frm_fldname" => "ItemId", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");		

		$this->Status = array("frm_fldname" => "Status", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

	}







	/**********************************************************************************************



								Method To add a product record.



	***********************************************************************************************/

	

	function insert()

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD promotions::insert() - PARAMETER LIST : ', $param_array);



		//need to check the uniqueness for username and email...



		$ufld_arr = explode(",", $this->unique_flds);

		$chk_val = "";

		

		foreach($ufld_arr as $key => $val)

		{

			if(isset($_REQUEST[$val]))

				$chk_val .= $_REQUEST[$val] . ",";

			else

				$chk_val .= $this->{$val}['value'] . ",";

		}

		

		$chk_val = substr($chk_val, 0, -1);

		

		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val))

		{

		

			frame_notices("Promotion already exists !!", "redfont",1);

			

			foreach($_REQUEST as $ky => $vl)

			$_SESSION['ses_temp_color_obj'][$ky] = $vl;

			

			$ret_val = false;

		}

		else

		{

			

			$resultset = database_manipulation::insert_record($this);

			

			$t = count($resultset);

			$ret_val = true;

			//echo $t . "<hr>";

			if($t == 1)

			{

				$ret_val = false;

				frame_notices("Promotion not added due to the following reasons!!", "redfont",1);

				foreach($_REQUEST as $ky => $vl)

				$_SESSION['ses_temp_color_obj'][$ky] = $vl;

			}

			else

			{			

				

				unset($_SESSION['ses_temp_color_obj']);

				

				frame_notices("Promotion successfully added !!", "greenfont", 1);

	

				$ret_val = true;

			}

		}

		

		$GLOBALS['logger_obj']->debug('<br>METHOD promotions::insert() - Return Value : ', $ret_val);



		return $ret_val;

	

	}

	

	/**********************************************************************************************



									Method To update product details



	***********************************************************************************************/

	

	function update($id,$where_notice="outside")

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD promotions::update() - PARAMETER LIST : ', $param_array);

		

	

		if($id > 0)

		{

			//need to check the uniqueness for username and email...

			

			$ufld_arr = explode(",", $this->unique_flds);

			$chk_val = "";

			

			foreach($ufld_arr as $key => $val)

			{

				if(isset($_REQUEST[$val]))

					$chk_val .= $_REQUEST[$val] . ",";

				else

					$chk_val .= $this->{$val}['value'] . ",";

			}

			

			$chk_val = substr($chk_val, 0, -1);

			

			if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val, $this->primary_fld, $id,"update"))

			{



				frame_notices("Promotion name already exists !!", "redfont", 1);



				foreach($_REQUEST as $ky => $vl)

				$_SESSION['ses_temp_color_obj'][$ky] = $vl;



				$ret_val = false;

			}

			else

			{



				unset($_SESSION['ses_temp_color_obj']);



				$cond = $this->primary_fld . " = '" . $id . "'";

				

			

			

			$resultset = database_manipulation::insert_record($this);

				

				$resultset = database_manipulation::update_record($this, $cond);

				$t = count($resultset);

				$ret_val = true;

				if($t == 1)

				{

					$ret_val = false;

					frame_notices("Promotion details not updated due to the following reasons!!", "redfont",1);

					foreach($_REQUEST as $ky => $vl)

					$_SESSION['ses_temp_color_obj'][$ky] = $vl;

				}

				else

				{

				

				if($where_notice == "outside")

				frame_notices("Promotion details successfully updated !!", "greenfont", 1);



				$ret_val = true;

				}

			}

			

		}



		$GLOBALS['logger_obj']->debug('<br>METHOD promotions::update() - Return Value : ', $ret_val);



		return $ret_val;

		

	}



	/**********************************************************************************************



								Method To delete product details.



	***********************************************************************************************/

	

	function delete($rec_id)

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD promotions::delete() - PARAMETER LIST : ', $param_array);

		

		if($rec_id > 0)

		{

			$primary_fld = $this->primary_fld . " = '" . $rec_id . "'";

			$prnt_id = $this->fetch_field($this->cls_tbl, "Id", $primary_fld);

			

			if($prnt_id == -1)

			{

				$this->delete_child_products($rec_id);

			}

			

			database_manipulation::delete_record($this, $rec_id);

			frame_notices("Promotion deleted !!", "greenfont");

		}

		

		$GLOBALS['logger_obj']->debug('<br>METHOD promotions::delete() - Return Value : ', $ret_val);



		return $ret_val;

	}





	/**********************************************************************************************



						Method To fetch details of a particular product.



	***********************************************************************************************/

	

	function fetch_record($id)

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD promotions::fetch_record() - PARAMETER LIST : ', $param_array);



		$condition = $this->primary_fld . " = '" . $id . "'";

		

		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);

		

		$GLOBALS['logger_obj']->debug('<br>METHOD promotions::fetch_record() - Return Value : ', $res);



		return $res;

	

	}

	

	function get_product_available_quantity($Id)

	{

	

		$orig_quantity = $GLOBALS['db_con_obj']->fetch_field($this->cls_tbl, "qty_in_hand", "Id = '" . $Id . "'");

		

		$purchased_qty_qry = "select order_details.prod_quantity from order_master, order_details where order_master.order_id = order_details.order_id and order_details.Id = '" .  $Id . "'";// and order_master.order_status = '1'

		

		$purchased_qty_res = $GLOBALS['db_con_obj']->execute_sql($purchased_qty_qry);

		

		$purchased_qty = 0;

		

		while($purchased_qty_data = mysql_fetch_object($purchased_qty_res[0]))

		$purchased_qty += $purchased_qty_data->prod_quantity;

		

		//$allocated_qty_qry = "select allocated_qty from inventory_mgmt where temp_inv_Id = '" . $Id . "' and php_ses_id <> '" . session_id() . "'";

		

		//$allocated_qty_res = $GLOBALS['db_con_obj']->execute_sql($allocated_qty_qry);

		

		$allocated_qty = 0;

		

		/*while($allocated_qty_data = mysql_fetch_object($allocated_qty_res[0]))

		$allocated_qty += $allocated_qty_data->allocated_qty;*/

		

		$available_qty = ($orig_quantity - $purchased_qty - $allocated_qty);

		

		return $available_qty;

		

	}

	



}



?>