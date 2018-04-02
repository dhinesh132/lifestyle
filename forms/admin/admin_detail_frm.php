<?php 

$hid_action = "save";

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

check_empty(form.elements["admin_uname"].name,"Enter Admin name!");
Check_Lengthlow(form.elements["admin_uname"].name, "Admin Name should be have a minimum of 4 and a maximum of 12 characters!", "4");
Check_Lengthhigh(form.elements["admin_uname"].name, "Admin Name should be have a minimum of 4 and a maximum of 12 characters!", "12");
check_empty(form.elements["priority"].name,"Select a Priority!");
check_empty(form.elements["admin_password"].name, "Enter your password!");
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
              Admin Details</td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Admin Name</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="admin_uname" value="<?php echo stripslashes($admin_obj->admin_uname['value']); ?>"> 
            </td>
          </tr>
            <?php if(1==2){?>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Priority</span><span class="starcolor">*</span></td>
            <td>
              <?php
				  
				  if($_SESSION['ses_admin_id'] == $admin_obj->admin_id['value'])
				  {
				  ?>
              <input type="hidden" name="priority" value="<?php echo $admin_obj->priority['value']; ?>"> 
              <?php
				  }
				  else
				  {
				  ?>
              <select name="priority">
                <option value="">Select Priority</option>
                <?php
				  for($i = ($_SESSION['ses_admin_priority'] - 1); $i > 0;$i--)
				  {
				  ?>
                <option value="<?php echo $i; ?>" <?php echo ($admin_obj->priority['value'] == $i)?"selected":""; ?>><?php echo $i; ?></option>
                <?php
				  }
				  ?>
              </select>
              <?php
				  
				  }
				  
				  ?>
              (10 - Top most admin, 1 - Admin with lesser features)</td>
          </tr>
          <?php

  			$temp_adm_mod = $admin_obj->assigned_modules['value'];
			
			$temp_adm_mod_arr = explode(",", $temp_adm_mod);
			
			$all_module_status = (in_array("all",$temp_adm_mod_arr))?"selected":"";

		  ?>
          <tr valign="top" class="postaddcontent">
            <td>Select Modules<span class="starcolor">*</span></td>
            <td><select name="modules[]" size="5" multiple>
			<?php if($_SESSION['ses_admin_priority'] == 10) { ?>
			<option value="all" <?php echo $all_module_status; ?>>All Modules</option>
			<?php
			}			
			foreach ($GLOBALS['available_modules'] as $key => $value)
			{
			
			$sel = (in_array($value,$temp_adm_mod_arr) || $all_module_status == "selected")?"selected":"";
			
			?>
			<option value="<?php echo $value; ?>" <?php echo $sel; ?>><?php echo $key; ?></option>
			<?php
			
			}
			
			?>
              </select></td>
          </tr>
          <?php }?>
           <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Access Level</span><span class="starcolor">*</span></td>
            <td>
             <select name="access_level">
                <option value="">Access Level</option>
                 <option value="2" <?php echo ($admin_obj->access_level['value'] ==2)?'selected="selected"':'';?> >Top Level Admin </option>
                 <option value="3"  <?php echo ($admin_obj->access_level['value'] ==3)?'selected="selected"':'';?>>Medium Level Admin</option>
                 <option value="4"  <?php echo ($admin_obj->access_level['value'] ==4)?'selected="selected"':'';?>>Low Level Admin</option>
             </select>
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
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
                <input type="hidden" name="project" value="1">
                <input type="hidden" name="cust_id" value="<?php echo $admin_obj->cust_id['value']; ?>">
                <input type="hidden" name="date_entered" value="<?php echo (strlen($admin_obj->date_entered['value']) > 0)?$admin_obj->date_entered['value']:date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="date_modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
                <input type="submit" name="Submit" value="Submit">
              </div></td>
          </tr>
        </table>	  
	  </td>
    </tr>
    
</form>	
  </table>
