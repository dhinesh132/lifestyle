<?php
global $in_admin;

$in_admin = 1;

if(file_exists("includes/code_header.php"))
	require_once("includes/code_header.php");
else if(file_exists("../includes/code_header.php"))
	require_once("../includes/code_header.php");

$call_center_allowed_modules =array(2=> "customers.php,select_customer.php,orders.php,agent_reports.php,static_pages.php,logout.php,prod_qty_notify.php,minimum_qty_products.php",3=>"orders.php,logout.php");

$call_center_not_allowed_modules = array(2=>"customers.php?submit_action=edit,customers.php?submit_action=delete,orders.php?submit_action=delete",3=>"orders.php,logout.php");

if($frm_page != "login")
{

if(file_exists("classes/admin.class.php"))
	require_once("classes/admin.class.php");
else if(file_exists("../classes/admin.class.php"))
	require_once("../classes/admin.class.php");

	$adm_obj = new admin();

	$adm_res = $adm_obj->fetch_record($_SESSION['ses_admin_id']);
	
	$adm_data = mysql_fetch_object($adm_res[0]);
	$modules_arr = explode(",", $adm_data->assigned_modules);
	
	if(in_array("all", $modules_arr))
	{
		$allow = "yes";
	}
	else
	{
		$url = $_SERVER['REQUEST_URI'];
		$url_arr = explode("?",$url);
		$url = basename($url_arr[0]);
		
		$allow = "no";
		
		foreach($modules_arr as $k => $v)
		{
			$chk_pg = $v;
			$tv_arr = explode("|", $v);
			if(count($tv_arr) > 1)
			{
				foreach($tv_arr as $in_k => $in_v)
				{
					if($url == $in_v)
					{
						$allow = "yes";
						break;
					}
				}
			}
			else
			{
				if($url == $chk_pg)
				{
					$allow = "yes";
				}
			}
			
			if($allow == "yes")
			break;	
			}
			if($_SESSION['ses_admin_access_level']==3){
				//$allow = "yes";
				$url = $_SERVER['REQUEST_URI'];
				 $url_arr = explode("&",$url);
				 //print_r($url_arr);
				 
				 if(strlen($url_arr[1]) <=0){
					 $url = $_SERVER['REQUEST_URI'];
					 $url_arr = explode("?",$url);
					 $new_array =  explode("/",$url_arr[0]);
					 $array_id = count($new_array)-1;
					$url = basename($url_arr[0]);					
					$allow = "no";					
					$allowed_modules_arr = explode(",", $call_center_allowed_modules[$_SESSION['ses_admin_access_level']]);
					//print_r($allowed_modules_arr);
					//echo "<hr>";
					foreach($allowed_modules_arr as $k => $v)				
					{
						
						if($new_array[$array_id] ==$v){
								$allow = "yes";
								
							}
							
					if($allow == "yes")
					break;	
					}
				 } else{
					
						$new_array =  explode("/",$url_arr[0]);
						$array_id = count($new_array)-1;
						$notallowed_modules_arr = explode(",", $call_center_not_allowed_modules[$_SESSION['ses_admin_access_level']]);
						foreach($notallowed_modules_arr as $k => $v){					
							if($new_array[$array_id] ==$v){
								$allow = "no";
								
							}
						if($allow == "no")
						break;	
						}
			
				 }
			}
			
			
				
	}
	
	if($from_page == "invoice_preview" || $from_page == "logout" || $from_page == "paymentapproval_cron" || ($from_page == "subadminconfig" && $_SESSION['ses_admin_id'] <= 2))
	$allow = "yes";
	
	if($allow == "no" && $frm_page != "admin_panel")
	{
		frame_notices("You are not authorized to access those pages !!","redfont");
		header("location:admin_panel.php");
		exit();
	}
	
	
}

?>