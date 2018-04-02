<?php
//for discount history
if(file_exists("classes/prod_discount_history.class.php"))

	require_once("classes/prod_discount_history.class.php");

else if(file_exists("./classes/prod_discount_history.class.php"))

	require_once("./classes/prod_discount_history.class.php");

else if(file_exists("../classes/prod_discount_history.class.php"))

	require_once("../classes/prod_discount_history.class.php");


class product_master extends database_manipulation
{


	var $frm_name; //name of the form from where the details are collected.

	var $cls_tbl; //name of the table which this class uses.

	var $cls_sql; //default sql statement for the class.

	var $unique_flds; //unique fields for the table delimited with commas(,).

	var $file_flds; //file fields for the table delimited with commas(,).

	var $attachment_path; //where the files for this table should be uploaded.

	var $books_path; //where the books will be uploaded.

	var $attachment_h; //the file to be uploaded should be with this height, if not reqd set to 0, if set to 0 config default values will be taken.

	var $attachment_w; //the file to be uploaded should be with this width, if not reqd set to 0, if set to 0 config default values will be taken.

	var $attachment_s; //the file to be uploaded should be with this size, if not reqd set to 0, if set to 0 config default values will be taken.

	var $attachment_conditions; //what are all the conditions to be handled in the file upload, s for size, h for height, w for width

	var $image_copies; //number of copies to be generated from the image field.

	var $primary_fld; //primary fields name of the table.

	var $register_email_id; //primary id from the emails table which contains the registration email.

	var $fp_email_id; //primary id from the emails table which contains the forgot password email.

	var $reference_tables; //tables that have the records related to the table of this class...
	
//database field names - Start

	var $prod_id;
	
	var $model_no;
	
	var $brand;
	
	var $color_code;
	
	var $size;
	
	var $stock_code;
	
	var $frame_type;
	
	var $sprin_loaded;
	
	var $price;
	
	var $prod_weight;
	
	var $color_id;
	
	var $gen_id;
	
	var $mat_id;
	
	var $prod_med_image;
	
	var $prod_our_price;
	
	var $prod_normal_price;
		
	var $date_entered;
	
	var $date_modified;
	
	var $purchase_count;
	
	var $stocks_available;
	
	var $ref_tbl;
	
	var $auto_modelid;
	
	var $auto_colorid;
	
	var $auto_sizeid;
		
	var $prod_status;
	
	var $measurments;
	
	var $lens_depth;
	
	var $description;
	//parameters for search concept - Start
	
	var $search_types;
	
	var $get_search_types;
	
	var $match_case;
	
	var $search_sql;
	
	var $search_cond;
	
	var $srch_ses_val;
	
	var $srch_ses_qry_str;
	
	var $srch_ses_searched_bool;
	
	//parameters for search concept - End

//database field names - End

	function product_master()
	{
		
		$this->frm_name = 'product_master_detail_frm';
		
		$this->cls_tbl = 'product_master';
		
		$this->ref_tbl = "productrefcategory";
		
		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";
		
		$this->unique_flds = 'prod_id';
		
		$this->file_flds = 'prod_th_image,prod_med_image,prod_large_image,book_file,large_picture';
		
		$this->reference_tables = 'productrefcategory|product_id|0,prod_discount_history|prod_id|0'; //tablename|reference_fld_name|file_field_exists,tablename|reference_fld_name|file_field_exists
		
		$this->primary_fld = 'prod_id';
		
		$this->register_email_id = 0;

		$this->fp_email_id = 0;
		
		$this->attachment_h = 110;
		
		$this->attachment_w = 110;
		
		$this->attachment_s = 2048000;
		
		$this->attachment_conditions = "s"; //any of the following values can be set to this. - s - size,h - height,w - width,sh - size and height,sw - size and width,hw - height and width,shw - size, height and width.
		
		//$this->image_copies = array("prod_med_image" => array("4", "prod_th_image|th|60|60,prod_med_image|med|110|110,prod_big_image|big|250|250,prod_large_image|large|350|350"));
		
		$this->upload_msgs = array("file" => array("success" => "File uploaded successfully !!", "failure" => "File exceeds the size #sz# !!"));
		//27072007 - Start
		$temp_bytes = (2048 * 1024); //filke size is set to kb in config, so multiply by 1024
		
		$this->image_dimensions = array("book_file" => array("s" => $temp_bytes)); //3145728 - 3 mb
		//27072007 - End
		
		//$this->image_copies_fld_names = "thumb_photo1|th|60|60,photo1|med|110|110,large_photo1|large|300|300";//database field_name|suffix_in_file_name|width|large
		
		if(file_exists("../uploads/"))

			$this->attachment_path = '../uploads/product_files/';
			
		else
		
			$this->attachment_path = 'uploads/product_files/';
		
		$this->books_path = $this->attachment_path; //27072007 - books should also be uploaded to the 
		
		/*
		if(file_exists("../uploads/"))

			$this->books_path = '../uploads/ebooks/';
			
		else
		
			$this->books_path = 'uploads/ebooks/';
		*/
		
		//$this->database_fld_name = array( - membervariables should be the database field names...
		
		$this->prod_id = array('frm_fldname' => 'prod_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');
		
		$this->model_no = array('frm_fldname' => 'model_no', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

		$this->brand = array('frm_fldname' => 'brand', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

		$this->color_code = array('frm_fldname' => 'color_code', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

		$this->size = array('frm_fldname' => 'size', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

		$this->stock_code = array('frm_fldname' => 'stock_code', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product description!'), 'value' => '');
		
		$this->frame_type = array('frm_fldname' => 'frame_type', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product description!'), 'value' => '');
		
		$this->sprin_loaded = array('frm_fldname' => 'sprin_loaded', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount!'), 'value' => '');
		
		$this->price = array('frm_fldname' => 'price', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'numeric', 'minlen' => '1', 'maxlen' => '20', 'msg' => 'Enter product retail price!'), 'value' => '');
		
		$this->color_id = array('frm_fldname' => 'color_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'true', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
		
		$this->prod_weight = array('frm_fldname' => 'prod_weight', 'fld_type' => 'str', 'frm_fld_type' => 'select', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product options!'), 'value' => '');
		
		$this->gen_id = array('frm_fldname' => 'gen_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
		
		$this->mat_id = array('frm_fldname' => 'mat_id', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'Select product discount type!'), 'value' => '');
		
		$this->prod_med_image = array('frm_fldname' => 'prod_med_image', 'fld_type' => 'str', 'frm_fld_type' => 'img', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');
		
		$this->date_entered = array('frm_fldname' => 'date_entered', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		$this->date_modified = array('frm_fldname' => 'date_modified', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		$this->purchase_count = array('frm_fldname' => 'purchase_count', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		$this->stocks_available = array('frm_fldname' => 'stocks_available', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		$this->auto_modelid = array('frm_fldname' => 'auto_modelid', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');
		
		$this->auto_colorid = array('frm_fldname' => 'auto_colorid', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');

	$this->auto_sizeid = array('frm_fldname' => 'auto_sizeid', 'fld_type' => 'str', 'frm_fld_type' => 'hidden', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '');

		$this->prod_status = array('frm_fldname' => 'prod_status', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '1');
		
		$this->measurments = array('frm_fldname' => 'measurments', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil', 'minlen' => '255', 'maxlen' => '255', 'msg' => 'This is an alpha numeric field!'), 'value' => '1');
		
		$this->lens_depth = array('frm_fldname' => 'l_depth', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

		$this->description = array('frm_fldname' => 'description', 'fld_type' => 'str', 'frm_fld_type' => 'text', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'string', 'minlen' => '1', 'maxlen' => '255', 'msg' => 'Enter product name!'), 'value' => '');

		$this->large_picture = array('frm_fldname' => 'large_picture', 'fld_type' => 'str', 'frm_fld_type' => 'img', 'save_todb' => 'false', 'ismandatory' => array('fld_type' => 'nil'), 'value' => '');

		$this->match_case = "no";
		
		$this->search_types = array(
		
		array("tbl_fld_name" => "cont_list", "tbl_fld_value" => "contains_keyword", "srch_type" => "contains", "cond_typ" => "or"),
		
		array("tbl_fld_name" => "cont_list1", "tbl_fld_value" => "contains_keyword", "srch_type" => "contains", "cond_typ" => "or"),
		
		array("tbl_fld_name" => "equal_list", "tbl_fld_value" => "equal_keyword", "srch_type" => "equalto", "cond_typ" => "and"),
		
		"save_todb" => 'false'
		
		);
		
		$this->get_search_types = array("save_todb" => "false");
		
		$this->get_search_types[0] = array("search_condition" => "depend_object_setting");

		$this->search_sql = "select " . $this->cls_tbl . ".* from " . $this->cls_tbl . " where 1 = 1 ";

		$this->search_cond = "or";
		
		$this->srch_ses_val = "ses_prod_master_srch_vars";
		
		$this->srch_ses_qry_str = "ses_prod_master_srch_qry";
		
		if(!isset($_SESSION[$this->searched_ses_val]))
		$_SESSION[$this->searched_ses_val] = 0;
		

		
	}
	
	
	/**********************************************************************************************

				Method To Frame Javascript Validation for the mandatory fields.

	***********************************************************************************************/
	
	function frame_validation_script()
	{
	
		$member_var_arr = get_object_vars($this);
		
		$script_str = '<script language="javascript">';
		
		$script_str .= 'function check_validate() {';

		$script_str .= 'error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";';
		
		foreach($member_var_arr as $key => $value)
		{
		
			if(is_array($value) && array_key_exists('ismandatory', $value) && $value['ismandatory']['fld_type'] != 'nil')
			{
			
				
				switch (strtolower($value['ismandatory']['fld_type']))
				{

					case 'email':
						$fun_name = "check_email";
						break;

					case 'numeric':
						$script_str .= 'check_empty(form.elements["' . $value['frm_fldname'] . '"].name,"' . $value['ismandatory']['msg'] . '");';
						$fun_name = "check_numeric";
						break;

					case 'string':
						$fun_name = "check_empty";
						break;

					case 'passwrd':
						$fun_name = "check_match";
						break;

				}//end switch
				
				if($value['ismandatory']['fld_type'] == "passwrd")
				{
					
					$msg_arr = explode("|", $value['ismandatory']['msg']);
					
					$script_str .= 'check_empty(form.elements["' . $value['frm_fldname'] . '"].name, "' . $msg_arr['0'] . '");';

					$script_str .= $fun_name . '(form.elements["' . $value['frm_fldname'] . '"].name, form.elements["c' . $value['frm_fldname'] . '"].name, "' . $msg_arr['1'] . '");';
					
					$script_str .= 'Check_Lengthlow(form.elements["' . $value['frm_fldname'] . '"].name, "' . $msg_arr['2'] . '", "' . $value['ismandatory']['minlen'] . '");';

					$script_str .= 'Check_Lengthhigh(form.elements["' . $value['frm_fldname'] . '"].name, "' . $msg_arr['2'] . '", "' . $value['ismandatory']['maxlen'] . '");';
					
				}
				else
				
					$script_str .= $fun_name . '(form.elements["' . $value['frm_fldname'] . '"].name,"' . $value['ismandatory']['msg'] . '");';
				
			
			}
		
		}
		
		$script_str .= '}';
		
		$script_str .= '</script>';
		
		return $script_str;

	}



	/**********************************************************************************************

					Method To Register/Insert a user record.

	***********************************************************************************************/
	
	function insert()
	{
		//$GLOBALS['site_config']['debug'] =1;

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::insert() - PARAMETER LIST : ', $param_array);

		//need to check the uniqueness for username and email...
		
		$prod_obj->color_id['save_todb'] = 'true';
			$color = "";
			
			foreach($_REQUEST['color'] as $key => $value)
			{
				if(strlen(trim($value)) > 0)
				$color .= $value . ",";
			}
			
			$color = substr($color,0,-1);
			$prod_obj->color_id['value'] = $color;
			
			$prod_obj->gen_id['save_todb'] = 'true';
			$gen_array = "";
			
			foreach($_REQUEST['gender'] as $key => $value)
			{
				if(strlen(trim($value)) > 0)
				$gen_array .= $value . ",";
			}
			
			$gen_array = substr($gen_array,0,-1);
			
			$prod_obj->gen_id['value'] = $gen_array;
			
			$prod_obj->mat_id['save_todb'] = 'true';
			$mat_array = "";
			
			foreach($_REQUEST['material'] as $key => $value)
			{
				if(strlen(trim($value)) > 0)
				$mat_array .= $value . ",";
			}
			
			$mat_array = substr($mat_array,0,-1);
			
			$prod_obj->mat_id['value'] = $mat_array;
			
			
			
			$prod_obj->size['save_todb'] = 'true';
			$size = $_REQUEST['size1']."-".$_REQUEST['size2']."-".$_REQUEST['size3'];
			$prod_obj->size['value'] = $size;
			
			$prod_obj->measurments['save_todb'] = 'true';
			$size1 = $_REQUEST['t_width']."-".$_REQUEST['l_depth']."-".$size;
			$prod_obj->measurments['value'] = $size1;
		


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
		
		if(strlen(trim($this->unique_flds)) > 0 && database_manipulation::record_exists($this->cls_tbl, $this->unique_flds, $chk_val)|| $_SESSION['prod_values']['stock_code'] == '')
		{
			if($_SESSION['prod_values']['stock_code'] ==''){
				frame_notices("Stock code should not be empty !!", "redfont",1);
			}
			else{
				frame_notices("Product already exists !!", "redfont",1);
			}
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_product_obj'][$ky] = $vl;
			
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
				$_SESSION['ses_temp_product_obj'][$ky] = $vl;
			}
			else
			{	
			
			$update = "update ".$this->cls_tbl." set size='".$size."', color_id='".$color."', mat_id='".$mat_array."', gen_id='".$gen_array."',measurments='".$size1."' , stock_code='". $_SESSION['prod_values']['stock_code']."',auto_modelid='". $_SESSION['prod_values']['auto_modelid']."',auto_colorid='". $_SESSION['prod_values']['auto_colorid']."',auto_sizeid='". $_SESSION['prod_values']['auto_sizeid']."' where prod_id='".$resultset[2]."'";
			
			$GLOBALS['db_con_obj']->execute_sql($update,"update");
			unset($_SESSION['ses_temp_product_obj']);
			unset($_SESSION['prod_values']);
						
				if($_REQUEST['submit_action'] =="model_color")
				{
				$_SESSION['ses_temp_product_obj'] ['prod_id']=$resultset[2];
				$_SESSION['ses_temp_product_obj'] ['submit_action']="model_color";
				/*$_SESSION['ses_temp_product_obj']['model_no'] = $_REQUEST['model_no'];
				$_SESSION['ses_temp_product_obj']['brand'] = $_REQUEST['brand'];
				$_SESSION['ses_temp_product_obj']['color_code'] = $_REQUEST['color_code'];
				unset($_SESSION['ses_temp_product_obj']['size1']);
				unset($_SESSION['ses_temp_product_obj']['size2']);
				unset($_SESSION['ses_temp_product_obj']['size3']);*/
				}
				
				else if($_REQUEST['submit_action'] =="size")
				{
				$_SESSION['ses_temp_product_obj'] ['prod_id']=$resultset[2];
			
				$_SESSION['ses_temp_product_obj'] ['submit_action']="size";
				/*;$_SESSION['ses_temp_product_obj']['model_no'] = $_REQUEST['model_no'];
				$_SESSION['ses_temp_product_obj']['brand'] = $_REQUEST['brand'];
				$_SESSION['ses_temp_product_obj']['size1'] = $_REQUEST['size1'];
				$_SESSION['ses_temp_product_obj']['size2'] = $_REQUEST['size2'];
				$_SESSION['ses_temp_product_obj']['size3'] = $_REQUEST['size3'];*/
				}
				else
				unset($_SESSION['ses_temp_product_obj']);
						
				
				
				
				frame_notices("Product successfully added !!", "greenfont", 1);
	
				$ret_val = true;
			}
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}
	
	/**********************************************************************************************

					Method To fetch details of a particular user. 
					(Myaccount Edit Purpose - We need to fill the form).

	***********************************************************************************************/
	
	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	/**********************************************************************************************

					Method To update details of a particular user. 
					(Myaccount Edit Purpose - We need to update the details altered by the user).

	***********************************************************************************************/
	
	function update($id,$where_notice="outside")
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::update() - PARAMETER LIST : ', $param_array);
	
	//$GLOBALS['site_config']['debug'] =1;
	
	$prod_obj->color_id['save_todb'] = 'true';
			$color = "";
			
			foreach($_REQUEST['color'] as $key => $value)
			{
				if(strlen(trim($value)) > 0)
				$color .= $value . ",";
			}
			
			$color = substr($color,0,-1);
			
			$prod_obj->color_id['value'] = $color;
			
			$prod_obj->gen_id['save_todb'] = 'true';
			$gen_array = "";
			
			foreach($_REQUEST['gender'] as $key => $value)
			{
				if(strlen(trim($value)) > 0)
				$gen_array .= $value . ",";
			}
			
			$gen_array = substr($gen_array,0,-1);
			
			$prod_obj->gen_id['value'] = $gen_array;
			
			$prod_obj->mat_id['save_todb'] = 'true';
			$mat_array = "";
			
			foreach($_REQUEST['material'] as $key => $value)
			{
				if(strlen(trim($value)) > 0)
				$mat_array .= $value . ",";
			}
			
			$mat_array = substr($mat_array,0,-1);
			
			$prod_obj->mat_id['value'] = $mat_array;
			
			
			
			$prod_obj->size['save_todb'] = 'true';
			$size = $_REQUEST['size1']."-".$_REQUEST['size2']."-".$_REQUEST['size3'];
			$prod_obj->size['value'] = $size;
			

			
			$prod_obj->measurments['save_todb'] = 'true';
			$size1 = $_REQUEST['t_width']."-".$_REQUEST['l_depth']."-".$size;
			$prod_obj->measurments['value'] = $size1;
		
		
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
				$_SESSION['ses_temp_product_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_temp_product_obj']);

				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);
				$t = count($resultset);
				$ret_val = true;
				if($t == 1)
				{
					$ret_val = false;
					frame_notices("Product details not updated due to the following reasons!!", "redfont",1);
					foreach($_REQUEST as $ky => $vl)
					$_SESSION['ses_temp_product_obj'][$ky] = $vl;
				}
				else
				{
				$update = "update ".$this->cls_tbl." set size='".$size."', color_id='".$color."', mat_id='".$mat_array."', gen_id='".$gen_array."',measurments='".$size1."' where prod_id='".$id."'";
				
				$GLOBALS['db_con_obj']->execute_sql($update,"update");
				unset($_SESSION['ses_temp_product_obj']);
						
				if($_REQUEST['submit_action'] =="model_color")
				{
				$_SESSION['ses_temp_product_obj']['model_no'] = $_REQUEST['model_no'];
				$_SESSION['ses_temp_product_obj']['brand'] = $_REQUEST['brand'];
				$_SESSION['ses_temp_product_obj']['color_code'] = $_REQUEST['color_code'];
				}
				
				if($_REQUEST['submit_action'] =="size")
				{
				$_SESSION['ses_temp_product_obj']['model_no'] = $_REQUEST['model_no'];
				$_SESSION['ses_temp_product_obj']['brand'] = $_REQUEST['brand'];
				$_SESSION['ses_temp_product_obj']['size1'] = $_REQUEST['size1'];
				$_SESSION['ses_temp_product_obj']['size2'] = $_REQUEST['size2'];
				$_SESSION['ses_temp_product_obj']['size3'] = $_REQUEST['size3'];
				}
				if($where_notice == "outside")
				frame_notices("Product details successfully updated !!", "greenfont", 1);

				$ret_val = true;
				}
			}
			
		}
//exit;
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	/**********************************************************************************************

					Method To delete details of a particular user. 
					Necessary codings is to be made to delete all user related records.

	***********************************************************************************************/
	
	function delete($rec_id)
	{
	
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::delete() - PARAMETER LIST : ', $param_array);
		
		if($rec_id > 0)
		{
			$primary_fld = $this->primary_fld . " = '" . $rec_id . "'";
			$prnt_id = $this->fetch_field($this->cls_tbl, "prod_parent_id", $primary_fld);
			
			if($prnt_id == -1)
			{
				$this->delete_child_products($rec_id);
			}
			
			database_manipulation::delete_record($this, $rec_id);
			frame_notices("Product deleted !!", "greenfont");
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::delete() - Return Value : ', $ret_val);

		return $ret_val;
	}

	/******************************************************************************************************
			Method To Maintain Reference between product category and products..
	******************************************************************************************************/
	
	function insert_update_reference($selected_category_id, $product_id,$loop=0)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::insert_update_reference() - PARAMETER LIST : ', $param_array);
		
		$temp_prod_cat_obj = new productcategory();
		
		if($loop == 0)
		{
			$del_qry = "delete from " . $this->ref_tbl ." where product_id = '" . $product_id . "'";
			$this->execute_sql($del_qry, "delete");
		}
		$qry = "select category_id, parent_id from " . $temp_prod_cat_obj->cls_tbl . " where category_id = '" . $selected_category_id . "'";
		$res = $this->execute_sql($qry);
		
		if($data = mysql_fetch_object($res[0]))
		{

			$ins_qry = "insert into " . $this->ref_tbl . " (category_id, product_id) values ('" . $selected_category_id . "', '" . $product_id . "')";
			$this->execute_sql($ins_qry, "insert");
			
			$loop++;

			if($data->parent_id > 0)
			$this->insert_update_reference($data->parent_id, $product_id, $loop);

		}
	
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::insert_update_reference() - Return Value : ', $ret_val);
		
		return $ret_val;
	}
	
	/**********************************************************************************************
				Method to delete child products...
	**********************************************************************************************/
	
	function delete_child_products($prod_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::delete_child_products() - PARAMETER LIST : ', $param_array);
		
		$res = $this->fetch_flds($this->cls_tbl,"*", "prod_parent_id = '" . $prod_id . "'");
		
		while($data = mysql_fetch_object($res[0]))
		{
			$this->delete($data->prod_id);
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::insert_update_reference() - Return Value : ', 'Deleted all the child products and returning void');
		
	}

	/**********************************************************************************************
				Method To Dissolve Parent/Children Related Products. This method deletes all child 
				products and makes the parent product a self standing one.
	***********************************************************************************************/
	
	function dissolve_group($prnt_prod_id)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::dissolve_group() - PARAMETER LIST : ', $param_array);
		
		if($prnt_prod_id > 0)
		{
			$this->delete_child_products($prnt_prod_id); //delete all children products
			$this->prod_parent_id['save_todb'] = true;
			$this->prod_parent_id['value'] = 0;
			$this->update($prnt_prod_id, "self");
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::dissolve_group() - Return Value : ', 'Dissolved the group of the parent and returning void');

	}//end function dissolve_group
	
	/***********************************************************************************************************************
				Method To Record Product Individual Discount History
	*************************************************************************************************************************/
	
	function record_product_individual_discount($prod_id,$purpose="insert")
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::record_product_individual_discount() - PARAMETER LIST : ', $param_array);
		
			$prod_dishist_obj = new prod_discount_history();
			
			$prod_dishist_obj->prod_id['save_todb'] = 'true';
			$prod_dishist_obj->prod_id['value'] = $prod_id;
			
			
			 $dis_qry=database_manipulation::execute_sql("select * from " . $prod_dishist_obj->cls_tbl . " where prod_id = $prod_id and dis_end_dt > now() order by dis_id desc limit 0,1");
			 
			if($dis_qry[1] > 0)
			{
			$data=mysql_fetch_object($dis_qry[0]);
			 $res_id1=$data->dis_id;
			$prod_dishist_obj->update($res_id1);
			}
			else
			{
			$prod_dishist_obj->insert();
			}
			
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::record_product_individual_discount() - Return Value : ', '');

	}
	
	function product_user_search($purpose="search")
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::product_user_search() - PARAMETER LIST : ', $param_array);
		
		if($purpose == "search")
		{
		
			$qry = "select * from " . $this->cls_tbl . " where 1 = 1 and prod_status = '1' and prod_id not in (" . implode(",", $GLOBALS['consultations_prod_id']) . ")";
			
			foreach($_REQUEST as $key => $value)
				$_SESSION['ses_prod_srch_vars'][$key] = $value;
			
			$tmp_qry = " and (";	
			$prev_criteria = 0;
							
			if(strlen(trim($_SESSION['ses_prod_srch_vars']['contains_keyword'])) > 0)
			{
				$prev_criteria = 1;
				$tmp_qry .= "(lower(prod_name) like '%" . wrap_values(strtolower($_SESSION['ses_prod_srch_vars']['contains_keyword'])) . "%' or lower(prod_desc) like '%" . wrap_values(strtolower($_SESSION['ses_prod_srch_vars']['contains_keyword'])) . "%')";
			}		
			
			if(strlen(trim($_SESSION['ses_prod_srch_vars']['equal_keyword'])) > 0)
			{
				if($prev_criteria == 1)
					$tmp_qry .= " and (";
						
				$tmp_qry .= "author = '" . wrap_values($_SESSION['ses_prod_srch_vars']['equal_keyword']) . "'";
				
				if($prev_criteria == 1)
				$tmp_qry .= ")";
				$prev_criteria = 1;
			}
			
			$tmp_qry .= ")";
			
			if($prev_criteria == 1)
			$qry .= $tmp_qry . " order by prod_id desc";
			
			$_SESSION['ses_prod_usr_srch_qry'] = $qry;
			
		}
		else if($purpose == "clearsearch")
		{
			$_SESSION['ses_prod_usr_srch_qry'] = "";
			unset($_SESSION['ses_prod_usr_srch_qry']);
			unset($_SESSION['ses_prod_srch_vars']);
		}
				
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::product_user_search() - Return Value : ', '');

	}
	
	function get_total_downloads($prod_id)
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::get_total_downloads() - PARAMETER LIST : ', $param_array);
		
		if(file_exists("classes/order_details.class.php"))
			require_once("classes/order_details.class.php");
		else
			require_once("../classes/order_details.class.php");
		
		$ord_dobj = new order_details();
		
		$qry = "select detail_id from " . $ord_dobj->cls_tbl . " where prod_id = '" . $prod_id . "' and download_status = '1'";
		$res = $GLOBALS['db_con_obj']->execute_sql($qry);
		
		$download_cnt = $res[1];
		
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::get_total_downloads() - Return Value : ', $download_cnt);

		return $download_cnt;
	
	}
	
	function get_product_rating($prod_id)
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::get_product_rating() - PARAMETER LIST : ', $param_array);
		
		if(file_exists("classes/your_review.class.php"))
			require_once("classes/your_review.class.php");
		else
			require_once("../classes/your_review.class.php");
		
		$urrev_obj = new your_review();
		
		$qry = "select avg(rating) as avg_rating from " . $urrev_obj->cls_tbl . " where prod_id = '" . $prod_id . "' and status = '1'";
		$res = $GLOBALS['db_con_obj']->execute_sql($qry);
		
		$data = mysql_fetch_object($res[0]);

		$avg_rating = $data->avg_rating;
		
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::get_product_rating() - Return Value : ', $avg_rating);

		return $avg_rating;
	
	}
	
	function display_rating($rating_val)
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::display_rating() - PARAMETER LIST : ', $param_array);
		
		$star_rating_str = "";
		
		for($i = 1; $i <= floor($rating_val); $i++)
			$star_rating_str .= "<img src='images/ssmall2.gif' border='0'>";
		
		if(floor($rating_val) < $rating_val)
		$star_rating_str .= "<img src='images/ssmall3.gif' border='0'>";
		
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::display_rating() - Return Value : ', $star_rating_str);

		return $star_rating_str;
	
	}

	//functions added on 24062007 - End

	function check_insert_author($txt_fld_val='', $dd_fld_val='', $adv_id=0)
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::check_insert_author() - PARAMETER LIST : ', $param_array);
		
		if(file_exists("../classes/author.class.php"))
			require_once("../classes/author.class.php");
		else
			require_once("classes/author.class.php");
		
		$auth_obj = new author();
		
		if(strlen(trim($txt_fld_val)) > 0)
		{
			$qry = "select " . $auth_obj->primary_fld . " from " . $auth_obj->cls_tbl . " where lower(name) = '" . wrap_values(strtolower($txt_fld_val)) . "'";
			$res = $GLOBALS['db_con_obj']->execute_sql($qry);
		}
		else if(strlen(trim($dd_fld_val)) > 0)
		{
			$qry = "select " . $auth_obj->primary_fld . " from " . $auth_obj->cls_tbl . " where " . $auth_obj->primary_fld . " = '" . wrap_values(strtolower($dd_fld_val)) . "'";
			$res = $GLOBALS['db_con_obj']->execute_sql($qry);
		}
		
		if($res[1] > 0)
		{
			$data = mysql_fetch_object($res[0]);
			$ret_val = $data->{$auth_obj->primary_fld};
		}
		else if(strlen(trim($txt_fld_val)) > 0)
		{
			
			$qry = "insert into " . $auth_obj->cls_tbl . " (name, created_datetime, modify_datetime) values ('" . wrap_values($txt_fld_val) . "', now(), now())";
			
			$ins_res = $GLOBALS['db_con_obj']->execute_sql($qry, "insert");
			
			$ret_val = $ins_res[2];
	
		}
		
		$uqry = "update " . $this->cls_tbl . " set author = '" . $ret_val . "' where " . $this->primary_fld . " = '" . $adv_id . "'";
		
		$GLOBALS['db_con_obj']->execute_sql($uqry, "update");
		
		$GLOBALS['logger_obj']->debug('<br>METHOD product_master::check_insert_author() - Return Value : ', 'Returning void');

	}
	//functions added on 24062007 - End
	
	/**********************************************************************************************************************

									Searching for customer

***********************************************************************************************************************/

	function search_query()
	{
	
		
		
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD customer_master::search_qurey() - PARAMETER LIST : ', $param_array);
		
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_frame_srch_vars'][$ky] = $vl;
			$qry = "select prod_id,model_no,color_code,size,frame_type,color_id,prod_status,price,stock_code from " . $this->cls_tbl." where 1 = 1";
	
			//$qry="select * from " . $this->cls_tbl." where ";
			//echo $qry;
			
			
			$use_cond = " and ";
		
			$join_qry = " and (";
			
			$join_qry_st = 0;
			
			//search with order status - Start
			/*if($_SESSION['ses_frame_srch_vars']['prod_status'] != "")
			{
				$join_qry .= "prod_status ='".stripslashes($_SESSION['ses_frame_srch_vars']['prod_status'])."'";
				$join_qry_st = 1;
				//$join_qry .= stripslashes($_SESSION['ses_frame_srch_vars']['prod_status']);
				//$join_qry_st = 1;
				
			}
			*/
			//search with order status - End
		
			/*if(!empty($_SESSION['ses_frame_srch_vars']['model_no']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
		
				$join_qry .= "color_code ='".stripslashes($_SESSION['ses_frame_srch_vars']['model_no'])."'";
				$join_qry_st = 1;
			}
			
			*/
			
			if(!empty($_SESSION['ses_frame_srch_vars']['model_no']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
			$join_qry .= "(model_no LIKE '%".$_SESSION['ses_frame_srch_vars']['model_no']."%' OR color_code LIKE '%".$_SESSION['ses_frame_srch_vars']['model_no']."%' OR stock_code LIKE '%".$_SESSION['ses_frame_srch_vars']['model_no']."%') ";
			//echo $join_qry;
			//exit();
			
			
				$join_qry_st = 1;
			}
			
			

		
			if(!empty($_SESSION['ses_frame_srch_vars']['gen_id']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
				$gender_id = $_SESSION['ses_frame_srch_vars']['gen_id'];
				//$join_qry .= "concat(',',gen_id,',') like '%,".$_SESSION['ses_frame_srch_vars']['gen_id'].",%'";
				$join_qry .= "(gen_id like '%,".$gender_id.",%' OR gen_id like '" . $gender_id.",%'  OR gen_id like '," . $gender_id ."%') " ;
				$join_qry_st = 1;
			}
			
			if(!empty($_SESSION['ses_frame_srch_vars']['sprin_loaded']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
		
				$join_qry .= "sprin_loaded ='".stripslashes($_SESSION['ses_frame_srch_vars']['sprin_loaded'])."'";
				$join_qry_st = 1;
			}
			
			
			if(!empty($_SESSION['ses_frame_srch_vars']['prod_status']))
			{
				if($join_qry_st == 1)
					$join_qry .= $use_cond;
		
				//$join_qry .= "prod_status ='".stripslashes($_SESSION['ses_frame_srch_vars']['prod_status'])."'";
				$join_qry .= stripslashes($_SESSION['ses_frame_srch_vars']['prod_status']);
				$join_qry_st = 1;
			}
			
			
			if($join_qry_st != 1)
			$join_qry .= "1=1";
			
			$join_qry .= ")";
		
			//add sorting to the query - Start
			if(!empty($_SESSION['ses_frame_srch_vars']['sort_column']))
			{
				$join_qry .= " order by " . $_SESSION['ses_frame_srch_vars']['sort_column'] ;
			}
			//add sorting to the query - End
		
		
			$final_qry = $qry . $join_qry;
			//echo $final_qry;
			//exit();
			$_SESSION['ses_frame_srch_qry'] = $final_qry;
			return $final_qry;
			
		$GLOBALS['logger_obj']->debug('<br>METHOD customer_master::search_qurey() - Return Value : ', $ret_val);
		return $ret_val;	
		
	
	}
	
				
}

?>
