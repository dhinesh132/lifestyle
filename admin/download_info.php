<?php
$from_page = "invoice_preview";
require_once("../includes/admin_code_header.php"); 
require_once("../classes/order_master.class.php"); 

$ord_dobj = new order_details();

$res = $ord_dobj->fetch_record($_REQUEST['det_id']);

$close_window = 0;

if($res[1] <= 0)
{
	$close_window = 1;
}

$ord_data = mysql_fetch_object($res[0]);


?>

<html><head><title><?php echo stripslashes($GLOBALS['site_config']['company_name']); ?></title>
<?php require_once("../includes/inside_head_tag.php"); ?>
</head><body marginheight="0" leftmargin="0" rightmargin="0" bottommargin="0" topmargin="0">
<?php if($close_window == 1) { ?>
<script language="JavaScript">
window.close();
</script>
<?php } ?>
<table cellpadding="5" cellspacing="0" width="98%" class="tableborder_new" align="center">
  <tr> 
    <td colspan="2" class="maincontentheading">Download Information</td>
  </tr>
  <tr> 
    <td class="whitefont"> Downloaded on</td>
    <td><?php echo convert_date($ord_data->download_date); ?></td>
  </tr>
  <tr> 
    <td class="whitefont">Download From</td>
    <td><?php echo stripslashes($ord_data->download_ipads); ?>&nbsp;(Ip Address)</td>
  </tr>
  <tr> 
    <td colspan="2" class="maincontentheading"><strong>Registered to</strong></td>
  </tr>
  <tr> 
    <td class="whitefont">First Name</td>
    <td><?php echo stripslashes($ord_data->dwn_fname); ?></td>
  </tr>
  <tr> 
    <td class="whitefont">Last Name</td>
    <td><?php echo stripslashes($ord_data->dwn_lname); ?></td>
  </tr>
  <tr> 
    <td class="whitefont">Email Address</td>
    <td><?php echo stripslashes($ord_data->dwn_email); ?></td>
  </tr>
  <tr align="center" valign="middle"> 
    <td height="40" colspan="2"><a href="#" onClick="window.close();">Close Window</a></td>
  </tr>
</table>
</body></html>