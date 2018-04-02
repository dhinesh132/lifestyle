<?php
require_once("admin_header.php"); 

require_once("../classes/admin.class.php");

$admin_obj = new admin();

$submit_action = $_REQUEST['submit_action'];

$submit_action1 = $_REQUEST['submit_action1'];

$display_what = "list_frm";



switch ($submit_action)
{
	case "preview":
		$admin_id = $_REQUEST[$admin_obj->primary_fld];
		if($admin_id <= 0)
		{
			header("location:admin.php");
			exit();
		}
		
		$edit_res = $admin_obj->fetch_record($admin_id);
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$admin_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:admin.php");
			exit();
		}
		
		$edit_res = $admin_obj->fetch_record($id);
		
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		//$GLOBALS['site_config']['debug'] =1;
		$id = $_REQUEST[$admin_obj->primary_fld];
		$admin_obj->priority['save_todb']="true";
		$admin_obj->assigned_modules['save_todb']="true";
		if($_REQUEST['access_level'] ==2){
			
			$admin_obj->priority['value']="9";
			$admin_obj->assigned_modules['value'] ="all";
		}
		else{
			
			$admin_obj->priority['value']="8";
			$admin_obj->assigned_modules['value']=$call_center_allowed_modules;
		}
		
		//exit;
		//$admin_obj->assigned_modules['value'] = implode(",", $_REQUEST['assigned_modules']);

		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($admin_obj->insert())
				$redirect_url = "admin.php";
			else
				$redirect_url = "admin.php?submit_action=add";
		
		}
		else
		{//update the record
			if($admin_obj->update($id))
				$redirect_url = "admin.php";
			else
				$redirect_url = "admin.php?submit_action=edit&" . $admin_obj->primary_fld . "=" . $_REQUEST[$admin_obj->primary_fld];
		} 
		//exit;
		break;



	case "delete":
		$id = $_REQUEST[$admin_obj->primary_fld];
		if($id <= 0)
		{
			header("location:admin.php");
			exit();
		}
		else
		{
		
			$admin_obj->delete($id);				
		
			$redirect_page = 1;
			$redirect_url = "admin.php";
		}
		break;

} //end switch
//print_r($_SESSION);

switch ($submit_action1)
{
	
	
	case "change":
		$id = $_REQUEST[$admin_obj->primary_fld];

		$redirect_page = 1;
		if($admin_obj->changepwd($id))
			$redirect_url = "admin.php?submit_action1=add&" . $admin_obj->primary_fld . "=" . $_SESSION['ses_admin_id'];
		else
			$redirect_url = "admin.php?submit_action1=add&" . $admin_obj->primary_fld . "=" . $_SESSION['ses_admin_id'];
				 
		break;
		
	case "add":
		$display_what = "chpwd_frm";
		$hid_action = "change";
		break;
		
	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$admin_obj->primary_fld];
		if($edit_id <= 0)
		{
			header("location:admin.php");
			exit();
		}
		
		$edit_res = $admin_obj->fetch_record($id);
		
		$display_what = "chpwd_frm";
		$hid_action = "save";
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

switch ($display_what)
{
	
	case "detail_frm":
		require_once("../forms/admin/admin_detail_frm.php"); 
		break;

	case "list_frm":
		require_once("../forms/admin/admin_list_frm.php"); 
		break;

	case "preview_frm":
		require_once("../forms/admin/admin_preview_frm.php"); 
		break;
		
	case "chpwd_frm":
		require_once("../forms/admin/chg_pwd.php"); 
		break;
		

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>