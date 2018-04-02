<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script language="javascript">
var frm_obj;
    function check_validate() 
	{
        error_message = "Errors have occurred during the process of your form.\n\nPlease make the following corrections:\n\n";  
		check_empty(form.elements["EnName"].name,"English Title should not be empty");
		check_empty(form.elements["ChName"].name,"Chinese Title should not be empty");
		  
	}

</script>

</script>
 
<?php 

$hid_action = "save";

if($edit == 1 && $edit_id > 0)
{
	
	$res = $fun_obj->fetch_record($edit_id);
	$fun_obj = set_values($fun_obj, "db", $res[0]);

}


if(isset($_SESSION['ses_temp_fun_obj']) && is_array($_SESSION['ses_temp_fun_obj']))
{
	$fun_obj = set_values($fun_obj,"ses",$_SESSION['ses_temp_fun_obj']);
}

?>
<div class="whitebox mtop15">
<form action="" method="post" enctype="multipart/form-data" name="<?php echo $fun_obj->frm_name; ?>" onSubmit="return check_form(window.document.<?php echo $fun_obj->frm_name; ?>);">
<table width="55%" border="0" cellspacing="0" cellpadding="2" align="center" class="tableborder_new">
 
          <tr valign="top"> 
            <td  height="30" width="23%" class="postaddcontent"><span class="whitefont">English Title </span><span class="starcolor">*</span></td>
            <td width="77%"><input type="text" name="EnName" value="<?php echo stripslashes($fun_obj->EnName['value']); ?>" class="mediumtxtbox">   </td>
    	 </tr>
        <tr valign="top"> 
            <td  height="30" class="postaddcontent"><span class="whitefont">Alias URL </span></td>
            <td width="60%"><input type="text" name="UniqueKey_temp" value="<?php echo stripslashes($fun_obj->UniqueKey['value']); ?>" class="mediumtxtbox">   </td>
    </tr>
          <tr valign="top"> 
                <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Meta Title</span></td>
                <td width="70%"><textarea name="MetaTitle" cols="50" rows="3"><?php echo stripslashes($fun_obj->MetaTitle['value']); ?></textarea>  </td>
    	 	</tr>
            <tr valign="top"> 
                <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Keywords</span></td>
                <td width="70%"><textarea name="MetaKey" cols="50" rows="3"><?php echo stripslashes($fun_obj->MetaKey['value']); ?></textarea> </td>
    	 	</tr>
            <tr valign="top"> 
                <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Description</span></td>
                <td width="70%"><textarea name="MetaDesc" cols="50" rows="3"><?php echo stripslashes($fun_obj->MetaDesc['value']); ?></textarea>   </td>
    	 	</tr>

	        <tr valign="top" class="postaddcontent">
	          <td  height="30"><span class="whitefont">Status</span></td>
            <td><select name="FunStatus" class="mediumtxtbox">
			<option value="0" <?php echo ($fun_obj->FunStatus['value'] == 0)?"selected":""; ?>>In-Active</option>
                <option value="1" <?php echo ($fun_obj->FunStatus['value'] == 1)?"selected":""; ?>>Active</option>
                
              </select></td>
              </tr>
    <tr valign="top" class="postaddcontent"> 
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center"> 
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
               <input type="hidden" name="CreatedDate" value="<?php echo (strlen($fun_obj->CreatedDate['value']) > 0)?$fun_obj->CreatedDate['value']:date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="FunId" value="<?php echo $fun_obj->FunId['value']; ?>">
              </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="2"><a href="#"><img align="absmiddle" src="../images/reset.jpg" onClick="window.document.<?php echo $fun_obj->frm_name; ?>.reset();" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="image" src="../images/submit.jpg" name="Submit" border="0" style="border:0px;" align="absmiddle"> 
              <input type="hidden" value="0" name="boolcheck"> </td>
          </tr>
          <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
  </table>
</form>	
</div>
<script language="javascript">
frm_obj = window.document.<?php echo $fun_obj->frm_name; ?>;	
</script>