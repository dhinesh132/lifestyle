<?php 

$hid_action = "save";

if($edit == 1 && $edit_id > 0)
{
	
	$res = $shipping_obj->fetch_record($edit_id);
	$shipping_obj = set_values($shipping_obj, "db", $res[0]);

}



?>
<script language="JavaScript">

function check_validate()
{

	error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  
	check_empty(form.elements["zone"].name,"Zone should not be empty");
	//check_empty(form.elements["cat_desc"].name,"Menu url should not be empty");

}

</script>
<div class="whitebox mtop15">
<form name="<?php echo $shipping_obj->frm_name; ?>" method="post" action="" onSubmit="return check_form(window.document.<?php echo $shipping_obj->frm_name; ?>);">


 <table width="55%" border="0" cellspacing="0" cellpadding="2" align="center" class="tableborder_new">
   <tr class="maincontentheading"> 
            <td height="29" colspan="2" align='center' class='whitefont_header'>Shipping Details</td>
          </tr> <tr valign="top">
            <td  height="15" class="postaddcontent">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
          <tr valign="top" class="postaddcontent"> 
            <td height="30"  width="25%"><span class="whitefont">Weight From</span><span class="starcolor">* 
              </span></td>
            <td width="50%"> <input type="text" name="WeightFrom" value="<?php echo stripslashes($shipping_obj->WeightFrom['value']); ?>" class="mediumtxtbox"> 
            </td>
          </tr>
          
           <tr valign="top" class="postaddcontent"> 
            <td height="30"  width="25%"><span class="whitefont">Weight To</span><span class="starcolor">* 
              </span></td>
            <td width="50%"> <input type="text" name="WeightTo" value="<?php echo stripslashes($shipping_obj->WeightTo['value']); ?>" class="mediumtxtbox"> 
            </td>
          </tr>
		 
		  <tr valign="top" class="postaddcontent">
            <td valign="top"><span class="whitefont" >Zone A Countries</span></td>
            <td> <textarea name="ZoneACountry" cols="50" rows="5"><?php echo stripslashes($shipping_obj->ZoneACountry['value']); ?></textarea> </td>
			</tr>
			<tr valign="top" class="postaddcontent"> 
            <td height="30"  width="25%"><span class="whitefont">Zone A Cost</span><span class="starcolor">* 
              </span></td>
            <td width="50%"> <input type="text" name="ZoneAPrice" value="<?php echo stripslashes($shipping_obj->ZoneAPrice['value']); ?>" class="smalltxtbox"> <a href="" onclick="popup_window('basedesign_nh.php?submit_action=preview&id=1&url=countrylist.php&list_url=<?php echo $list_url; ?>',600,400,'yes','yes')";>Check Country Code</a>
            </td>
          </tr>
          <tr valign="top" class="postaddcontent">
            <td valign="top"><span class="whitefont" >Zone B Countries</span></td>
            <td> <textarea name="ZoneBCountry" cols="50" rows="5"><?php echo stripslashes($shipping_obj->ZoneBCountry['value']); ?></textarea> </td>
			</tr>
			<tr valign="top" class="postaddcontent"> 
            <td height="30"  width="25%"><span class="whitefont">Zone B Cost</span><span class="starcolor">* 
              </span></td>
            <td width="50%"> <input type="text" name="ZoneBPrice" value="<?php echo stripslashes($shipping_obj->ZoneBPrice['value']); ?>" class="smalltxtbox"> <a href="" onclick="popup_window('basedesign_nh.php?submit_action=preview&id=1&url=countrylist.php&list_url=<?php echo $list_url; ?>',600,400,'yes','yes')";>Check Country Code</a>
            </td>
          </tr>
          <tr valign="top" class="postaddcontent">
            <td valign="top"><span class="whitefont" >Zone C Countries</span></td>
            <td> <textarea name="ZoneCCountry" cols="50" rows="5"><?php echo stripslashes($shipping_obj->ZoneCCountry['value']); ?></textarea> </td>
			</tr>
			<tr valign="top" class="postaddcontent"> 
            <td height="30"  width="25%"><span class="whitefont">Zone C Cost</span><span class="starcolor">* 
              </span></td>
            <td width="50%"> <input type="text" name="ZoneCPrice" value="<?php echo stripslashes($shipping_obj->ZoneCPrice['value']); ?>" class="smalltxtbox"> <a href="" onclick="popup_window('basedesign_nh.php?submit_action=preview&id=1&url=countrylist.php&list_url=<?php echo $list_url; ?>',600,400,'yes','yes')";>Check Country Code</a>
            </td>
          </tr>
          <tr valign="top" class="postaddcontent">
            <td valign="top"><span class="whitefont" >Zone D Countries</span></td>
            <td> <textarea name="ZoneDCountry" cols="50" rows="5"><?php echo stripslashes($shipping_obj->ZoneDCountry['value']); ?></textarea> </td>
			</tr>
			<tr valign="top" class="postaddcontent"> 
            <td height="30"  width="25%"><span class="whitefont">Zone D Cost</span><span class="starcolor">* 
              </span></td>
            <td width="50%"> <input type="text" name="ZoneDPrice" value="<?php echo stripslashes($shipping_obj->ZoneDPrice['value']); ?>" class="smalltxtbox"> <a href="" onclick="popup_window('basedesign_nh.php?submit_action=preview&id=1&url=countrylist.php&list_url=<?php echo $list_url; ?>',600,400,'yes','yes')";>Check Country Code</a>
            </td>
          </tr>
          <tr valign="top" class="postaddcontent">
            <td valign="top"><span class="whitefont" >Zone E Countries</span></td>
            <td> <textarea name="ZoneECountry" cols="50" rows="5"><?php echo stripslashes($shipping_obj->ZoneECountry['value']); ?></textarea> </td>
			</tr>
			<tr valign="top" class="postaddcontent"> 
            <td height="30"  width="25%"><span class="whitefont">Zone E Cost</span><span class="starcolor">* 
              </span></td>
            <td width="50%"> <input type="text" name="ZoneEPrice" value="<?php echo stripslashes($shipping_obj->ZoneEPrice['value']); ?>" class="smalltxtbox"> <a href="" onclick="popup_window('basedesign_nh.php?submit_action=preview&id=1&url=countrylist.php&list_url=<?php echo $list_url; ?>',600,400,'yes','yes')";>Check Country Code</a>
            </td>
          </tr>
          
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center">
			
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
               
                <input type="hidden" name="id" value="<?php echo $shipping_obj->id['value']; ?>">
                </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="2"> <a href="#"><img align="absmiddle" src="../images/reset.jpg" onClick="window.document.<?php echo $shipping_obj->frm_name; ?>.reset();" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp; <input align="absmiddle" style="border:0px;" type="image" src="../images/submit.jpg" name="Submit" value="Submit">
            </td>
          </tr>
          <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
        </table>
</form>	
</div>