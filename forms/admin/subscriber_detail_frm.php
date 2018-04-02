<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script language="javascript">
var frm_obj;
    function check_validate() 
	{
        error_message = "Errors have occurred during the process of your form.\n\nPlease make the following corrections:\n\n";  
		
		//check_empty(form.elements["pl_id"].name,"Page library should not be empty");
        check_empty(form.elements["name"].name,"Name should not be empty");
		 check_email(form.elements["email"].name,"Email should not be empty");
		
		  
	}

</script>

</script>
 
<?php 

$hid_action = "save";

if($edit == 1 && $edit_id > 0)
{
	
	$res = $email_obj->fetch_record($edit_id);
	$email_obj = set_values($email_obj, "db", $res[0]);

}


if(isset($_SESSION['ses_subscriber_obj']) && is_array($_SESSION['ses_subscriber_obj']))
{
	$email_obj = set_values($email_obj,"ses",$_SESSION['ses_subscriber_obj']);
}

?>
<div class="whitebox mtop15">
<form action="" method="post" enctype="multipart/form-data" name="<?php echo $email_obj->frm_name; ?>" onSubmit="return check_form(window.document.<?php echo $email_obj->frm_name; ?>);">
<table width="68%" border="0" cellspacing="0" cellpadding="2" align="center" class="tableborder_new">

		 
          <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Name</span><span class="starcolor">*</span></td>
            <td width="7%"><input type="text"  name="name" value="<?php echo stripslashes($email_obj->name['value']); ?>" class="mediumtxtbox"> </td>
    </tr>
      <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Email</span><span class="starcolor">*</span></td>
            <td width="70%"><input type="text"  name="email" value="<?php echo stripslashes($email_obj->email['value']); ?>" class="mediumtxtbox"> </td>
    </tr>
    
     <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Contact No</span><span class="starcolor">*</span></td>
            <td width="70%"><input type="text"  name="ContactNo" value="<?php echo stripslashes($email_obj->ContactNo['value']); ?>" class="mediumtxtbox"> </td>
    </tr>
     
	        <tr valign="top" class="postaddcontent">
	          <td  height="30"><span class="whitefont">Status</span></td>
            <td><select name="status" class="mediumtxtbox">
			<option value="0" <?php echo ($email_obj->status['value'] == 0)?"selected":""; ?>>In-Active</option>
                <option value="1" <?php echo ($email_obj->status['value'] == 1)?"selected":""; ?>>Active</option>
                
              </select></td>
    <tr valign="top" class="postaddcontent"> 
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center"> 
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
               <input type="hidden" name="date_entered" value="<?php echo (strlen($email_obj->date_entered['value']) > 0)?$email_obj->date_entered['value']:date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="date_modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="id" value="<?php echo $email_obj->id['value']; ?>">
              </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="2"><a href="#"><img align="absmiddle" src="../images/reset.jpg" onClick="window.document.<?php echo $prod_obj->frm_name; ?>.reset();" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="image" src="../images/submit.jpg" name="Submit" border="0" style="border:0px;" align="absmiddle"> 
              <input type="hidden" value="0" name="boolcheck"> </td>
          </tr>
        
  </table>
</form>	
</div>
<script language="javascript">
frm_obj = window.document.<?php echo $email_obj->frm_name; ?>;	
</script>