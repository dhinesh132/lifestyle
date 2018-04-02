<?php 

$hid_action = "change";
if($edit == 1 && $edit_id )
{
	
	$res = $admin_obj->fetch_record($edit_id);
	$admin_obj = set_values($admin_obj, "db", $res[0]);

}


if(isset($_SESSION['ses_temp_admin_obj']) && is_array($_SESSION['ses_temp_admin_obj']))
{
	$admin_obj = set_values($admin_obj,"ses",$_SESSION['ses_temp_admin_obj']);
}


?>

<script language="javascript">
function check_validate() {

error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";

check_empty(form.elements["admin_pass"].name, "Enter your Old password!");
check_empty(form.elements["admin_password"].name, "Enter your New password!");
check_match(form.elements["admin_password"].name, form.elements["cadmin_password"].name, "Passwords do not match!");
Check_Lengthlow(form.elements["admin_password"].name, "Password should be have a minimum of 4 and a maximum of 12 characters!", "4");
Check_Lengthhigh(form.elements["admin_password"].name, "Password should be have a minimum of 4 and a maximum of 12 characters!", "12");

}</script>	
  <table width="75%" border="0" cellspacing="0" cellpadding="2" align="center">
<form name="<?php echo $admin_obj->frm_name; ?>" method="post" action="" onSubmit="return check_form(window.document.<?php echo $admin_obj->frm_name; ?>);">
<?php

//echo $admin_obj->frame_validation_script();

?>
    <tr> 
      <td>

<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
                <tr class="maincontentheading"> 
                  
            <td height="29" colspan="2" align='center' class='whitefont_header'> 
              Change Password</td>
                </tr>
                <tr valign="top" class="postaddcontent"> 
                  <td width="50%"><span class="whitefont">Old Password</span><span class="starcolor">*</span></td>
                  <td width="50%"> <input type="text" name="admin_pass" value=""> 
                  </td>
                </tr>
                
                <tr valign="top" class="postaddcontent"> 
                  <td><span class="whitefont">Password</span><span class="starcolor">*</span></td>
                  <td><input type="<?php echo ($GLOBALS['in_admin'] == 1)?"password":"password"; ?>" name="admin_password" value="<?php echo stripslashes($admin_obj->admin_password['value']); ?>"></td>
                </tr>
                <tr valign="top" class="postaddcontent"> 
                  <td><span class="whitefont">Confirm Password</span><span class="starcolor">*</span></td>
                  <td><input type="<?php echo ($GLOBALS['in_admin'] == 1)?"password":"password"; ?>" name="cadmin_password" value="<?php echo stripslashes($admin_obj->admin_password['value']); ?>"></td>
                </tr>
                <tr valign="top" class="postaddcontent"> 
                  <td colspan="2"><div align="center"> 
                      <input type="hidden" name="submit_action1" value="change">
                      <input type="hidden" name="admin_id" value="<?php echo $_SESSION['ses_admin_id']; ?>">
                <input align="absmiddle" style="border:0px;" type="image" src="../images/submit.jpg" name="Submit" value="Submit">&nbsp;&nbsp;&nbsp;&nbsp;<img align="absmiddle" src="../images/reset.jpg" onClick="window.document.<?php echo $admin_obj->frm_name; ?>.reset();">
				
                <input type="hidden" name="date_modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
                    </div></td>
                </tr>
              </table>	  
	  </td>
    </tr>
    <tr> 
            
      <td align="center">&nbsp; </td>
    </tr>
</form>	
  </table>
