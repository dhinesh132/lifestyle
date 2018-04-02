<?php



/*

 * This file contains the globakl functions that can be used anywhere in the site.

*/



//date_default_timezone_set("Europe/Paris");

$alpha = array(1 => "A", "B", "C", "D", "E", "F", "G","H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");



//$CONFIG_MONTH = array('Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr', 'May' => 'May', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Aug', 'Sep' => 'Sep', 'Oct' => 'Oct', 'Nov' => 'Nov', 'Dec' => 'Dec');



$CONFIG_MONTH = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');



$FILTER_OPTION = array('1' => 'Type', '2' => 'Age Limit', '3' => 'Theme', '4' => 'Furniture', '5' => 'AV & FX Equipment', '6' => 'F&B Equipment',  '8' => 'Balloons', '12' => 'Arches & Tubes','13'=>'Carnival Games','14'=>'Large Inflatables','15'=>'Banners','16'=>'Posters & Murals','17'=>'Scene Setters','18'=>'String Decorations','19'=>'Dangling Cutouts','20'=>'Swirls','21'=>'Partyware','22'=>'Pinatas','23'=>'Goodie Bags','24'=>'Carnival Food');





function wrap_values($str)

{

		

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD wrap_values() - PARAMETER LIST : ', $param_array);



	$ret_val = addslashes(stripslashes($str));



	$GLOBALS['logger_obj']->debug('<br>METHOD wrap_values() - RETURN VALUE : ', $ret_val);

	

	return $ret_val;



}



function get_current_logfile_name($typ="err")

{



	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD get_current_logfile_name() - PARAMETER LIST : ', $param_array);



    $set_file_size=512;

	

	$log_dt = date("mdY");

	

	switch ($typ)

	{

		case "err":

			$tmp_filename = "errorhandler_" . $log_dt;

			$filename = "errorhandler_" . $log_dt . ".html";

			break;



		case "pay":

			$tmp_filename = "payemntlog_" . $log_dt;

			$filename = "payemntlog_" . $log_dt . ".html";

			break;

	

		case "img":

			$tmp_filename = "imagelog_" . $log_dt;

			$filename = "imagelog_" . $log_dt . ".html";

			break;

	

		case "mysql":

			$tmp_filename = "mysqllog_" . $log_dt;

			$filename = "mysqllog_" . $log_dt . ".html";

			break;

	

		case "email":

			$tmp_filename = "emaillog_" . $log_dt;

			$filename = "emaillog_" . $log_dt . ".html";

			break;

	

		case "url":

			$tmp_filename = "urllog_" . $log_dt;

			$filename = "urllog_" . $log_dt . ".html";

			break;

	

		case "ups":

			$tmp_filename = "upslog_" . $log_dt;

			$filename = "upslog_" . $log_dt . ".html";

			break;

	

		case "file":

			$tmp_filename = "file_" . $log_dt;

			$filename = "file_" . $log_dt . ".html";

			break;

			

		case "cron":

			$tmp_filename = "cron_" . $log_dt;

			$filename = "cron_" . $log_dt . ".html";

			break;

			

	} //end switch

	

	$filename = "log/" . $filename;



/* Backup of the current log file should be taken as soon as file size exceeds the limit.

	if(file_exists($filename))

	{

		$file_size=trim(filesize($filename))/1024;

		if($file_size>$set_file_size)

		{

		  $new_filename="log/".$tmp_filename."_".date("his").".log";

		  if(copy($filename,$new_filename))

		  {

		    chmod($new_filename,0777);

			unlink($filename);

		  } 

		} 

	}

*/	

	if(!file_exists($filename))

	{



		$stylesheet_file = ($GLOBALS['in_admin'] == 1)?"../../style/styles.css":"../style/styles.css";

		

		$stext = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>

		<html>

		<head>

		<title>Logged on " . date("m/d/Y") . "</title>

		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>

		<link href='".$stylesheet_file."' type='text/css' rel='stylesheet'>

		</head>

		<body></body></html>";

		



		$handle = fopen($filename, "w");

		chmod($filename, 0777);



		if (fwrite($handle,$stext) === FALSE) {

				//echo "Cannot write to file ($filename)";

			}

		fclose($handle);

	}

	

	$GLOBALS['logger_obj']->debug('<br>METHOD get_current_logfile_name() - RETURN VALUE : ', $filename);



	return $filename;

	

}





function show_short_description($description_txt, $length)

{



	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD show_short_description() - PARAMETER LIST : ', $param_array);



	$temp_arr = explode(" ", $description_txt);

	

	$temp_str = "";

	$final_str = "";

	foreach($temp_arr as $value)

	{

	

		$temp_str .= $value . " ";



		if(strlen($temp_str) >= $length)

		break;

		

		$final_str = $temp_str;

	

	}

	

	$GLOBALS['logger_obj']->debug('<br>METHOD show_short_description() - RETURN VALUE : ', $final_str);



	return $final_str;



}







function get_ip_address($purpose="client")

{



	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD get_ip_address() - PARAMETER LIST : ', $param_array);



	if($purpose == "client")

	

		$ip = (getenv(HTTP_X_FORWARDED_FOR))? getenv(HTTP_X_FORWARDED_FOR):getenv(REMOTE_ADDR);

	

	else

	

		$ip = $_SERVER['SERVER_ADDR'];

		

	$GLOBALS['logger_obj']->debug('<br>METHOD get_ip_address() - RETURN VALUE : ', $ip);



		return $ip;



}



function set_values($obj,$param_method='request',$db_resultset_ses_var='',$purpose="")

{

		

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD set_values() - PARAMETER LIST : ', $param_array);





	$fld_arr = get_object_vars($obj);

	

	global $param_arr;

	

	switch ($param_method)

	{



		case "request":

			$param_arr = $_REQUEST;

			break;



		case "post":

			$param_arr = $_POST;

			break;



		case "get":

			$param_arr = $_GET;

			break;



		case "db":

			$param_arr = mysql_fetch_assoc($db_resultset_ses_var);

			break;



		case "ses":

			$param_arr = $db_resultset_ses_var;

			break;



		case "csv":

			$param_arr = $db_resultset_ses_var;

			break;



	}



	foreach($fld_arr as $key => $value)

	{

	

		if(is_array($value))

		{



			//if(isset($param_arr[$value['frm_fldname']]) || (!isset($param_arr[$value['frm_fldname']]) && $value['save_todb'] == "true"))

			{



				if($purpose == "" && ($param_method == "db" || $param_method == "ses"))

				{

					//if(!isset($param_arr[$value['frm_fldname']]) && $value['save_todb'] == 'true')

					if(isset($param_arr[$value['frm_fldname']]))

						$new_value = $param_arr[$key];

					else

						$new_value = $obj->{$key}['value'];					



					if($value['fld_type'] == "date" && $param_method == 'db')

					{

						$t_arr = explode("-", $param_arr[$value['frm_fldname']]);

						$new_value = array("mt" => $t_arr[1], "dt" => $t_arr[2], "yr" => $t_arr[0]);

					}

					if($value['fld_type'] == "date" && $param_method == 'ses')

					{

						$mt_fld_name = $value['frm_fldname'] . "_mt";

						$dt_fld_name = $value['frm_fldname'] . "_dt";

						$yr_fld_name = $value['frm_fldname'] . "_yr";

						$new_value = array("mt" => $param_arr[$mt_fld_name], "dt" => $param_arr[$dt_fld_name], "yr" => $param_arr[$yr_fld_name]);

					}



				}

				//additions on 28082007 - for csv functionality - Start

				else if($param_method == "csv" && strlen(trim($value['to_csv'])) > 0)

				{

					$new_value = $param_arr[$value['to_csv'] - 1];

									}

				//additions on 28082007 - for csv functionality - End

				else

				{

					

					if(isset($param_arr[$value['frm_fldname']]))

					{

						$new_value = $param_arr[$value['frm_fldname']];

					}

					else if(!isset($param_arr[$value['frm_fldname']]) && strtolower($value['save_todb']) == "true")

					{

						//date fields should have save_todb parameter set to true and fld_type will be mentioned as "date"



						$mt_fld_name = $value['frm_fldname'] . "_mt";

						$dt_fld_name = $value['frm_fldname'] . "_dt";

						$yr_fld_name = $value['frm_fldname'] . "_yr";

						

						if($value['fld_type'] == "date")

						{

							

							if((isset($param_arr[$mt_fld_name]) && strlen(trim($param_arr[$mt_fld_name]))) && (isset($param_arr[$dt_fld_name]) && strlen(trim($param_arr[$dt_fld_name]))) && (isset($param_arr[$yr_fld_name]) && strlen(trim($param_arr[$yr_fld_name]))))

								$new_value = trim($param_arr[$yr_fld_name]) . "-" . trim($param_arr[$mt_fld_name]) . "-" . trim($param_arr[$dt_fld_name]);

							else

								$new_value = "do_not_frame_in_sql";

						}

						else

						{

							$new_value = $obj->{$key}['value'];					

						}

					

					}

					if(!isset($param_arr[$value['frm_fldname']]) && strtolower($value['save_todb']) == "false")

					{

						$new_value = "do_not_frame_in_sql";	

					}

				}

				//echo $value ."<hr>";

				

				if($param_method == "csv")//28082007

				$obj->{$key}['frm_fld_type'] = "text";

				

				$obj->{$key}['value'] = trim($new_value);

				unset($new_value);



			}



		}

	

	}

		

	$GLOBALS['logger_obj']->debug('<br>METHOD set_values() - Return Value : ', $obj);



	return $obj;



}



function frame_notices($msg_str,$cls_name="greenfont",$concat=0)

{

		

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD frame_notices() - PARAMETER LIST : ', $param_array);



	if($concat == 1)

	{

		$t_arr = explode("<br>", $_SESSION['ses_msg_str']);

		print_r($t_arr);

		if(!in_array($msg_str, $t_arr))

			$_SESSION['ses_msg_str'] = $msg_str . "<br>" . $_SESSION['ses_msg_str'];

		

		if(strlen($_SESSION['ses_msg_cls_str']) <= 0)

		$_SESSION['ses_msg_cls_str'] = $cls_name;

	}

	else

	{

		$_SESSION['ses_msg_str'] = $msg_str;

		$_SESSION['ses_msg_cls_str'] = $cls_name;

	}



	$GLOBALS['logger_obj']->debug('<br>METHOD frame_notices() - Return Value : ', 'Frames error message in session and returns void');

}



//common methods for error handling - Start



function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars) 

{



	$errortype = array (

				E_ERROR           => "Error",

				E_WARNING         => "Warning",

				E_PARSE           => "Parsing Error",

				E_NOTICE          => "Notice",

				E_CORE_ERROR      => "Core Error",

				E_CORE_WARNING    => "Core Warning",

				E_COMPILE_ERROR   => "Compile Error",

				E_COMPILE_WARNING => "Compile Warning",

				E_USER_ERROR      => "User Error",

				E_USER_WARNING    => "User Warning",

				E_USER_NOTICE     => "User Notice",

				E_STRICT          => "Runtime Notice"

				);



	$user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

	

	$err = "<table border=0 cellpadding=3 cellspacing=1 width=100%>";

	$err .= "<tr><td>ERROR NUMBER</td><td>" . $errno . "</td></tr>";

	$err .= "<tr><td>ERROR TYPE</td></td>" . $errortype[$errno] . "</td></tr>";

	$err .= "<tr><td>ERROR MESSAGE</td><td>" . $errmsg . "</td></tr>";

	$err .= "<tr><td>SCRIPT NAME</td><td>" . $filename . "</td></tr>";

	$err .= "<tr><td>SCRIPT LINENUM</td><td>" . $linenum . "</td></tr>";



	if (in_array($errno, $user_errors))

		$err .= "<tr><td>Var trace</td><td>" . wddx_serialize_value($vars, "Variables") . "</td></tr>\n";



	$err .= "</table>";

	

	$error_title = "RUNTIME ERRORS";



	//if(strtoupper($errortype[$errno])!="WARNING" && strtoupper($errortype[$errno])!="NOTICE")

	if(strtoupper($errortype[$errno])!="NOTICE")

	{

		$GLOBALS['logger_obj']->error($error_title, $err, "err");

	}



}//end function userErrorHandler





function Error_Handler($errno, $errstr, $errfile, $errline) 

{

  $err_description = "";

  switch ($errno) {

  case FATAL:

    $err_description .= "<tr><td><b>FATAL</b> [$errno] $errstr<br /></td></tr>";

    $err_description .= "<tr><td>Fatal error in line " . $errline . " of file " . $errfile . "</td></tr>";

    $err_description .= "<tr><td>PHP " . PHP_VERSION . " (" . PHP_OS . ")<br /></td></tr>";

    break;

  case ERROR:

    echo "<b>ERROR</b> [$errno] $errstr<br />\n";

    break;

  case WARNING:

    echo "<b>WARNING</b> [$errno] $errstr<br />\n";

    break;

  default:

    echo "Unkown error type: [$errno] $errstr<br />\n";

    break;

  }

}



//common methods for error handling - End





function convert_date($date,$format="")

{



	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD convert_date() - PARAMETER LIST : ', $param_array);



	if(strlen($format) <= 0)

	{

		$format = $GLOBALS['site_config']['date_format'];

	}



	if($date == "0000-00-00 00:00:00" || $date == "0000-00-00")

	{

		$temp_dt = "";	

	}

	else

	{

		$temp_dt = date($format, strtotime($date));

	}

	

	$GLOBALS['logger_obj']->debug('<br>METHOD convert_date() - PARAMETER LIST : ', $temp_dt);



	return $temp_dt;

	

}



function convert_link($address,$type="email")

{



$param_array = func_get_args();

$GLOBALS['logger_obj']->debug('<br>METHOD convert_link() - PARAMETER LIST : ', $param_array);



  if($type=="email")

  {

    $ret_val = "<a href='mailto:$address'>$address</a>";

  }

  else

  {

   $ret_val = "<a target='_blank' href='$address'>$address</a>";

  }



$GLOBALS['logger_obj']->debug('<br>METHOD convert_link() - RETURN VALUE : ', $ret_val);



return $ret_val;

}



function trim_text($description_txt, $length=8)

{



	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD trim_text() - PARAMETER LIST : ', $param_array);



	$tmp_text="";

	if(strlen($description_txt) > $length)

	{

	  $tmp_text=substr($description_txt,0,$length)."...";

	}

	else

	{ 

	 $tmp_text=$description_txt;

	}

	

	$tmp_text = stripslashes($tmp_text);

	

	$GLOBALS['logger_obj']->debug('<br>METHOD trim_text() - RETURN VALUE : ', $tmp_text);



    return $tmp_text;



}



//old funtion

/*function display_view_delete_links($path)

{



	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD display_view_delete_links() - PARAMETER LIST : ', $param_array);

	

	if(file_exists($path) && is_file($path))

	{

		$ic_path = ($GLOBALS['in_admin'] == 1)?"../images/view_img.gif":"images/view_img.gif";

		

		echo "<a href='" . $path . "' target='_blank'><img src='" . $ic_path . "' border=0></a>";

	}



	$GLOBALS['logger_obj']->debug('<br>METHOD display_view_delete_links() - RETURN VALUE : ', 'Displays the view link for the file attached, and returns void');



}*/

//end of old display_view_delete_links function



//added on 26-04-2007

function display_view_delete_links($obj,$fld_name,$preview_icon_name='view_img.gif',$delete_icon_name='',$del_url='')

{

	

	

	$path = $obj->attachment_path . $obj->{$fld_name}['value'];

		

	$param_array = func_get_args();

	

	$GLOBALS['logger_obj']->debug('<br>METHOD display_view_delete_links() - PARAMETER LIST : ', $param_array);

	

	if(file_exists($path) && is_file($path))

	{

		

		$ic_path = ($GLOBALS['in_admin'] == 1)?"../images/$preview_icon_name":"images/$preview_icon_name";

		$dic_path = ($GLOBALS['in_admin'] == 1)?"../images/$delete_icon_name":"images/$delete_icon_name";

		

		$disply_string ="<table><tr>";
		$disply_string .="<td><a href='" . $path . "' target='_blank'><img src='" . $ic_path . "' border=0></a></td>";

		

		if(strlen($delete_icon_name) > 0)

		{

			$disply_string .="<td>";
			$disply_string .="<a href='" . $del_url . "'><img src='" . $dic_path . "' border=0></a></td>";
		}

		$disply_string .="</tr></table>";			
		echo $disply_string;
	}



	$GLOBALS['logger_obj']->debug('<br>METHOD display_view_delete_links() - RETURN VALUE : ', 'Displays the view link for the file attached, and returns void');



}



function write_file($fpth, $content, $mode='a')

{



	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD write_file() - PARAMETER LIST : ', $param_array);



	$filename = $fpth;

	$bool = true;

	if(strlen($content) > 0)

	{

		$err = "";

		if (is_writable($filename)) 

		{

			if (!$handle = fopen($filename, $mode)) 

			{

				 $err .= "Cannot open file ($filename)";

				 $bool = false;

			}

		

			if (fwrite($handle, $content) === FALSE) {

				$err .= "Cannot write to file ($filename)";

			    $bool = false;

			}

			

			fclose($handle);

							

		} 

		else 

		{

			$err .= "The file $filename is not writable";

		    $bool = false;

		}

		

	}

	

	$error_title = 'Error In Method : write_file()';

	

	$GLOBALS['logger_obj']->error($error_title, $err, 'file');

	$GLOBALS['logger_obj']->debug('<br>METHOD write_file() - RETURN VALUE : ', $bool);



	return $bool;



}//end function write_file



function format_number($val,$deci_portion=2)

{



	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD format_number() - PARAMETER LIST : ', $param_array);



	$ret_num = number_format($val, $deci_portion, '.', '');



	$GLOBALS['logger_obj']->debug('<br>METHOD format_number() - RETURN VALUE : ', $ret_num);



	return $ret_num;	

}



function submit_tosslpage()

{



	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD submit_tosslpage() - PARAMETER LIST : ', $param_array);

	

	if($_SESSION['ses_payment_vars']['payment_method'] == 4)

		$file_name = "paypal_step1.php?submit_action=processpayment";

	else

	{

		$file_name = "authorize_step1.php";

		if(isset($_REQUEST['toid']) && isset($_REQUEST['p']))

		$file_name .= "?p=" . $_REQUEST['p'] . "&toid=" . $_REQUEST['toid'];

	}

	$redirect_url = $GLOBALS['site_config']['ssl_url'] . $file_name;

	

	$submit_str = '';

	

	$submit_str .= "<html><head><title></title></head><body><form name='ssl_frm' method='post' action='" . $redirect_url . "'>";



	foreach($_SESSION as $ses_key => $ses_val)

	{

		//echo $ses_key . " - " . $ses_val . "<hr>";

		if(is_array($ses_val))

		{

			$submit_str .= frame_session_as_hidden($ses_val, $ses_key);

		}

		else

			$submit_str .= "<input type='hidden' name='" . $ses_key . "' value=\"" . $ses_val . "\">";

	}

	

	

	if(count($_SESSION['ses_cart_items']) > 0)

		$submit_str .= "<input type='hidden' name='ses_cart_products' value='yes'>";

	else

		$submit_str .= "<input type='hidden' name='ses_cart_products' value='no'>";

	

		$submit_str .= "<input type='hidden' name='PHPSESSID' value='" . session_id() . "'>";



	$submit_str .= "</form>";

	$submit_str .= "<script language='javascript'>";

	$submit_str .= "window.document.ssl_frm.submit();";

	$submit_str .= "</script></body></html>";

	

	$GLOBALS['logger_obj']->debug('<br>METHOD submit_tosslpage() - RETURN VALUE : ', $submit_str);

	

	return $submit_str;



}



function frame_session_as_hidden($ses_arr, $key_fld_name)

{



	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD frame_session_as_hidden() - PARAMETER LIST : ', $param_array);

	

	$ret_str = '';

	

	foreach($ses_arr as $ky => $vl)

	{

		//echo $ky . " - " . $vl . "<hr>";

		if(is_array($vl))

			$ret_str .= frame_session_as_hidden($vl,$ky);

		else

			$ret_str .= "<input type='hidden' name='" . $ky . "' value=\"" . $vl . "\">";

	}

	

	$GLOBALS['logger_obj']->debug('<br>METHOD frame_session_as_hidden() - RETURN VALUE : ', $ret_str);

	

	return $ret_str;

	

}



function initialize_session_for_ssl()

{



	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD initialize_session_for_ssl() - PARAMETER LIST : ', $param_array);



	foreach($_REQUEST as $key => $val)

	{

		if(is_array($val))

		{

			initialize_session_array_for_ssl($val,$key);	

		}

		else

			$_SESSION[$key] = $val;	

	}

	

	$GLOBALS['logger_obj']->debug('<br>METHOD initialize_session_for_ssl() - RETURN VALUE : ', $ret_str);



}



function initialize_session_array_for_ssl($val,$ky)

{



	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD initialize_session_array_for_ssl() - PARAMETER LIST : ', $param_array);

	

	foreach($val as $nk => $nv)

	{

		if(is_array($nv))

			initialize_session_array_for_ssl($nv,$nk);	

		else

			$_SESSION[$ky][$nk] = $nv;	

	}

	

	$GLOBALS['logger_obj']->debug('<br>METHOD initialize_session_array_for_ssl() - RETURN VALUE : ', $ret_str);



}





function eval_php_content($eval_str)

{

	  preg_match_all("/(<\?php|<\?)(.*?)\?>/si", $eval_str, $raw_php_matches);

	

	//print_r($raw_php_matches);

	$php_idx = 0;

	

	while (isset($raw_php_matches[0][$php_idx]))

	{

	 $raw_php_str = $raw_php_matches[0][$php_idx];

	 $raw_php_str = str_replace("<?php", "", $raw_php_str);

	 $raw_php_str = str_replace("?>", "", $raw_php_str);

	 ob_start();

	 eval("$raw_php_str;");

	 $exec_php_str = ob_get_contents();

	 ob_end_clean();

	

	//	echo $eval_str . "<hr>";

	

	 $eval_str = preg_replace("/(<\?php|<\?)(.*?)\?>/si",

										$exec_php_str, $eval_str, 1);

		//echo $eval_str . "<hr>";

	

	 $php_idx++;

	}

	

	//echo $eval_str;  

    return stripslashes($eval_str);  

}



function show_htmlobj_selected($orig_val, $sel_val, $html_obj)

{



	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD show_htmlobj_selected() - PARAMETER LIST : ', $param_array);

	

	$ret_val = "";

	

	switch ($html_obj)

	{

	

		case "select":

			if(stripslashes($orig_val) == stripslashes($sel_val))

			$ret_val = "selected";		

			break;

		

		case "check":

			if(stripslashes($orig_val) == stripslashes($sel_val))

			$ret_val = "checked";		

			break;

		

	}



	$GLOBALS['logger_obj']->debug('<br>METHOD show_htmlobj_selected() - RETURN VALUE : ', $ret_val);

	

	return $ret_val;

	

}



function fill_search_form($obj, $fld_srch_typ, $reqd, $orig_val="")

{

	

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD fill_search_form() - PARAMETER LIST : ', $param_array);

	

	$ret_val = "";

	

	switch ($reqd)

	{

	

		case "keyword":

			$ret_val = stripslashes($_SESSION[$obj->srch_ses_val][$fld_srch_typ]['tbl_fld_value']);

			break;

			

		case "select":

			$sel_val = stripslashes($_SESSION[$obj->srch_ses_val][$fld_srch_typ]['tbl_fld_name']);

			$ret_val = show_htmlobj_selected($orig_val, $sel_val, $reqd);

			break;

			

		case "selectkey":

			$sel_val = stripslashes($_SESSION[$obj->srch_ses_val][$fld_srch_typ]['tbl_fld_value']);

			$ret_val = show_htmlobj_selected($orig_val, $sel_val, "select");

			break;

			

		case "check":

			$sel_val = stripslashes($_SESSION[$obj->srch_ses_val][$fld_srch_typ]['tbl_fld_name']);

			$ret_val = show_htmlobj_selected($orig_val, $sel_val, $reqd);

			break;

			

		case "checkkey":

			$sel_val = stripslashes($_SESSION[$obj->srch_ses_val][$fld_srch_typ]['tbl_fld_value']);

			$ret_val = show_htmlobj_selected($orig_val, $sel_val, "check");

			break;

			

		case "between_frm":

			$ret_val = stripslashes($_SESSION[$obj->srch_ses_val][$fld_srch_typ]['tbl_fld_value_frm']);

			break;

			

		case "between_to":

			$ret_val = stripslashes($_SESSION[$obj->srch_ses_val][$fld_srch_typ]['tbl_fld_value_to']);

			break;

			

	}

	

	$GLOBALS['logger_obj']->debug('<br>METHOD fill_search_form() - RETURN VALUE : ', $ret_val);

	

	return $ret_val;



}



function free_memory()

{

	

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD free_memory() - PARAMETER LIST : ', $param_array);

	

	$a = get_defined_vars();

	

	//should not clear session variables here..

	$notin_array = array("_SESSION", "HTTP_SESSION_VARS", "_COOKIE", "HTTP_COOKIE_VARS");

	

	foreach($a as $k => $v)

	{

		if(!in_array($k, $notin_array))

		unset($a[$k]);

	}

	

	$GLOBALS['logger_obj']->debug('<br>METHOD free_memory() - RETURN VALUE : ', $ret_val);

	

}



function createRandomPassword()

	{

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD createRandomPassword() - PARAMETER LIST : ', $param_array);

	

	$num = "0123456789";

	$small = "abcdefghijklmnopqrstuvwxyz";

	srand((double)microtime()*1000000);

	$pass .= rand(0,9);

	for($i = 0; $i <= 3; $i++){

		$pass.=substr($small,rand(0,25),1);	

	}

	for($i = 4;$i <= 5; $i++){

		$pass .= rand(0,9);

	}

	$pass .= substr($small,rand(0,25),1);

	return $pass;

	$GLOBALS['logger_obj']->debug('<br>METHOD createRandomPassword() - RETURN VALUE : ', $ret_val);

	}





function createRandomUsername($fname,$lname,$type, $ctr=0)

{

	

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD createRandomUsername() - PARAMETER LIST : ', $param_array);

	

	$first = substr($fname,0,2);//first name

	$mid = substr($lname,0,2); //From Last name

	$last = substr($type->cls_tbl,0,2); // type of user like school or student or counselor

	

	$username = $last . "_" . $first . $mid;

	

	$temp_str = "";

	/*

	if($ctr >= 1)

	{

		$small = array(1 => "a", "b", "c", "d", "e", "f", "g","h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

		$temp_str = $small[$ctr];

	}

	*/

	

	if($ctr > 0)

	$username .= "_" . $type->{$type->primary_fld}['value'];

	

	$username .= "_" . $type->stud_school['value'];

	

	return $username;

	

	$GLOBALS['logger_obj']->debug('<br>METHOD createRandomUsername() - RETURN VALUE : ', $ret_val);

	

}	 



function creatediscoupon($id)

	{	

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD creatediscoupon() - PARAMETER LIST : ', $param_array);

	

		$num = 0;

		for($i = 0; $i <= 5; $i++)

		{

		$num .= rand(0, 9);

		}

		$randnum = $num;

		$coupon_code = $id . "_" . "DIS" . $randnum;

		return $coupon_code;

		

		$GLOBALS['logger_obj']->debug('<br>METHOD creatediscoupon() - RETURN VALUE : ', $ret_val);

		}





function set_selected_emails_insession($ses_var_name, $request_var_name, $checked_fld_name)

{

	

	if(is_array($_REQUEST[$request_var_name]))

	{

		foreach($_REQUEST[$request_var_name] as $key => $value)

		{

			

			if(strlen(trim($_REQUEST[$checked_fld_name][$key])) > 0)

				$_SESSION[$ses_var_name][$key] = $value;

			else if(strlen(trim($_REQUEST[$checked_fld_name][$key])) <= 0 && is_array($_SESSION[$ses_var_name]) && array_key_exists($key, $_SESSION[$ses_var_name]))

				unset($_SESSION[$ses_var_name][$key]);

			

		}

	}

}



function display_view_delete_links1($obj,$fld_name,$preview_icon_name='view_img.gif',$delete_icon_name='')

{



	$path = $obj->attachment_path . $fld_name;

	

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD display_view_delete_links() - PARAMETER LIST : ', $param_array);

	

	if(file_exists($path) && is_file($path))

	{

		$ic_path = ($GLOBALS['in_admin'] == 1)?"../images/$preview_icon_name":"images/$preview_icon_name";

		

		echo "<a href='" . $path . "' target='_blank'><img src='" . $ic_path . "' border=0></a>";

		

	}



	$GLOBALS['logger_obj']->debug('<br>METHOD display_view_delete_links() - RETURN VALUE : ', 'Displays the view link for the file attached, and returns void');



}





function get_auto_code($tbl_name,$fld_name,$primary_fld,$begin_code)

{

	

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD get_auto_code() - PARAMETER LIST : ', $param_array);

		

		$res = $GLOBALS['db_con_obj']->fetch_flds($tbl_name, $fld_name, " 1=1 order by " . $primary_fld . " desc limit 1");

		if($res[1] <= 0)

			$ret_code = $begin_code;

		else

		{

			if($data = mysql_fetch_object($res[0]))

			{

			

				$code = $data->$fld_name;

				$ret_code = ++$code;

			}

		}

		return $ret_code;

		

	$GLOBALS['logger_obj']->debug('<br>METHOD get_auto_code() - RETURN VALUE : ', $ret_code);



}





function rename_file($obj,$id)

{

	

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD rename_file() - PARAMETER LIST : ', $param_array);

	$fld_name = explode(",",$obj->file_flds);

	$res = $GLOBALS['db_con_obj']->fetch_flds($obj->cls_tbl, $obj->file_flds, $obj->primary_fld . " = '" . $id . "'");

	$data = mysql_fetch_object($res[0]);

	foreach($fld_name as $key => $value)

	{

		$path = $obj->attachment_path . $data->{$value};

		$path_new = $obj->attachment_path . $id . "_". $data->{$value};



		if(file_exists($path))

		{

			rename($path, $path_new);

			chmod($path_new,"777");

		}

		$update_qry= "update ".$obj->cls_tbl. " set ".$value." = '" .$id . "_". $data->{$value}."' where ".$obj->primary_fld ." = '".$id."'";

		$update_res = $GLOBALS['db_con_obj']->execute_sql($update_qry, "update");



	}

	

	$GLOBALS['logger_obj']->debug('<br>METHOD rename_file() - RETURN VALUE : ', 'Rename uploaded file');



}



function display_field_value($obj,$field){

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD display_field_value() - PARAMETER LIST : ', $param_array);

	

	$field_name = LANG.$field;

	

	if($obj->$field_name !='')

	  	return $obj->$field_name;

	else{

	   $field_name = "En".$field;

	   return $obj->$field_name;

	}

	

	$GLOBALS['logger_obj']->debug('<br>METHOD display_field_value() - RETURN VALUE : ', 'Display field value');

	

}



function display_language(){

	//echo __FILE__;

	//$explode(".",$_SERVER['REQUEST_URI']);

	if($_SESSION['ses_lang']=="Ch"){

		$string = "<a href=''>En</a>";

	}else{

		

	}	

}



function products($prod_obj){

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD products() - PARAMETER LIST : ', $param_array);

	if(isset($_SESSION['ses_temp_search_obj'])){

			$condition =0;

		if(isset($_SESSION['ses_temp_search_obj']['functions']) && count($_SESSION['ses_temp_search_obj']['functions']) >=0 ){

			$fun_con =" (";

			foreach($_SESSION['ses_temp_search_obj']['functions'] as $fid =>$fval){

					$fun_con_str .=" CONCAT(',',Function,',') like '%".$fval."%' or";

			}

			$fun_con .= substr($fun_con_str,0,-2);

			$fun_con .=" )";

			$condition =1;

		}

		else if(isset($_SESSION['ses_temp_search_obj']['fun']) && $_SESSION['ses_temp_search_obj']['fun'] !=''){

			$fun_con =" ( CONCAT(',',Function,',') like '%".$_SESSION['ses_temp_search_obj']['fun']."%' )";

			$_SESSION['ses_temp_search_obj']['functions'] = $_SESSION['ses_temp_search_obj']['fun'];

			$condition =1;

		}

		

		if(isset($_SESSION['ses_temp_search_obj']['materials']) && count($_SESSION['ses_temp_search_obj']['materials']) >0 && count($_SESSION['ses_temp_search_obj']['materials'])!=''){

			if($condition==1)

				$mat_con =" and (";

			else

				$mat_con =" (";

			foreach($_SESSION['ses_temp_search_obj']['materials'] as $mid =>$mval){

					$mat_con_str .=" CONCAT(',',Material,',') like '%".$mval."%' or";

			}

			$mat_con .= substr($mat_con_str,0,-2);

			$mat_con .=" )";

			

			$condition =1;

		}

		if(isset($_SESSION['ses_temp_search_obj']['types']) && count($_SESSION['ses_temp_search_obj']['types']) >0){

			if($condition==1)

			$type_con =" and (";

			else

				$type_con =" (";

			foreach($_SESSION['ses_temp_search_obj']['types'] as $tid =>$tval){

					$type_con_str .=" CONCAT(',',Types,',') like '%".$tval."%' or";

			}

			$type_con .= substr($type_con_str,0,-2);

			$type_con .=" )";

			

			$condition =1;

		}

		if(isset($_SESSION['ses_temp_search_obj']['PriceFrom']) && isset($_SESSION['ses_temp_search_obj']['PriceTo'])){

			if($condition==1)

			$price_con =" and (";

			else

				$price_con =" (";

				

			$price_con .=" Price BETWEEN ".$_SESSION['ses_temp_search_obj']['PriceFrom']." and ".$_SESSION['ses_temp_search_obj']['PriceTo'];

			

			$price_con .=" )";

			

			$condition =1;

		}

		

		if(isset($_SESSION['ses_temp_search_obj']['keyword']) && isset($_SESSION['ses_temp_search_obj']['keyword'])){

			if($condition==1)

			$keyword =" and (";

			else

				$keyword =" (";

				

				$keyword .=" concat(',',EnName,',') like '%".$_SESSION['ses_temp_search_obj']['keyword']."%'";

			

			$keyword .=" )";

			

			$condition =1;

				

		}

		

		 $qry_con = $fun_con.$mat_con.$type_con.$price_con.$keyword;

		 $qry = "select Id,EnName,ChName,Image,Price,Quantity from " . $prod_obj->cls_tbl . " where ".$qry_con." and ProdType=1 and ProdStatus = '1' ";		  				

		

	}

	else{

		  $qry = "select Id,EnName,ChName,Image,Price,Quantity from " . $prod_obj->cls_tbl . " where ProdType=1 and ProdStatus = '1' ";

	}

	

	if(isset($_SESSION['ses_temp_search_obj']['sort_by']) && $_SESSION['ses_temp_search_obj']['sort_by'] !=''){

		if($_SESSION['ses_temp_search_obj']['sort_by'] =='Name')

			$qry .= " order by  EnName asc";

		else if($_SESSION['ses_temp_search_obj']['sort_by'] =='Price')

			$qry .= " order by  Price asc";

		else if($_SESSION['ses_temp_search_obj']['sort_by'] =='Date')

			$qry .= " order by  Created asc";

		else 

			$qry .= " order by  DisplayOrder desc";

	}

	else{

		$qry .= " order by  DisplayOrder desc";

	}

	//echo $qry;

	//print_r($_SESSION['ses_temp_search_obj']);

	return $qry;

	

	$GLOBALS['logger_obj']->debug('<br>METHOD products() - RETURN VALUE : ', 'Display products qry');

	

}



function ProductQuantity($id){

	if(file_exists("classes/products.class.php"))

		require_once("classes/products.class.php");

	else if(file_exists("./classes/products.class.php"))

		require_once("./classes/products.class.php");

	else if(file_exists("../classes/products.class.php"))

		require_once("../classes/products.class.php");	

	

	

	

	$prod_obj = new products();

	$prod_res = $prod_obj->fetch_record($id);

	$prod_data = mysql_fetch_object($prod_res[0]);

	

	//$GLOBALS['site_config']['debug'] =1;

	$orders_res = $GLOBALS['db_con_obj']->fetch_flds("order_details","SUM(prod_quantity) as qty","prod_id=".$id);

	$order_data = mysql_fetch_object($orders_res[0]);

	

	if(isset($_SESSION['ses_customer_id']) && $_SESSION['ses_customer_id'] >0){

		$temp_cart_res = $GLOBALS['db_con_obj']->fetch_flds("temp_cart","SUM(ProdQty) as TempQty","ProductId=".$id." and UserId !=".$_SESSION['ses_customer_id']);

	}

	else{

		$sessionId = session_id();

		//$temp_cart_res = $GLOBALS['db_con_obj']->fetch_flds("temp_cart","SUM(ProdQty) as TempQty","ProductId=".$id ." and SessionId !='".$sessionId."'");

		$temp_cart_res = $GLOBALS['db_con_obj']->fetch_flds("temp_cart","SUM(ProdQty) as TempQty","ProductId=".$id );

	}

	$temp_cart_data = mysql_fetch_object($temp_cart_res[0]);

	

	$available_qty = $prod_data->Quantity-($order_data->qty+$temp_cart_data->TempQty);

	

	return $available_qty;



}



function MinimumProductQuantity($id){

	if(file_exists("classes/products.class.php"))

		require_once("classes/products.class.php");

	else if(file_exists("./classes/products.class.php"))

		require_once("./classes/products.class.php");

	else if(file_exists("../classes/products.class.php"))

		require_once("../classes/products.class.php");	

	

	

	

	$prod_obj = new products();

	$prod_res = $prod_obj->fetch_record($id);

	$prod_data = mysql_fetch_object($prod_res[0]);

	

	//$GLOBALS['site_config']['debug'] =1;

	$orders_res = $GLOBALS['db_con_obj']->fetch_flds("order_details","SUM(prod_quantity) as qty","prod_id=".$id);

	$order_data = mysql_fetch_object($orders_res[0]);

	

	

	$sessionId = session_id();

	//$temp_cart_res = $GLOBALS['db_con_obj']->fetch_flds("temp_cart","SUM(ProdQty) as TempQty","ProductId=".$id ." and SessionId !='".$sessionId."'");

	$temp_cart_res = $GLOBALS['db_con_obj']->fetch_flds("temp_cart","SUM(ProdQty) as TempQty","ProductId=".$id );

	

	$temp_cart_data = mysql_fetch_object($temp_cart_res[0]);

	

	$available_qty = $prod_data->Quantity-($order_data->qty+$temp_cart_data->TempQty);

	

	return $available_qty;



}



function findShippingCost($weight, $country, $cart_amt){
	//$GLOBALS['site_config']['debug']=1;
	$weight = format_number($weight);
	$settings_res = $GLOBALS['db_con_obj']->fetch_flds("shipping_settings","*","id=1");
	$settings_data = mysql_fetch_object($settings_res[0]);
	
	
	if($country =="SG" && $cart_amt >=$GLOBALS['site_config']['freeshipping_amt']){
		$shipping_cost = 0.00;
	}
	else {
			if($weight > $settings_data->WeightLimit){
				$ship_res = $GLOBALS['db_con_obj']->fetch_flds("shipping_details","*","WeightTo <=".$weight." order By WeightTo DESC Limit 0,1");
				$ship_data = mysql_fetch_object($ship_res[0]);
				
				$more_weight = ceil($weight - $settings_data->WeightLimit);
				
				if(in_array($country,explode(",",$ship_data->ZoneACountry))){
					$shipping_cost = $ship_data->ZoneAPrice + ($more_weight*$settings_data->ZoneAPrice);
				}
				else if(in_array($country,explode(",",$ship_data->ZoneBCountry))){
					$shipping_cost = $ship_data->ZoneBPrice + ($more_weight*$settings_data->ZoneBPrice);
				}
				else if(in_array($country,explode(",",$ship_data->ZoneCCountry))){
					$shipping_cost = $ship_data->ZoneCPrice + ($more_weight*$settings_data->ZoneCPrice);
				}
				else if(in_array($country,explode(",",$ship_data->ZoneDCountry))){
					$shipping_cost = $ship_data->ZoneDPrice+ ($more_weight*$settings_data->ZoneDPrice);
				}
				else{
					$shipping_cost = $ship_data->ZoneEPrice+ ($more_weight*$settings_data->ZoneEPrice);
				}
			}
			else{
				$ship_res = $GLOBALS['db_con_obj']->fetch_flds("shipping_details","*","WeightTo >=".$weight." and WeightFrom <=".$weight);
				$ship_data = mysql_fetch_object($ship_res[0]);
				
				//print_r($ship_data);
				//exit;
				
				if(in_array($country,explode(",",$ship_data->ZoneACountry))){
					$shipping_cost = $ship_data->ZoneAPrice;
				}
				else if(in_array($country,explode(",",$ship_data->ZoneBCountry))){
					$shipping_cost = $ship_data->ZoneBPrice;
				}
				else if(in_array($country,explode(",",$ship_data->ZoneCCountry))){
					$shipping_cost = $ship_data->ZoneCPrice;
				}
				else if(in_array($country,explode(",",$ship_data->ZoneDCountry))){
					$shipping_cost = $ship_data->ZoneDPrice;
				}
				else{
					$shipping_cost = $ship_data->ZoneEPrice;
				}
				
			}
	
	}
	
	return format_number($shipping_cost,2);
	
}

function CheckItemInCart($id, $session){
	 $exists = false;
	  foreach($session as $key => $value)
	  {
		if($id == $value['Id'])	{
			$exists = true;
		}		
	  }
	   return $exists;
	
}


function checkCartAmount(){

	if(isset($_SESSION['ses_cart_items']))

	{

		$amount = 0;

		foreach($_SESSION['ses_cart_items'] as $key => $crt_val) 

			{ 

			$temp_amount = format_number(round($crt_val['prod_unit_price'] * $crt_val['prod_quantity'], 2));

			$amount += $temp_amount;

			}

			$amt = format_number($amount);

	}

	else{

		$amt =0.00;

	}
	
	
	$amt  = format_number($amt);
	
	return $amt;

}

function checkCartCount(){

	$count_item = count($_SESSION['ses_cart_items']) + count($_SESSION['ses_gifthamper_array']);

	return $count_item;

}



function PurchasedQuantity($id){

		
//$GLOBALS['site_config']['debug'] =1;
	$orders_res = $GLOBALS['db_con_obj']->fetch_flds("order_master as mas, order_details as details","SUM(details.prod_quantity) as qty","mas.order_id =details.order_id and details.prod_id=".$id." and (mas.order_status =1 or mas.order_status =2) ");

	$order_data = mysql_fetch_object($orders_res[0]);

	

	$available_qty = $order_data->qty;
	

	

	return $available_qty;



}



function LogedQuantity($id){
		

	$temp_cart_res = $GLOBALS['db_con_obj']->fetch_flds("temp_cart","SUM(ProdQty) as TempQty","ProductId=".$id );

	$temp_cart_data = mysql_fetch_object($temp_cart_res[0]);	

	$available_qty = $temp_cart_data->TempQty;	

	return $available_qty;



}



function publication($prod_obj){

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD products() - PARAMETER LIST : ', $param_array);

	if(isset($_SESSION['ses_temp_search_obj'])){

			$condition =0;

		if(isset($_SESSION['ses_temp_search_obj']['author']) && count($_SESSION['ses_temp_search_obj']['author']) >=0 ){

			$fun_con =" (";

			

					$fun_con_str .=" AuthorId = ".$_SESSION['ses_temp_search_obj']['author']." ";

					

			$fun_con .= substr($fun_con_str,0);

			$fun_con .=" )";

			$condition =1;

		}

		else

		{

			$fun_con ="1=1 ";

		}

		 $qry_con = $fun_con;

		 $qry = "select Id,EnName,ChName,Image,Price,Quantity,AuthorId from " . $prod_obj->cls_tbl . " where ".$qry_con." and ProdType=2 and ProdStatus = '1' ";		  				

		

	}

	else{

		  $qry = "select Id,EnName,ChName,Image,Price,Quantity,AuthorId from " . $prod_obj->cls_tbl . " where ProdType=2 and ProdStatus = '1' ";

	}

	

	if(isset($_SESSION['ses_temp_search_obj']['sort_by']) && $_SESSION['ses_temp_search_obj']['sort_by'] !=''){

		if($_SESSION['ses_temp_search_obj']['sort_by'] =='Name')

			$qry .= " order by  EnName asc";

		else if($_SESSION['ses_temp_search_obj']['sort_by'] =='Price')

			$qry .= " order by  Price asc";

		else if($_SESSION['ses_temp_search_obj']['sort_by'] =='Date')

			$qry .= " order by  Created asc";

		else 

			$qry .= " order by  DisplayOrder desc";

	}

	else{

		$qry .= " order by  DisplayOrder desc";

	}

	//echo $qry;

	//print_r($_SESSION['ses_temp_search_obj']);

	return $qry;

	

	$GLOBALS['logger_obj']->debug('<br>METHOD products() - RETURN VALUE : ', 'Display products qry');

	

}



//display cart items

function count_cart_items(){

	$count_cart_item =0;

	foreach($_SESSION['ses_cart_items'] as $key => $val) 

	{ 

		$count_cart_item += $val['prod_quantity'];

	}

	return $count_cart_item;

}



function findGSTamount($totamount){

	$precentage = ($totamount/ 107) *$GLOBALS['site_config']['gst_percentage'];

	$gst = format_number($precentage);

	return format_number($gst);

}



function userAutoGeneratedCode(){

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD userAutoGeneratedCode() - PARAMETER LIST : ', $param_array);

	

		$num = 0;

		for($i = 0; $i <= 5; $i++)

		{

		$num .= rand(0, 9);

		}

		$alpha = array(1 => "A", "B", "C", "D", "E", "F", "G","H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

		

		$alphabets = array_rand($alpha,3);

		foreach($alphabets as $k =>$v){

			$alphabets_value .= $alpha[$v];

		}

		

		

		$randnum = $num;

		$coupon_code = $alphabets_value .  $randnum;

		return $coupon_code;

		

		$GLOBALS['logger_obj']->debug('<br>METHOD userAutoGeneratedCode() - RETURN VALUE : ', $ret_val);

}



function AutoGeneratedNo(){

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD userAutoGeneratedCode() - PARAMETER LIST : ', $param_array);

	

		

		$alpha = array(1 => "A", "B", "C", "D", "E", "F", "G","H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

		

		$alphabets = array_rand($alpha,3);

		foreach($alphabets as $k =>$v){

			$alphabets_value .= $alpha[$v];

		}

		

		

		$randnum = $num;

		$coupon_code = $alphabets_value ;

		return $coupon_code;

		

		$GLOBALS['logger_obj']->debug('<br>METHOD userAutoGeneratedCode() - RETURN VALUE : ', $ret_val);

}



function get_seo_tags(){

	

	/*if(file_exists("classes/fengshui_pages.class.php"))

		require_once("classes/fengshui_pages.class.php");

	else if(file_exists("./classes/fengshui_pages.class.php"))

		require_once("./classes/fengshui_pages.class.php");

	else if(file_exists("../classes/fengshui_pages.class.php"))

		require_once("../classes/fengshui_pages.class.php");	

	

	fengshui_pages*/

	//$GLOBALS['site_config']['debug']=1;

	$currentUrl = explode("/",$_SERVER["PHP_SELF"]);

	$count_res = count($currentUrl)-1;

	$curentFile = $currentUrl[$count_res];

		

		$seo_res = $GLOBALS['db_con_obj']->fetch_flds("static_pages","*","UniqueKey='".$_REQUEST['key']."' and display_status=1");	

		

		

		
		//echo $curentFile;
		if($curentFile =="prod_content.php"){

			

		

			$prod_seo_res = $GLOBALS['db_con_obj']->fetch_flds("products","*","UniqueKey='".$_REQUEST['prod']."' and Status=1");	

			$prod_seo_data = mysql_fetch_object($prod_seo_res[0]);

			

			if(strlen($prod_seo_data->meta_title))

				$string = '<title>'.$prod_seo_data->meta_title.'</title>';

			else

				$string = '<title>'.$GLOBALS['site_config']['site_title'].'</title>';

			

			if(strlen($prod_seo_data->meta_keywords)>0)

				$string .= '<meta name="keywords" content="'.$prod_seo_data->meta_keywords.'"/>';

			else

				$string .= '<meta name="keywords" content="'.$GLOBALS['site_config']['site_keyword'].'"/>';

			

			if(strlen($prod_seo_data->meta_description)>0)			

				$string .= '<meta name="description" content="'.$prod_seo_data->meta_description .'"/>';

			else

				$string .= '<meta name="description" content="'.$GLOBALS['site_config']['site_desc'].'"/>';

		}

		else if($curentFile =="types.php"){

			

		

			$prod_seo_res = $GLOBALS['db_con_obj']->fetch_flds("types","*","UniqueKey='".$_REQUEST['type']."' and Status=1");	

			$prod_seo_data = mysql_fetch_object($prod_seo_res[0]);

			

			if(strlen($prod_seo_data->meta_title))

				$string = '<title>'.$prod_seo_data->meta_title.'</title>';

			else

				$string = '<title>'.$GLOBALS['site_config']['site_title'].'</title>';

			

			if(strlen($prod_seo_data->meta_keywords)>0)

				$string .= '<meta name="keywords" content="'.$prod_seo_data->meta_keywords.'"/>';

			else

				$string .= '<meta name="keywords" content="'.$GLOBALS['site_config']['site_keyword'].'"/>';

			

			if(strlen($prod_seo_data->meta_description)>0)			

				$string .= '<meta name="description" content="'.$prod_seo_data->meta_description .'"/>';

			else

				$string .= '<meta name="description" content="'.$GLOBALS['site_config']['site_desc'].'"/>';

		}

		

		

		else{

			$string = '<title>'.$GLOBALS['site_config']['site_title'].'</title>';

			$string .= '<meta name="keywords" content="'.$GLOBALS['site_config']['site_keyword'].'">';

			$string .= '<meta name="description" content="'.$GLOBALS['site_config']['site_desc'].'">';

		}

	

	return $string;

}



function display_gallery_links($obj,$fld_name,$folder='',$type=1,$preview_icon_name='view_img.gif',$delete_icon_name='',$del_url='')

{

	

	if($folder =='')

		$path = $obj->attachment_path . $obj->{$fld_name}['value'];

	else

		$path = $obj->attachment_path ."/".$folder."/". $obj->{$fld_name}['value'];

	$param_array = func_get_args();

	

	$GLOBALS['logger_obj']->debug('<br>METHOD display_view_delete_links() - PARAMETER LIST : ', $param_array);

	

	if(file_exists($path) && is_file($path))

	{

		

		$ic_path = ($GLOBALS['in_admin'] == 1)?"../images/$preview_icon_name":"images/$preview_icon_name";

		$dic_path = ($GLOBALS['in_admin'] == 1)?"../images/$delete_icon_name":"images/$delete_icon_name";

		if(strlen($delete_icon_name) > 0)

		echo "<table><tr><td>";



		echo "<a href='" . $path . "' target='_blank'><img src='" . $ic_path . "' border=0></a>";

		

		if(strlen($delete_icon_name) > 0)

		{

			echo "</td><td width='3'></td><td>";

			echo "<a href='" . $del_url . "'><img src='" . $dic_path . "' border=0></a></td></tr></table>";

		}

	}



	$GLOBALS['logger_obj']->debug('<br>METHOD display_view_delete_links() - RETURN VALUE : ', 'Displays the view link for the file attached, and returns void');



}

function GenerateUniqueKey($txt_str, $table_name=''){
	
	$string = trim($txt_str);
	
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    $string = preg_replace('/[^A-Za-z0-9\-]/', '-', $string); // Removes special chars.
	
	$string = str_replace('---', '-', $string);
	
	$string = str_replace('--', '-', $string);
   
   return $string;
}


function shipping_cost($method){	
	$ship_res = $GLOBALS['db_con_obj']->fetch_flds("shipping_methods","*","Id=".$method." and Status=1 order by DisplayOrder");
	$ship_data =mysql_fetch_object($ship_res[0]);
	$cart_amount = checkCartAmount();
	if($ship_data->FreeShipAvailable ==1){
		
		if($cart_amount >= $ship_data->FreeShipCost){
			$shipping_cost = format_number(0);
		}
		else{
			$shipping_cost = format_number($ship_data->Price);
		}
		
	}else{
		$shipping_cost = format_number($ship_data->Price);
	}
	
		
	 return $shipping_cost;
	
}

function GeneratedTempPass(){

	$param_array = func_get_args();

	$GLOBALS['logger_obj']->debug('<br>METHOD userAutoGeneratedCode() - PARAMETER LIST : ', $param_array);

	

			$alpha = array(1 => "a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A", "B", "C", "D", "E", "F", "G","H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z","$","*","^","!","#","0","1","2","3","4","5","6","7","8","9");

		

		$alphabets = array_rand($alpha,9);

		foreach($alphabets as $k =>$v){

			$alphabets_value .= $alpha[$v];

		}
		$randnum = $num;

		$coupon_code = $alphabets_value .  $randnum;

		return $coupon_code;

		

		$GLOBALS['logger_obj']->debug('<br>METHOD userAutoGeneratedCode() - RETURN VALUE : ', $ret_val);

}


function DisplayFieldValue($object,$fieldname,$language){	
	$field = $language.$fieldname;
	$fieldvalue = $object->$field;
	if($fieldvalue ==''){
		$field = "En".$fieldname;
		$fieldvalue = $object->$field;
	}	
	return $fieldvalue ;
}

function DisplayVariableValue($lablename,$language){
	$variable_res = $GLOBALS['db_con_obj']->fetch_flds("language_variables","*","Variable='".$lablename."'");
	$variable_data = mysql_fetch_object($variable_res[0]);
	
	if($language =='Tch'){
		$fieldvalue = $variable_data->TchLable;
	}
	else if($language =='Sch'){
		$fieldvalue = $variable_data->SchLable;
	}
	else{
		$fieldvalue = $variable_data->EnLable;
	}
	
	if($fieldvalue =='')
		$fieldvalue = $variable_data->EnLable;
	
	
	return $fieldvalue ;
}

function product_price($id,$price){	
	//$GLOBALS['site_config']['debug'] =1;
	$dis_res = $GLOBALS['db_con_obj']->fetch_flds("promotion_banner","Id,Discount,Type","concat(',',ItemId,',') Like '%,".trim($id).",%' and Status=1");
	if($dis_res[1] >0){		
		$dis_data = mysql_fetch_object($dis_res[0]);
		//print_r($dis_data);
		if($dis_data->Type =="%"){
			$discount = $dis_data->Discount;
			$prod_price = $price - (($price /100) *$discount);
		}
		else if($dis_data->Type =="$"){
			$discount = $dis_data->Discount;
			$prod_price = $price -$discount;
		}
	}else{
		$prod_price = $price;
	}
	
		//exit;
	 return $prod_price;
	
}

function display_promo($amount,$type){	
	//$GLOBALS['site_config']['debug'] =1;
	if($type =="%"){
		$dispaly = "Save ".$amount."%";
	}else{
		$dispaly = "Save $".$amount;
	}
	
		//exit;
	 return $dispaly;
	
}


?>