<?php

class logger
{

	function debug($title_str='',$val='', $is_debug_log=false)
	{//this method will be called in all the methods to just print the arguments passed to the method and the value returned by the method..
		
		if($GLOBALS['site_config']['debug'] == 1)
		{
			echo "<p style='font-size:12px; color: red; font-weight: bold; background-color: yellow;'>" . $title_str . " : ";
			
			if (is_array($val) || is_object($val) || is_resource($val)) 
			{
				print_r($val);
			} 
			else 
			{
				echo "\n$val\n";
			}
			
			echo "</p>";
			
		}
	
		//if($GLOBALS['site_config']['write_debug_log'] == 1 && substr($title_str,0,46) != "<br>METHOD database_manipulation::connect_db()")
		if($GLOBALS['site_config']['write_debug_log'] == 1 && !$is_debug_log)
		{
		
			$content_towrite = "";

			$temp_val = print_r($val, true);

			$content_towrite .= $title_str . "\n";
		
			$content_towrite .= $temp_val . "\n";
			
			$req_val = print_r($_REQUEST, true);
			
			if(is_array($val) || is_object($val) || is_resource($val))
				$val = print_r($val, true);
			
			$meth_purpose = $title_str . "||" . $val;
			
			//$db_con_obj = new database_manipulation();
			
			$dbg_qry = "select max(flow_id) as flow_id from debug_useractions where php_ses_id = '" . session_id() . "'";

			$dbg_res = $GLOBALS['db_con_obj']->execute_sql($dbg_qry);

			$dbg_data = mysql_fetch_object($dbg_res[0]);
			
			$cur_flow_id = ($dbg_data->flow_id + 1);
			
			$ins_qry = "insert into debug_useractions (debug_id, php_ses_id, browsed_url, flow_id, request_values, method_purpose, date_entered) values ('', '" . wrap_values(session_id()) . "', '" . wrap_values($_SERVER['REQUEST_URI']) . "', '" . $cur_flow_id . "', '" . wrap_values($req_val) . "', '" . wrap_values($meth_purpose) . "', now())";
			
			$GLOBALS['db_con_obj']->execute_sql($ins_qry, "insert", 1);
			
		}
		
	}
	
	function error($error_title, $error_description, $error_type)
	{//all coding error will be written in to the log file in this method...
		
		if(strlen(trim($error_description)) > 0)
		{
		
			$logfile_name = get_current_logfile_name($error_type);
			
			if(filesize($logfile_name) <= 0)
			
				$ttext = "<link href=\"" . $GLOBALS['site_config']['site_path'] . "style/admin_styles.css\" type=\"text/css\" rel=\"stylesheet\">";
			
			else
				
				$ttext = "";
	
			$ipaddress = get_ip_address();
			$err_file = $_SERVER['REQUEST_URI'];
			$err_dt = date("Y-m-d H:i:s (T)");
			
			$stext = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
			<html>
			<head>
			<title>" . $error_title . "</title>
			<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
			<link href='".$stylesheet_file."' type='text/css' rel='stylesheet'>
			</head>
			<body>";
			
			$ttext = "<table border='0' cellpadding='3' cellspacing='1' width='95%' align='center'>
			<tr><td colspan='2' class='errortitle'>" . $error_title . "</td></tr>
			<tr><td class='errsubtitle' width='20%'>IP ADDRESS</td><td width='80%'>" . $ipaddress . "</td></tr>
			<tr><td class='errsubtitle'>ERROR FILE</td><td>" . $err_file . "</td></tr>
			<tr><td class='errsubtitle'>ERROR DESCRIPTION</td><td>" . $error_description . "</td></tr>
			<tr><td class='errsubtitle'>ERROR DATE</td><td>" . $err_dt . "</td></tr>
			</table>
			<hr>";
			
			$etext = "</body></html>";
			
			if(file_exists($logfile_name) && is_file($logfile_name) && filesize($logfile_name) > 0)
			{
				$me_content = htmlentities($ttext.$etext);
				$file_content = htmlentities(file_get_contents($logfile_name));
				$prev_content = explode(htmlentities("</body>"),$file_content);
				$final_content = html_entity_decode($prev_content[0].$me_content);
				
				if (!$handle = fopen($logfile_name, 'w')) 
				{
					 echo "Cannot open file ($logfile_name)";
					exit;
				}
			
				if (fwrite($handle, $final_content) === FALSE)
				{
					echo "Cannot write to file ($logfile_name)";
					exit;
				}
				fclose($handle);
			}
			else
			{
				$ntext = $stext.$ttext.$etext;
				if (!$handle = fopen($logfile_name, 'w'))
				{
					echo "Cannot open file ($logfile_name)";
					exit;
				}
				if (fwrite($handle,$ntext) === FALSE) {
					echo "Cannot write to file ($logfile_name)";
				}
				fclose($handle);
			}
	
		}
	}
	
	
}

?>