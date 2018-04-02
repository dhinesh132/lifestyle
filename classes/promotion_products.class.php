<?php



class promotion_products extends database_manipulation

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



	function promotion_products()

	{



		$this->frm_name = "promotion_products_frm";



		$this->cls_tbl = "promotion_products";



		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";



		$this->unique_flds = "promotion_cat_id,package_id";



		$this->file_flds = "";



		$this->reference_tables = "";



		$this->primary_fld = "id";

		
		$this->id = array("frm_fldname" => "id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->product_id = array("frm_fldname" => "product_id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->promotion_cat_id = array("frm_fldname" => "promotion_cat_id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->package_id = array("frm_fldname" => "package_id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->status = array("frm_fldname" => "status", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");
		
		$this->date_modified = array("frm_fldname" => "date_modified", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

	}







	/**********************************************************************************************



								Method To add a Promotion product record.



	***********************************************************************************************/

	

	function insert()

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD promotion_products::insert() - PARAMETER LIST : ', $param_array);



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

		

			frame_notices("Product already exists !!", "redfont",1);

			

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

				frame_notices("Product not added due to the following reasons!!", "redfont",1);

				foreach($_REQUEST as $ky => $vl)

				$_SESSION['ses_temp_color_obj'][$ky] = $vl;

			}

			else

			{			

				

				unset($_SESSION['ses_temp_color_obj']);

				

				frame_notices("Product successfully added !!", "greenfont", 1);

	

				$ret_val = true;

			}

		}

		

		$GLOBALS['logger_obj']->debug('<br>METHOD promotion_product::insert() - Return Value : ', $ret_val);



		return $ret_val;

	

	}

	

	/**********************************************************************************************



									Method To update product details



	***********************************************************************************************/

	

	function update($id,$where_notice="outside")

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD promotion_banner::update() - PARAMETER LIST : ', $param_array);

		

	

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



				frame_notices("Product name already exists !!", "redfont", 1);



				foreach($_REQUEST as $ky => $vl)

				$_SESSION['ses_temp_color_obj'][$ky] = $vl;



				$ret_val = false;

			}

			else

			{



				unset($_SESSION['ses_temp_color_obj']);



				$cond = $this->primary_fld . " = '" . $id . "'";

				
			if(isset($_REQUEST['UniqueKey_temp']) && $_REQUEST['UniqueKey_temp'] !=''){

				$uniquekey = GenerateUniqueKey($_REQUEST['UniqueKey_temp'],$this->cls_tbl );		

				
			}else{
				$uniquekey = GenerateUniqueKey($_REQUEST['Title'],$this->cls_tbl );

			}
			$this->UniqueKey['save_todb'] = 'true';

			$this->UniqueKey['value'] =$uniquekey;
			

			

			$resultset = database_manipulation::insert_record($this);

				

				$resultset = database_manipulation::update_record($this, $cond);

				$t = count($resultset);

				$ret_val = true;

				if($t == 1)

				{

					$ret_val = false;

					frame_notices("Promotion product details is not updated due to the following reasons!!", "redfont",1);

					foreach($_REQUEST as $ky => $vl)

					$_SESSION['ses_temp_color_obj'][$ky] = $vl;

				}

				else

				{

				

				if($where_notice == "outside")

				frame_notices("Promotion product details is successfully updated !!", "greenfont", 1);



				$ret_val = true;

				}

			}

			

		}



		$GLOBALS['logger_obj']->debug('<br>METHOD promotion_products::update() - Return Value : ', $ret_val);



		return $ret_val;

		

	}



	/**********************************************************************************************



								Method To delete product details.



	***********************************************************************************************/

	

	function delete($rec_id)

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD promotion_products::delete() - PARAMETER LIST : ', $param_array);

		

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

		

		$GLOBALS['logger_obj']->debug('<br>METHOD promotion_products::delete() - Return Value : ', $ret_val);



		return $ret_val;

	}





	/**********************************************************************************************



						Method To fetch details of a particular product.



	***********************************************************************************************/

	

	function fetch_record($id)

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD promotion_products::fetch_record() - PARAMETER LIST : ', $param_array);



		$condition = $this->primary_fld . " = '" . $id . "'";

		

		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);

		

		$GLOBALS['logger_obj']->debug('<br>METHOD promotion_products::fetch_record() - Return Value : ', $res);



		return $res;

	

	}

	



	



}



?>