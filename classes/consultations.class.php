<?php
//for email
if(file_exists("classes/email.class.php"))
	require_once("classes/email.class.php");
else if(file_exists("./classes/email.class.php"))
	require_once("./classes/email.class.php");
else if(file_exists("../classes/email.class.php"))
	require_once("../classes/email.class.php");

class consultations extends database_manipulation
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

	var $consultation_id;

	var $order_id;

	var $consultation_type;
	
	var $user_fname;

	var $user_lname;

	var $email_address;

	var $phone;

	var $prefered_start_dt;

	var $prefered_end_dt;
	
	var $consultation_reason;
	
	var $consultation_status;
	
	var $reply_subject;
	
	var $reply_message;
	
	var $date_entered;

	var $date_modified;

	function consultations()
	{

		$this->frm_name = "consultations_frm";

		$this->cls_tbl = "consultations";

		$this->cls_sql = "select * from " . $this->cls_tbl . " where 1 = 1 ";

		$this->unique_flds = "";

		$this->file_flds = "";

		$this->reference_tables = "";

		$this->primary_fld = "consultation_id";

		$this->attachment_h = "110";

		$this->attachment_w = "110";

		$this->attachment_s = "5524288";

		$this->attachment_conditions = "shw";
		
		$this->image_copies = array();

		$this->upload_msgs = array();

		$this->attachment_path = "uploads/admin_files/";

		$this->consultation_id = array("frm_fldname" => "consultation_id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->order_id = array("frm_fldname" => "order_id", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->consultation_type = array("frm_fldname" => "consultation_type", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->user_fname = array("frm_fldname" => "user_fname", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->user_lname = array("frm_fldname" => "user_lname", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->email_address = array("frm_fldname" => "email_address", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->phone = array("frm_fldname" => "phone", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->prefered_start_dt = array("frm_fldname" => "prefered_start_dt", "fld_type" => "date", "frm_fld_type" => "text", "save_todb" => "true", "value" => "");

		$this->prefered_end_dt = array("frm_fldname" => "prefered_end_dt", "fld_type" => "date", "frm_fld_type" => "text", "save_todb" => "true", "value" => "");

		$this->consultation_reason = array("frm_fldname" => "consultation_reason", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->consultation_status = array("frm_fldname" => "consultation_status", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => ""); //0 - new request received, 1 - replied to the request, 2 - consultation is over

		$this->reply_subject = array("frm_fldname" => "reply_subject", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->reply_message = array("frm_fldname" => "reply_message", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->date_entered = array("frm_fldname" => "date_entered", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

		$this->date_modified = array("frm_fldname" => "date_modified", "fld_type" => "str", "frm_fld_type" => "text", "save_todb" => "false", "value" => "");

	}

	function insert($param="request",$param_obj="")
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD consultations::insert() - PARAMETER LIST : ', $param_array);

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
		
			frame_notices("Consultation already exists !!", "redfont",1);
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_consult_obj'][$ky] = $vl;
			
			$ret_val = false;
		}
		else
		{
			
			$resultset = database_manipulation::insert_record($this,$param,$param_obj);
			
			$t = count($resultset);
			$ret_val = true;
			//echo $t . "<hr>";
			if($t == 1)
			{
				$ret_val = false;
				frame_notices("Book not added due to the following reasons!!", "redfont",1);
				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_consult_obj'][$ky] = $vl;
			}
			else
			{			
				
				//unset($_SESSION['ses_temp_consult_obj']);
				
				//frame_notices("Book successfully added !!", "greenfont", 1);
	
				$ret_val = true;
			}
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD consultations::insert() - Return Value : ', $ret_val);

		return $ret_val;
	
	}


	function fetch_record($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD consultations::fetch_record() - PARAMETER LIST : ', $param_array);

		$condition = $this->primary_fld . " = '" . $id . "'";
		
		$res = database_manipulation::fetch_flds($this->cls_tbl, "*", $condition);
		
		$GLOBALS['logger_obj']->debug('<br>METHOD consultations::fetch_record() - Return Value : ', $res);

		return $res;
	
	}
	
	function update($id)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD consultations::update() - PARAMETER LIST : ', $param_array);
		
		if($id > 0)
		{
			//need to check the uniqueness for username and email...
			
			$ufld_arr = explode(",", $this->unique_flds);
			$chk_val = "";
			
			foreach($ufld_arr as $key => $val)
				{
			$author_ex[] = database_manipulation::record_exists($this->cls_tbl, $val, $_REQUEST[$val],$this->primary_fld, $id,"update");
				$chk_val .= $_REQUEST[$val] . ",";
			}
			$author_n_e = $author_ex[0];
			$author_c_e = $author_ex[1];
			
			$chk_val = substr($chk_val, 0, -1);
			
		if (($author_n_e) ||($author_c_e))
		{
				frame_notices("Author already exists  !!", "redfont");

				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_temp_author_obj'][$ky] = $vl;

				$ret_val = false;
			}
			else
			{

				unset($_SESSION['ses_temp_author_obj']);
				
				$cond = $this->primary_fld . " = '" . $id . "'";
				
				$resultset = database_manipulation::update_record($this, $cond);
				
				//$dwnld_link_email = $GLOBALS['db_con_obj']->fetch_field("order_master", "ship_email", "order_id = '" . $_REQUEST['order_id'] . "'");
				$dwnld_link_email = $GLOBALS['db_con_obj']->fetch_field($this->cls_tbl, "email_address", $cond);
				$eml_cls = new email();
				$eml_cls->email_type = 'text';
				$eml_cls->email_subject = stripslashes($_REQUEST['reply_subject']);
				$eml_cls->email_message = stripslashes($_REQUEST['reply_message']);
			
				$eml_cls->send_email($dwnld_link_email); 
				
				frame_notices("Your reply to the consultations request has been posted successfully !!", "greenfont");

				$ret_val = true;
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD consultations::update() - Return Value : ', $ret_val);

		return $ret_val;
		
	}

	function change_status($cid)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD consultations::change_status() - PARAMETER LIST : ', $param_array);

		if($cid > 0)
		{
			$qry = "update " . $this->cls_tbl . " set consultation_status = '2' where " . $this->primary_fld . " = '" . $cid . "'";
			
			$GLOBALS['db_con_obj']->execute_sql($qry, "update");
			
			frame_notices("Selected consultation has been marked as completed !!", "greenfont");
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD consultations::change_status() - Return Value : ', 'Marks the consultation as over and Returns void');

	}

}

?>