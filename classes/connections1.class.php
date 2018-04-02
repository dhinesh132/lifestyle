<?php



//global $img_obj;



//$img_obj = new images();



class database_manipulation

{

	

	//member variables - Start

	

	var $serevername;

	

	var $dbname;

	

	var $dbusername;

	

	var $dbpassword;



	var $dbresource_id;



	//member variables - End

	

	//Constructor - Start

	

	function database_manipulation($server_name='', $db_name='', $db_username='', $db_password='')

	{

		

		if(strlen($server_name) <= 0)

		 $server_name = $GLOBALS['site_config']['database_server'];

		

		if(strlen($db_name) <= 0)

		 $db_name = $GLOBALS['site_config']['database_name'];

		

		if(strlen($db_username) <= 0)

		$db_username = $GLOBALS['site_config']['database_username'];

		

		if(strlen($db_password) <= 0)

		$db_password = $GLOBALS['site_config']['database_password'];

		

		$this->serevername = $server_name;

	

		$this->dbname = $db_name;

	

		$this->dbusername = $db_username;

	

		$this->dbpassword = $db_password;

		

		$this->dbresource_id = $this->connect_db();

		

	}

	

	//Constructor - End

	

	/**********************************************************************************************



							Method To Establish Database Connection.



	***********************************************************************************************/

	

	function connect_db()

	{

		

		$param_array = func_get_args();

		//$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::connect_db() - PARAMETER LIST : ', $param_array, true);

		

		$error_title = 'Error In Method : database_manipulation::connect_db()';

		$error_str = '';

		

		$con = mysql_connect("serevername",$this->dbusername,$this->dbpassword);

		

		$error_str .= mysql_error();

		

		$res = mysql_select_db($this->dbname, $con);



		$error_str .= mysql_error();

		

		//log errors...

		$GLOBALS['logger_obj']->error($error_title, $error_str, 'mysql');

		

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::connect_db() - Return Value : ', $con, true);



		return $con;



	}//end function connect_db



	



	/**********************************************************************************************



			Method To Frame Insert Sql Statement for Table of any Structure depending on the 

			membervariables set for that table's class.



	***********************************************************************************************/



	function insert_record($obj,$param_method="request",$param_obj="")

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::insert_record() - PARAMETER LIST : ', $param_array);

		

		$initial_qry = "insert into " . $obj->cls_tbl . " (";

		

		$obj = set_values($obj,$param_method,$param_obj,"insert");



		$fld_arr = get_object_vars($obj);



		$qry_fld_list = "";

		$mid_qry = ") values (";

		$qry_val_list = "";

		$file_attachment_status = 1;

		//added on 26-04-2007

		$del_file_name = array();

		//end

		foreach($fld_arr as $key => $value)

		{

		

			if(is_array($value) && strtolower($key) != "image_copies"  && strtolower($key) != "image_dimensions" && strtolower($key) != "upload_msgs")

			{

				

				//print_r($_REQUEST);

				

				//if(1 == 1 || isset($GLOBALS['param_arr'][$value['frm_fldname']]) || (!isset($GLOBALS['param_arr'][$value['frm_fldname']]) && $value['save_todb'] == 'true'))

				//if(isset($value['value']) && !$value['save_todb'])

				{

					

					//27012007 - need to handle file fields. - Start



					if(strtolower($value['frm_fld_type']) == "file" && $_FILES[$value['frm_fldname']]['size'] > 0)

					{

						

						if($obj->image_dimensions[$value['frm_fldname']]['s'] > 0)

							$s = $obj->image_dimensions[$value['frm_fldname']]['s'];

						else if($obj->attachment_s > 0)

							$s = $obj->attachment_s;

						else

							$s = $GLOBALS['site_config']['files_allowed_size'];

						

						$temp_file_name = $GLOBALS['img_obj']->upload_file($obj, $value['frm_fldname'], $value['frm_fld_type'], "s", $s);

						$value['value'] = $temp_file_name;

						//added on 26-04-2006

						$del_file_name[] = $value['value'];

						//end

						if($temp_file_name == "File Not Uploaded.")

						$file_attachment_status = 0;

						

					}

					else if((strtolower($value['frm_fld_type']) == "img" || strtolower($value['frm_fld_type']) == "imgcopy") && $_FILES[$value['frm_fldname']]['size'] > 0)

					{

						

						if($obj->image_dimensions[$value['frm_fldname']]['s'] > 0)

							$s = $obj->image_dimensions[$value['frm_fldname']]['s'];

						else if($obj->attachment_s > 0)

							$s = $obj->attachment_s;

						else

							$s = $GLOBALS['site_config']['files_allowed_size'];

						

						if($obj->image_dimensions[$value['frm_fldname']]['h'] > 0)

							$h = $obj->image_dimensions[$value['frm_fldname']]['h'];

						else if($obj->attachment_h > 0)

							$h = $obj->attachment_h;

						else

							$h = $GLOBALS['site_config']['files_allowed_h'];

						

						if($obj->image_dimensions[$value['frm_fldname']]['w'] > 0)

							$w = $obj->image_dimensions[$value['frm_fldname']]['w'];

						else if($obj->attachment_w > 0)

							$w = $obj->attachment_w;

						else

							$w = $GLOBALS['site_config']['files_allowed_w'];



						if(strtolower($value['frm_fld_type']) == "imgcopy" && $obj->image_copies[$value['frm_fldname']][0] > 0 && $_FILES[$value['frm_fldname']]['size'] > 0)

						{

							

							$ret_val = $GLOBALS['img_obj']->upload_file($obj, $value['frm_fldname'], $value['frm_fld_type'], "s", $s);
						if($ret_val == "File Not Uploaded.")

						$file_attachment_status = 0;
						
						}

						else if(strtolower($value['frm_fld_type']) == "img")

						{

							//$value['value'] = $GLOBALS['img_obj']->upload_file($obj, $value['frm_fldname'], $value['frm_fld_type'], $obj->attachment_conditions, $s, $h, $w);

							

							$attach_cond = $obj->image_dimensions[$value['frm_fldname']]['chk_cond'];

							

							if(strlen(trim($attach_cond)) <= 0)

							$attach_cond = $obj->attachment_conditions;

							

							$temp_file_name = $GLOBALS['img_obj']->upload_file($obj, $value['frm_fldname'], $value['frm_fld_type'], $attach_cond, $s, $h, $w);

							$value['value'] = $temp_file_name;

							//added on 26-04-2006

							$del_file_name[] = $value['value'];

							//end

							if($temp_file_name == "File Not Uploaded.")

							$file_attachment_status = 0;

							

						}

							



					}

					

					//27012007 - need to handle file fields. - End



					if((((strtolower($value['frm_fld_type']) == "file" || strtolower($value['frm_fld_type']) == "img") && $_FILES[$value['frm_fldname']]['size'] > 0 && trim($value['value']) != "File Not Uploaded.") || !(strtolower($value['frm_fld_type']) == "file" || strtolower($value['frm_fld_type']) == "img")) && $value['value'] != "do_not_frame_in_sql" && strtolower($value['frm_fld_type']) != "imgcopy")

					{

						$qry_fld_list .= $key . ", ";

						$qry_val_list .= "'" . wrap_values($value['value']) . "', ";

					}

					else if(strtolower($value['frm_fld_type']) == "imgcopy" && $_FILES[$value['frm_fldname']]['size'] > 0)

					{

						foreach($ret_val as $imgc_key => $imgc_val)

						{

							$qry_fld_list .= $imgc_key . ", ";

							$qry_val_list .= "'" . wrap_values($imgc_val) . "', ";

							//added on 26-04-2006

							$del_file_name[] = $imgc_val;

							//end

						}

					}



				}



			}

		

		}//end foreach

		

		$qry_fld_list = substr($qry_fld_list, 0, -2);

		$qry_val_list = substr($qry_val_list, 0, -2);

		

		$final_insert_query = $initial_qry . $qry_fld_list . $mid_qry . $qry_val_list . ")";

		

		if($file_attachment_status == 1)//10042007

			$res = $this->execute_sql($final_insert_query,"insert");

		else

		{

			//added on 26-04-2006

			foreach($del_file_name as $key => $del_value)

			{

				$del_filename = $del_value;

				$del_filepath = $obj->attachment_path . $del_filename;

				

				if(file_exists($del_filepath) && is_file($del_filepath))

				unlink($del_filepath);

			}//end

			

			$res = array("insertion failed");

		}

		

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::insert_record() - Return Value : ', $res);

		

		return $res;

		

	}

	

	/**********************************************************************************************



			Method To Frame Update Sql Statement for Table of any Structure depending on the 

			membervariables set for that table's class.



	***********************************************************************************************/





	function update_record($obj, $where_condition, $param_method='request')

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::update_record() - PARAMETER LIST : ', $param_array);



		$initial_qry = "update " . $obj->cls_tbl . " set ";

		

		$obj = set_values($obj,$param_method);



		$fld_arr = get_object_vars($obj);



		$qry_fval_list = "";

		$file_attachment_status = 1;

		foreach($fld_arr as $key => $value)

		{

			

			if(is_array($value) && strtolower($key) != "image_copies"  && strtolower($key) != "image_dimensions" && strtolower($key) != "upload_msgs")

			{

				//if(isset($GLOBALS['param_arr'][$value['frm_fldname']]) || (!isset($GLOBALS['param_arr'][$value['frm_fldname']]) && $value['save_todb'] == 'true'))

				{



					//27012007 - need to handle file fields. - Start

					if($value['frm_fld_type'] == "file" && $_FILES[$value['frm_fldname']]['size'] > 0)

					{

						

						if($obj->image_dimensions[$value['frm_fldname']]['s'] > 0)

							$s = $obj->image_dimensions[$value['frm_fldname']]['s'];

						else if($obj->attachment_s > 0)

							$s = $obj->attachment_s;

						else

							$s = $GLOBALS['site_config']['files_allowed_size'];

						

						$temp_file_name = $GLOBALS['img_obj']->upload_file($obj, $value['frm_fldname'], $value['frm_fld_type'], "s", $s);

						$value['value'] = $temp_file_name;

						//added on 26-04-2006

						$del_file_name[] = $value['value'];

						//end

						if($temp_file_name == "File Not Uploaded.")

						$file_attachment_status = 0;

						

					}

					else if((strtolower($value['frm_fld_type']) == "img" || strtolower($value['frm_fld_type']) == "imgcopy") && $_FILES[$value['frm_fldname']]['size'] > 0)

					{

						

						if($obj->image_dimensions[$value['frm_fldname']]['s'] > 0)

							$s = $obj->image_dimensions[$value['frm_fldname']]['s'];

						else if($obj->attachment_s > 0)

							$s = $obj->attachment_s;

						else

							$s = $GLOBALS['site_config']['files_allowed_size'];

						

						if($obj->image_dimensions[$value['frm_fldname']]['h'] > 0)

							$h = $obj->image_dimensions[$value['frm_fldname']]['h'];

						else if($obj->attachment_h > 0)

							$h = $obj->attachment_h;

						else

							$h = $GLOBALS['site_config']['files_allowed_h'];

						

						if($obj->image_dimensions[$value['frm_fldname']]['w'] > 0)

							$w = $obj->image_dimensions[$value['frm_fldname']]['w'];

						else if($obj->attachment_w > 0)

							$w = $obj->attachment_w;

						else

							$w = $GLOBALS['site_config']['files_allowed_w'];



						

//						$value['value'] = $GLOBALS['img_obj']->upload_file($obj, $value['frm_fldname'], $value['frm_fld_type'], $obj->attachment_conditions, $s, $h, $w);



						if(strtolower($value['frm_fld_type']) == "imgcopy" && $obj->image_copies[$value['frm_fldname']][0] > 0)

						{

							

							$ret_val = $GLOBALS['img_obj']->upload_file($obj, $value['frm_fldname'], $value['frm_fld_type'], "s", $s);

							if($ret_val == "File Not Uploaded.")

							$file_attachment_status = 0;
						}

						else if(strtolower($value['frm_fld_type']) == "img")

						{



							//$value['value'] = $GLOBALS['img_obj']->upload_file($obj, $value['frm_fldname'], $value['frm_fld_type'], $obj->attachment_conditions, $s, $h, $w);attach_cond



							$attach_cond = $obj->image_dimensions[$value['frm_fldname']]['chk_cond'];

							

							if(strlen(trim($attach_cond)) <= 0)

							$attach_cond = $obj->attachment_conditions;

							

							$temp_file_name = $GLOBALS['img_obj']->upload_file($obj, $value['frm_fldname'], $value['frm_fld_type'], $attach_cond, $s, $h, $w);

							$value['value'] = $temp_file_name;

							//added on 26-04-2006

							$del_file_name[] = $value['value'];

							//end

							if($temp_file_name == "File Not Uploaded.")

							$file_attachment_status = 0;

						}



					}

					

					

					//27012007 - need to handle file fields. - End

					if((((strtolower($value['frm_fld_type']) == "file" || strtolower($value['frm_fld_type']) == "img") && $_FILES[$value['frm_fldname']]['size'] > 0 && trim($value['value']) != "File Not Uploaded.") || !(strtolower($value['frm_fld_type']) == "file" || strtolower($value['frm_fld_type']) == "img")) && $value['value'] != "do_not_frame_in_sql" && strtolower($value['frm_fld_type']) != "imgcopy")

					{

						$qry_fval_list .= $key . " = '" . wrap_values($value['value']) . "', ";

					}

					else if(strtolower($value['frm_fld_type']) == "imgcopy" && $_FILES[$value['frm_fldname']]['size'] > 0)

					{

						foreach($ret_val as $imgc_key => $imgc_val)

						{

							$qry_fval_list .= $imgc_key . " = '" . wrap_values($imgc_val) . "', ";

							//added on 26-04-2006

							$del_file_name[] = $imgc_val;

							//end

						}

					}



				}

			}

		

		}//end foreach
		

		if($file_attachment_status == 1)

		{//only if newer files are uploaded need to delete the older ones.

		foreach($fld_arr as $key => $value)

		{

			if((strtolower($value['frm_fld_type']) == "file" || strtolower($value['frm_fld_type']) == "img" || strtolower($value['frm_fld_type']) == "imgcopy") && $_FILES[$value['frm_fldname']]['size'] > 0 && strlen(trim($value['value'])) != "File Not Uploaded.")

			{

				$del_fld = $key;

				if(strtolower($value['frm_fld_type']) == "imgcopy")

				{

					

					$fld_arr = explode(",", $obj->image_copies[$value['frm_fldname']][1]);

					$flds = "";

					foreach($fld_arr as $d_k => $d_v)

					{

						$d_arr = explode("|", $d_v);

						$flds .= $d_arr[0] . ",";

					}

					

					$flds = substr($flds, 0, -1);

					

					$del_fld = $flds;

					

				}

				

				$del_fileres = $this->fetch_flds($obj->cls_tbl, $del_fld, $where_condition);

				

				$del_file_data = mysql_fetch_assoc($del_fileres[0]);

				

				foreach($del_file_data as $del_key => $del_value)

				{

				

				$del_filename = $del_value;

				$del_filepath = $obj->attachment_path . $del_filename;

				

				if(file_exists($del_filepath) && is_file($del_filepath))

				unlink($del_filepath);

				

				}

			}

		}

		}//end if

		

		$qry_fval_list = substr($qry_fval_list, 0, -2);

		

		$final_update_query = $initial_qry . $qry_fval_list . " where " . $where_condition;

		

		if($file_attachment_status == 1)

			$res = $this->execute_sql($final_update_query,"update");

		else

		{

			//added on 26-04-2006

			foreach($del_file_name as $key => $del_value)

			{

				$del_filename = $del_value;

				$del_filepath = $obj->attachment_path . $del_filename;

				

				if(file_exists($del_filepath) && is_file($del_filepath))

				unlink($del_filepath);

			}//end

			$res = array("updation failed");

		}

		

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::update_record() - Return Value : ', $res);

		

		return $res;

		

	}

	

	/**********************************************************************************************



			Method To Frame Delete Sql Statement for Table of any Structure depending on the 

			membervariables set for that table's class. Deletes the files related to this table.



	***********************************************************************************************/



	function delete_record($obj,$val)

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::delete_record() - PARAMETER LIST : ', $param_array);



		$where = $obj->primary_fld . " = '" . $val . "'";

		$deleted = false;

		if(strlen(trim($obj->file_flds)) > 0)

		{

			

			$this->delete_files($obj, $where);

			

			/*

			$res = $this->fetch_flds($obj->cls_tbl, $obj->file_flds, $where);

			

			$fld_count = count(explode(",", $obj->file_flds));



			while($data = mysql_fetch_row($res[0]))

			{

				for($i = 0;$i < $fld_count; $i++)

				{

					$file_path = $obj->attachment_path . $data[$i];

					

					if(file_exists($file_path) && is_file($file_path))

					unlink($file_path);

				}

			}

			*/

		}

		

		if(strlen(trim($obj->reference_tables)) > 0)

		{

			

			$ref_arr = explode(",", $obj->reference_tables);		

			

			foreach($ref_arr as $ky => $vl)

			{

			

				$ref_tbl = explode("|", $vl);

				

				$cls_file_name = $ref_tbl[0] . ".class.php";

				

				if(file_exists("classes/" . $cls_file_name))

				

					require_once("classes/" . $cls_file_name);

					

				else

				

					require_once("../classes/" . $cls_file_name);

				

				$t_obj = new $ref_tbl[0]();

				

				if(count($ref_tbl) == 3 && $ref_tbl[2] == 1)

				{//reference table contains file fields and those files should be deleted..

					

					$t_where = $ref_tbl[1] . " = '" . $val . "'";

					$this->delete_files($t_obj, $t_where);

					

				}



				$qry = "delete from " . $t_obj->cls_tbl . " where " . $ref_tbl[1] . " = '" . $val . "'";

				$this->execute_sql($qry, "delete");



			

			}

			

		}

		

		

		$sql = "delete from " . $obj->cls_tbl . " where " . $where;

		

		$res = $this->execute_sql($sql,"delete");

		$temp_res = $res;

		$deleted = true;

		$temp_res[] = $deleted;

		

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::delete_record() - Return Value : ', $temp_res);



		return $deleted;

	}

	

	/**********************************************************************************************



			Method To Fetch the required fields from a table.



	***********************************************************************************************/



	function fetch_flds($tbl_name, $flds, $where_condition)

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::fetch_flds() - PARAMETER LIST : ', $param_array);



		$qry = "select " . $flds . " from " . $tbl_name . " where 1 = 1 and " . $where_condition;

		

		$res = $this->execute_sql($qry);

		

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::fetch_flds() - Return Value : ', $res);



		return $res;

	

	}

	

	/**********************************************************************************************



			Method to check the uniqueness of a db field value. Like checking uniqueness for email, username, etc



	***********************************************************************************************/



	function record_exists($tbl_name, $chk_flds, $chk_vals, $primary_fld="id", $primary_val="", $while="insert", $use_cond="and")

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::record_exists() - PARAMETER LIST : ', $param_array);



		$qry = "select " . $chk_flds . " from " . $tbl_name . " where 1 = 1 ";

		

		$fld_arr = explode(",", $chk_flds);

		

		$val_arr = explode(",", $chk_vals);

		

		$where_part = " and (";

		

		foreach($fld_arr as $k => $v)

		{

			$where_part .= $v . " = '" . wrap_values(trim($val_arr[$k])) . "' " . $use_cond . " ";

		}

		

		$where_part = substr($where_part,0,(0 - (strlen($use_cond) + 2))) . ")";

		

		if($while == "update")

		{

			$where_part .= " and " . $primary_fld . " <> '" . wrap_values(trim($primary_val)) . "'";

		}

		

		$qry .= $where_part;

		

		$arr = $this->execute_sql($qry);

		

		if($arr[1] > 0)

	

			$ret_val = true;

			

		else

		

			$ret_val = false;

		

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::record_exists() - Return Value : ', $ret_val);



		return $ret_val;

		

	}

	

	/**********************************************************************************************



			Method to execute sqls. If any error occurs, then those errors will be logged.



	***********************************************************************************************/

	

	function execute_sql($qry, $purpose="select")

	{



		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::execute_sql() - PARAMETER LIST : ', $param_array, true);



		$error_title = 'Error In Method : database_manipulation::execute_sql()';

		

		$res = mysql_query($qry);

		

		$error_str = '';

		

		$error_str .= mysql_error();

		

		$no_rows = 0;

		switch($purpose)

		{

		

			case "select":

				$no_rows = mysql_num_rows($res);

				break;

				

			case "insert":

				$no_rows = mysql_affected_rows();

				$insert_id = mysql_insert_id();

				break;

				

			case "update":

				$no_rows = mysql_affected_rows();

				break;

				

			case "delete":

				$no_rows = mysql_affected_rows();

				break;

				

		} //end switch

		

		$error_str .= mysql_error();



		if($purpose == "insert")

			

			$temp_arr = array($res, $no_rows, $insert_id);

		

		else

		

			$temp_arr = array($res, $no_rows);

		

		if(strlen($error_str) > 0)

		$error_str .= "<br>SQL STATEMENT : " . $qry;

		

		//optimize the database, so that no overhead will be there after the record deletion..

		if($purpose == "delete")

		{

			//$optimize_qry = "optimize ";

			$this->optimize_database();

		}

		

		$GLOBALS['logger_obj']->error($error_title, $error_str, 'mysql');

		

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::execute_sql() - Return Value : ', $temp_arr, true);



		return $temp_arr;

	

	}

		

	/**********************************************************************************************



			Method To Fetch a single field from a table.



	***********************************************************************************************/



	function fetch_field($tbl_name, $flds, $where_condition)

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::fetch_field() - PARAMETER LIST : ', $param_array);



		$qry = "select " . $flds . " from " . $tbl_name . " where 1 = 1 and " . $where_condition;

		

		$res = $this->execute_sql($qry);

		

		$data = mysql_fetch_array($res[0]);

		

		//$ret_val = $data->$flds;

		$ret_val = $data[0];

		

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::fetch_field() - Return Value : ', $ret_val);



		return $ret_val;

	

	}

	

	/**********************************************************************************************



			Method to frame the search sql statements dynamically.



	***********************************************************************************************/

	

	function delete_files($obj,$where)

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::delete_files() - PARAMETER LIST : ', $param_array);



		if(strlen(trim($obj->file_flds)) > 0)

		{

			

			$res = $this->fetch_flds($obj->cls_tbl, $obj->file_flds, $where);

			

			$fld_count = count(explode(",", $obj->file_flds));



			while($data = mysql_fetch_row($res[0]))

			{

				for($i = 0;$i < $fld_count; $i++)

				{

					$file_path = $obj->attachment_path . $data[$i];

					

					if(file_exists($file_path) && is_file($file_path))

					unlink($file_path);

				}

			}

		

		}

		

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::delete_files() - Return Value : ', 'Deletes all the attachments made to the particular record and returns void');



	}

	

	/**********************************************************************************************



			Method to frame the search sql statements dynamically.



	***********************************************************************************************/



	function frame_search_sql($obj)

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::frame_search_sql() - PARAMETER LIST : ', $param_array);

	

		if($obj->get_search_types[0]['search_condition'] == "depend_object_setting" && is_array($obj->search_types))

		{

			

			$str = "";

			

			$_SESSION[$obj->srch_ses_val] = array();

			

			$start = 0;

			

			$enter_switch = 0;

			

			foreach($obj->search_types as $key => $value)

			{

				$enter_switch = 0;

				if(strtolower($obj->match_case) == "yes")

				{

					$fld_name = $_REQUEST[$value['tbl_fld_name']];

					$fld_value = $_REQUEST[$value['tbl_fld_value']];

				}

				else

				{

					$fld_name = strtolower($_REQUEST[$value['tbl_fld_name']]);

					$fld_value = strtolower($_REQUEST[$value['tbl_fld_value']]);

				}

				

				if($key == "between")

				{

					$fld_value_frm = stripslashes($_REQUEST[$value['tbl_fld_value_frm']]);

					$fld_value_to = stripslashes($_REQUEST[$value['tbl_fld_value_to']]);



					if(strlen($fld_name) > 0 && strlen($fld_value_frm) > 0 && strlen($fld_value_to) > 0)

					{

					$_SESSION[$obj->srch_ses_val][$key] = array('tbl_fld_name' => stripslashes($_REQUEST[$value['tbl_fld_name']]), 'tbl_fld_value_frm' => $fld_value_frm, 'tbl_fld_value_to' => $fld_value_to);

					$enter_switch = 1;

					}



				}

				else if(strlen($fld_name) > 0 && strlen($fld_value) > 0)

				{

					$_SESSION[$obj->srch_ses_val][$key] = array('tbl_fld_name' => stripslashes($_REQUEST[$value['tbl_fld_name']]), 'tbl_fld_value' => stripslashes($_REQUEST[$value['tbl_fld_value']]));

					$enter_switch = 1;

				}

				

				if($enter_switch == 1)

				{



					switch ($key)

					{

						

						case "contains":

							if($start == 0)

							{

								$str .= " and (";

								$start = 1;

							}

							else

							{

								$str .= " " . $obj->search_cond . " ";

							}

							

							if($obj->match_case == "yes")

								$str .= $fld_name . " like '" . wrap_values("%" . str_replace(' ', '%', $fld_value) . "%") . "'";

							else

								$str .= "lower(" . $fld_name . ") like '" . wrap_values("%" . str_replace(' ', '%', $fld_value) . "%") . "'";

							break;

						

						case "startswith":

							if($start == 0)

							{

								$str .= " and (";

								$start = 1;

							}

							else

							{

								$str .= " " . $obj->search_cond . " ";

							}

							

							if($obj->match_case == "yes")

								$str .= $fld_name . " like '" . wrap_values($fld_value . "%") . "'";

							else

								$str .= "lower(" . $fld_name . ") like '" . wrap_values($fld_value . "%") . "'";

							break;

						

						case "endswith":

							if($start == 0)

							{

								$str .= " and (";

								$start = 1;

							}

							else

							{

								$str .= " " . $obj->search_cond . " ";

							}

							

							if($obj->match_case == "yes")

								$str .= $fld_name . " like '" . wrap_values("%" . $fld_value) . "'";

							else

								$str .= "lower(" . $fld_name . ") like '" . wrap_values("%" . $fld_value) . "'";

							break;

						

						case "equalto":

							if($start == 0)

							{

								$str .= " and (";

								$start = 1;

							}

							else

							{

								$str .= " " . $obj->search_cond . " ";

							}

							

							if($obj->match_case == "yes")

								$str .= $fld_name . " = '" . wrap_values($fld_value) . "'";

							else

								$str .= "lower(" . $fld_name . ") = '" . wrap_values($fld_value) . "'";

							break;

						

						case "lessthan": //since numeric fields can only be compared for <, > and between case match is not checked.

							if($start == 0)

							{

								$str .= " and (";

								$start = 1;

							}

							else

							{

								$str .= " " . $obj->search_cond . " ";

							}

							

							$str .= $fld_name . " < '" . wrap_values($fld_value) . "'";

							break;

						

						case "greaterthan":

							if($start == 0)

							{

								$str .= " and (";

								$start = 1;

							}

							else

							{

								$str .= " " . $obj->search_cond . " ";

							}

							

							$str .= $fld_name . " > '" . wrap_values($fld_value) . "'";

							break;

						

						case "between":

							if($start == 0)

							{

								$str .= " and (";

								$start = 1;

							}

							else

							{

								$str .= " " . $obj->search_cond . " ";

							}

							

							$str .= $fld_name . " between '" . $fld_value_frm . "' and '" . $fld_value_to . "'";

							break;

						

						case "sort_by":

							$order_by_str = " " . $fld_name . " " . $fld_value;

							break;

						

					}//end switch			



				}//end if($enter_switch == 1)



			}//end foreach

		

		}//end if(is_array

		else if($obj->get_search_types[1]['search_condition'] == "depend_request" && is_array($obj->search_types))

		{

			

			$fld_name = $_REQUEST[$obj->get_search_types['search_condition_tbl_fld_name']];

			$fld_value = $_REQUEST[$obj->get_search_types['search_condition_tbl_fld_value']];

			$srch_typ = $_REQUEST[$obj->get_search_types['search_condition_fld_name']];

			

			$_SESSION[$obj->srch_ses_val]['depend_request'][$obj->get_search_types['search_condition_tbl_fld_name']] = $fld_name;

			$_SESSION[$obj->srch_ses_val]['depend_request'][$obj->get_search_types['search_condition_tbl_fld_value']] = $fld_value;



			switch ($srch_typ)

			{

				

				case "contains":

					if($start == 0)

					{

						$str .= " and (";

						$start = 1;

					}

					else

					{

						$str .= " " . $obj->search_cond . " ";

					}

					

					if($obj->match_case == "yes")

						$str .= $fld_name . " like '" . wrap_values("%" . str_replace(' ', '%', $fld_value) . "%") . "'";

					else

						$str .= "lower(" . $fld_name . ") like '" . wrap_values("%" . str_replace(' ', '%', $fld_value) . "%") . "'";

					break;

				

				case "startswith":

					if($start == 0)

					{

						$str .= " and (";

						$start = 1;

					}

					else

					{

						$str .= " " . $obj->search_cond . " ";

					}

					

					if($obj->match_case == "yes")

						$str .= $fld_name . " like '" . wrap_values($fld_value . "%") . "'";

					else

						$str .= "lower(" . $fld_name . ") like '" . wrap_values($fld_value . "%") . "'";

					break;

				

				case "endswith":

					if($start == 0)

					{

						$str .= " and (";

						$start = 1;

					}

					else

					{

						$str .= " " . $obj->search_cond . " ";

					}

					

					if($obj->match_case == "yes")

						$str .= $fld_name . " like '" . wrap_values("%" . $fld_value) . "'";

					else

						$str .= "lower(" . $fld_name . ") like '" . wrap_values("%" . $fld_value) . "'";

					break;

				

				case "equalto":

					if($start == 0)

					{

						$str .= " and (";

						$start = 1;

					}

					else

					{

						$str .= " " . $obj->search_cond . " ";

					}

					

					if($obj->match_case == "yes")

						$str .= $fld_name . " = '" . wrap_values($fld_value) . "'";

					else

						$str .= "lower(" . $fld_name . ") = '" . wrap_values($fld_value) . "'";

					break;

				

				case "lessthan": //since numeric fields can only be compared for <, > and between case match is not checked.

					if($start == 0)

					{

						$str .= " and (";

						$start = 1;

					}

					else

					{

						$str .= " " . $obj->search_cond . " ";

					}

					

					$str .= $fld_name . " < '" . wrap_values($fld_value) . "'";

					break;

				

				case "greaterthan":

					if($start == 0)

					{

						$str .= " and (";

						$start = 1;

					}

					else

					{

						$str .= " " . $obj->search_cond . " ";

					}

					

					$str .= $fld_name . " > '" . wrap_values($fld_value) . "'";

					break;

				

				case "between":

					if($start == 0)

					{

						$str .= " and (";

						$start = 1;

					}

					else

					{

						$str .= " " . $obj->search_cond . " ";

					}

					

					$str .= $fld_name . " between '" . $fld_value_frm . "' and '" . $fld_value_to . "'";

					break;

				

				case "sort_by":

					$order_by_str = " " . $fld_name . " " . $fld_value;

					break;

				

			}//end switch			



		}

		

		$group_by_qry = "";

		

		

		if($start == 1)

		$str .= ")";

		

		$qry = $obj->search_sql . $str . $group_by_qry . $order_by_str;

		

		$_SESSION[$obj->srch_ses_qry_str] = $qry;

		

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::frame_search_sql() - Return Value : ', 'Frames the search query in session and returns void');



	}//end function frame_search_sql

	

	function clear_search_sql($obj)

	{

		

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::clear_search_sql() - PARAMETER LIST : ', $param_array);

	

		unset($_SESSION[$obj->srch_ses_val]);

		unset($_SESSION[$obj->srch_ses_qry_str]);

		

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::clear_search_sql() - Return Value : ', 'Clears the search query in session and returns void');



	}

	

	/**********************************************************************************************



			Method to optimize the database.



	***********************************************************************************************/



	function optimize_database()

	{//12022007 - method added

		$qry = "show table status from " . $GLOBALS['db_con_obj']->dbname;

		$res = $this->execute_sql($qry);



		while($data = mysql_fetch_array($res[0]))

		{

			$q = "optimize table " . $data[0];

			$this->execute_sql($q);

		}

	}

	

	/**********************************************************************************************



			Method to close the mysql connection.



	***********************************************************************************************/



	function db_close()

	{

		$param_array = func_get_args();

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::db_close() - PARAMETER LIST : ', $param_array);



		$this->optimize_database();//12022007

		mysql_close($this->dbresource_id);

		

		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::db_close() - Return Value : ', 'Closing Database Connection and Returning Void.', true);

		

	}


	//28082007 - csv importing functionality - Start
	function import_csv($obj)
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::import_csv() - PARAMETER LIST : ', $param_array);
		
			$row = 0;
			
			$handle = fopen($obj->csv_file_path, "r");
			
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
			{
				
				if($row > 0)
				{
					
					$res = $this->fetch_flds($obj->cls_tbl, $obj->primary_fld, $obj->primary_fld . " = '" . $data[0] . "'");
					
					if($res[1] > 0)
					{//update the record
						$cond = $obj->primary_fld . " = '" . $data[0] . "'";
						database_manipulation::update_record($obj, $cond, "csv", $data);
					}
					else
					{//insert the record
						database_manipulation::insert_record($obj, "csv", $data);
					}
				
				}

				$row++;
			}
			
			fclose($handle);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD database_manipulation::import_csv() - Return Value : ', 'Importing Csv Data Into the Database.', true);

	}
	//28082007 - csv importing functionality - End



}



?>