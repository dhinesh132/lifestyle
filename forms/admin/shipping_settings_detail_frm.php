<?php 

$hid_action = "save";

if($edit == 1 && $edit_id > 0)
{
	
	$res = $setting_obj->fetch_record($edit_id);
	$setting_obj = set_values($setting_obj, "db", $res[0]);

}



?>


<form name="<?php echo $setting_obj->frm_name; ?>" method="post" enctype="multipart/form-data" action="" onSubmit="return check_form(window.document.<?php echo $setting_obj->frm_name; ?>);">
<script language="JavaScript">

function check_validate()
{

	error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  
	check_empty(form.elements["zone"].name,"Zone should not be empty");
	//check_empty(form.elements["cat_desc"].name,"Menu url should not be empty");

}

</script>
 <table width="55%" border="0" cellspacing="0" cellpadding="2" align="center" class="tableborder_new">
   <tr class="maincontentheading"> 
            <td height="29" colspan="2" align='center' class='whitefont_header'>Shipping Configuration</td>
          </tr> <tr valign="top">
            <td  height="15" class="postaddcontent">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
          <tr valign="top" class="postaddcontent"> 
            <td height="30"  width="25%"><span class="whitefont">Weight Limit</span><span class="starcolor">* 
              </span></td>
            <td width="50%"> <input type="text" name="WeightLimit" value="<?php echo stripslashes($setting_obj->WeightLimit['value']); ?>" class="smalltxtbox"> 
            </td>
          </tr>
		 
		 
			<tr valign="top" class="postaddcontent"> 
            <td height="30"  width="25%"><span class="whitefont">Zone A Cost</span><span class="starcolor">* 
              </span></td>
            <td width="50%"> <input type="text" name="ZoneAPrice" value="<?php echo stripslashes($setting_obj->ZoneAPrice['value']); ?>" class="smalltxtbox">
            </td>
          </tr>
        
			<tr valign="top" class="postaddcontent"> 
            <td height="30"  width="25%"><span class="whitefont">Zone B Cost</span><span class="starcolor">* 
              </span></td>
            <td width="50%"> <input type="text" name="ZoneBPrice" value="<?php echo stripslashes($setting_obj->ZoneBPrice['value']); ?>" class="smalltxtbox">
            </td>
          </tr>
			<tr valign="top" class="postaddcontent"> 
            <td height="30"  width="25%"><span class="whitefont">Zone C Cost</span><span class="starcolor">* 
              </span></td>
            <td width="50%"> <input type="text" name="ZoneCPrice" value="<?php echo stripslashes($setting_obj->ZoneCPrice['value']); ?>" class="smalltxtbox">
            </td>
          </tr>
        
			<tr valign="top" class="postaddcontent"> 
            <td height="30"  width="25%"><span class="whitefont">Zone D Cost</span><span class="starcolor">* 
              </span></td>
            <td width="50%"> <input type="text" name="ZoneDPrice" value="<?php echo stripslashes($setting_obj->ZoneDPrice['value']); ?>" class="smalltxtbox">
            </td>
          </tr>
         
			<tr valign="top" class="postaddcontent"> 
            <td height="30"  width="25%"><span class="whitefont">Zone E Cost</span><span class="starcolor">* 
              </span></td>
            <td width="50%"> <input type="text" name="ZoneEPrice" value="<?php echo stripslashes($setting_obj->ZoneEPrice['value']); ?>" class="smalltxtbox">
            </td>
          </tr>
           <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Picture</span><span class="starcolor">*</span></td>
            <td width="70%"><input type="file" name="Picture"  class="">
            <?php echo display_view_delete_links($setting_obj, "Picture"); ?></td>
    	 </tr>
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center">
			
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
               
                <input type="hidden" name="id" value="<?php echo $setting_obj->id['value']; ?>">
                </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="2"> <a href="#"><img align="absmiddle" src="../images/reset.jpg" onClick="window.document.<?php echo $setting_obj->frm_name; ?>.reset();" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp; <input align="absmiddle" style="border:0px;" type="image" src="../images/submit.jpg" name="Submit" value="Submit">
            </td>
          </tr>
          <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
        </table>
</form>	