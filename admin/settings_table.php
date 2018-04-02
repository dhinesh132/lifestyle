<?php
require_once("admin_header.php"); 

require_once("../classes/settings_table.class.php");

$sbg_obj = new settings_table();


$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";



switch ($submit_action)
{
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;


	case "save":
		$id = $_REQUEST[$sbg_obj->primary_fld];
		
		foreach($_REQUEST as $key =>$val)
		{	
			
			$update ="update ".$sbg_obj->cls_tbl." set amount='".$val."' where id='".$key."'";
			$GLOBALS['db_con_obj']->execute_sql($update, "update");
			frame_notices("Prices updated successfully !!", "greenfont");
		}
		
			
		$redirect_page = 1;
		
		$redirect_url = "settings_table.php";
		
		
		break;


} //end switch


if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}
	
?>


<table <?php echo $inner_table_param; ?> align="center">
  <tr>
    <td>
<?php
	
require_once("../includes/error_message.php");

require_once("../forms/admin/settings_table_frm.php");


?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>