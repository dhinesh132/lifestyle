<?php

$from_page = "subadminconfig";
require_once("admin_header.php"); 

$submit_action = $_REQUEST['submit_action'];

switch ($submit_action)
{

	case "save":
		
		$exclude_arr = array("phpsessid", "submit", "submit_action");
		$fpath = "../includes/subadmin_config_settings.php";
		$towrite_str = "<?php\n\n";
		$towrite_str .= "global \$site_config;\n\n";
		
		foreach ($_REQUEST as $key => $value)
		{
			if(!in_array(strtolower($key), $exclude_arr))
			{
				$towrite_str .= "\$site_config['$key'] = \"" . trim($value) . "\";\n\n";
			}
		}
		
		$towrite_str .= "?>";
		
		if(write_file($fpath, $towrite_str, "w"))
		{
			frame_notices("Configuration Settings Updated Successfully !!", "greenfont");
		}
		else
		{
			frame_notices("Error In Updating Configuration Settings !!", "redfont");
		}
		$redirect_page = 1;
		$redirect_url = "subadmin_settings.php";
		break;

}


if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}


?>


<h1>Site Settings </h1>
<?php
	
require_once("../includes/error_message.php");

require_once("../forms/admin/subadmin_settings_detail_frm.php");


?>



<?php 

require_once("admin_footer.php"); 

?>