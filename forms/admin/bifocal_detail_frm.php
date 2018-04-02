<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script language="javascript">
var frm_obj;
    function check_validate() 
	{
        error_message = "Errors have occurred during the process of your form.\n\nPlease make the following corrections:\n\n";  
		check_empty(form.elements["title"].name,"Title should not be empty");
		
		  
	}

</script>

</script>
 
<?php 

$hid_action = "save";

if($edit == 1 && $edit_id > 0)
{
	
	$res = $sbg_obj->fetch_record($edit_id);
	$sbg_obj = set_values($sbg_obj, "db", $res[0]);

}


if(isset($_SESSION['ses_temp_spg_obj']) && is_array($_SESSION['ses_temp_spg_obj']))
{
	$sbg_obj = set_values($sbg_obj,"ses",$_SESSION['ses_temp_spg_obj']);
}

?>
<form action="" method="post" enctype="multipart/form-data" name="<?php echo $sbg_obj->frm_name; ?>" onSubmit="return check_form(window.document.<?php echo $sbg_obj->frm_name; ?>);">
<table width="55%" border="0" cellspacing="0" cellpadding="2" align="center" class="tableborder_new">
   <tr class="maincontentheading"> 
            <td height="29" colspan="2" align='center' class='whitefont_header'>Focal Details</td>
          </tr> <tr valign="top">
            <td  height="15" class="postaddcontent">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		 <tr valign="top"> 
            <td  height="30" width="23%" class="postaddcontent"><span class="whitefont">Type </span><span class="starcolor">*</span></td>
            <td width="77%"><select name="type_id" class="mediumtxtbox1">
			<option value="1" <?php echo ($sbg_obj->type_id['value'] == 1)?'selected="selected"':""; ?>>Bifocal</option>
                <option value="2" <?php echo ($sbg_obj->type_id['value'] == 2)?'selected="selected"':""; ?> >Multifocal</option>
                
              </select> </td>
    </tr>
          <tr valign="top"> 
            <td  height="30" width="23%" class="postaddcontent"><span class="whitefont">Title </span><span class="starcolor">*</span></td>
            <td width="77%"><input type="text" name="title" value="<?php echo stripslashes($sbg_obj->title['value']); ?>" class="mediumtxtbox">   </td>
    </tr>
            <tr valign="top"> 
            <td  height="30" width="23%" class="postaddcontent"><span class="whitefont">Price</span><span class="starcolor">*</span></td>
            <td width="77%"><input type="text" name="focal_price" value="<?php echo stripslashes($sbg_obj->focal_price['value']); ?>" class="mediumtxtbox">   </td>
    </tr>

	        
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center"> 
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
               <input type="hidden" name="date_entered" value="<?php echo (strlen($sbg_obj->date_entered['value']) > 0)?$sbg_obj->date_entered['value']:date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="date_modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="bid" value="<?php echo $sbg_obj->bid['value']; ?>">
              </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="2"><a href="#"><img align="absmiddle" src="../images/reset.jpg" onClick="window.document.<?php echo $sbg_obj->frm_name; ?>.reset();" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="image" src="../images/submit.jpg" name="Submit" border="0" style="border:0px;" align="absmiddle"> 
              <input type="hidden" value="0" name="boolcheck"> </td>
          </tr>
          <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
  </table>
</form>	

<script language="javascript">
frm_obj = window.document.<?php echo $sbg_obj->frm_name; ?>;	
</script>