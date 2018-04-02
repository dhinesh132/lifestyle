<?php


require_once("admin_header.php"); 

$submit_action = $_REQUEST['submit_action'];

switch ($submit_action)
{

	case "save":
		
		$exclude_arr = array("phpsessid", "submit", "submit_action","paytyp");
		$fpath = "../includes/gst_config_settings.php";
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
			if(is_array($_REQUEST['paytyp']))
			{
				foreach($_REQUEST['paytyp'] as $ky => $vl)
				{
					$qry = "update GSTmethods set paytyp_status = '" . $vl . "' where paymeth_id = '" . $ky . "'";
					$res = $GLOBALS['db_con_obj']->execute_sql($qry, "update");
				}
			}
			frame_notices("GST Configuration Settings Updated Successfully !!", "greenfont");
		}
		else
		{
			frame_notices("Error In Updating Configuration Settings !!", "redfont");
		}
		$redirect_page = 1;
		$redirect_url = "gst_settings.php";
		break;

}


if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}


?>


<table <?php echo $inner_table_param; ?>>
  <tr>
    <td>
<?php
	
require_once("../includes/error_message.php");

require_once("../forms/admin/gst_settings_detail_frm.php");


?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>