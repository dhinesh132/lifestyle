<?php
$from_page = "invoice_preview";

require_once("../includes/admin_code_header.php"); 

$submit_action = $_REQUEST['submit_action'];

$close_window = 0;

switch ($submit_action)
{

	case "preview":
		
		$edit = 1;
		$edit_id = $_REQUEST['id'];
		
		if($edit_id <= 0)
		{
			/*$list_url = $_REQUEST['list_url'];
			header("location:".$list_url);
			exit();*/
			$close_window = 1;
			
		}
		
	    $display_what = "preview_frm";
		$preview_url = trim($_REQUEST['url']);		
		break;

}

?>

<html><head><title><?php echo stripslashes($GLOBALS['site_config']['company_name']); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php require_once("../includes/inside_head_tag.php"); ?>
</head><body marginheight="0" leftmargin="0" rightmargin="0" bottommargin="0" topmargin="0">
<?php if($close_window == 1) { ?>
<script language="JavaScript">
window.close();
</script>
<?php } ?>
<?php
switch ($display_what)
{
	case "preview_frm":
	require_once($preview_url); 
	break;
}

if(strlen($temp_window_tilte)>0)
{
?>

<script language="JavaScript">
window.document.title = "<?php echo stripslashes($temp_window_tilte); ?>";
</script>
<?php
}
?>
</body></html>