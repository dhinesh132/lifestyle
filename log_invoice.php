<?php 
$from_page = "invoice";

if($popup == "1")
	require_once("includes/code_header.php");
else
	require_once("header.php"); 

require_once("classes/order_master.class.php");

$ord_m_obj = new order_master();
$ord_d_obj = new order_details();

$master_res = $ord_m_obj->fetch_record($_REQUEST['order_id']);
$detail_res = $ord_d_obj->fetch_flds($ord_d_obj->cls_tbl,"*", "order_id = '" . $_REQUEST['order_id'] . "'");

$master_data = mysql_fetch_object($master_res[0]);

$paymeth = $master_data->pay_method;

if($popup == 1)
{
?>
<html><head><title><?php echo stripslashes($GLOBALS['site_config']['company_name']); ?></title>
<?php require_once("includes/inside_head_tag.php"); ?>
</head><body marginheight="0" leftmargin="0" rightmargin="0" bottommargin="0" topmargin="0">
<?php if($close_window == 1) { ?>
<script language="JavaScript">
window.close();
</script>
<?php 

} 

}

?>


<table <?php echo $inner_table_param; ?>>
  <tr>
    <td><?php
	
	require_once("includes/error_message.php");
	
	
	switch ($paymeth)
	{
		
		case "2":
			
			require_once("forms/invoice_dets_frm.php");
			break;
		
		default:
			require_once("forms/invoice_dets_frm.php");
			break;
		
	}
	
	
	?></td>
  </tr>
</table>


<?php 
if($popup == "1")
{
?>
</body></html>
<?php
}
else
{
	require_once("footer.php"); 
}
?>