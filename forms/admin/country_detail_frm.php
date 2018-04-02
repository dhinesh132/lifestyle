<script language="javascript">
    function check_validate() {
        error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  
		
        check_empty(form.elements["countryname"].name,"Country name should not be empty");
        
        check_nonnumeric(form.elements["countrycode"].name,"Country code must be string. (e.g. USA for United States)"); 
		}
</script>

<?php 

if($edit == 1 && $edit_id > 0)
{
	
	$res = $country_obj->fetch_record($edit_id);
	$country_obj = set_values($country_obj, "db", $res[0]);

}


if(isset($_SESSION['ses_temp_country_obj']) && is_array($_SESSION['ses_temp_country_obj']))
{
	$country_obj = set_values($country_obj,"ses",$_SESSION['ses_temp_country_obj']);
}


?>

<table width="75%" border="0" cellspacing="0" cellpadding="2" align="center">
<form name="<?php echo $country_obj->frm_name; ?>" method="post" action="" onSubmit="return check_form(window.document.<?php echo $country_obj->frm_name; ?>);">
<?php

//echo $country_obj->frame_validation_script();

?>
    <tr> 
      <td>

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
                <tr class="maincontentheading"> 
                  
            <td height="29" colspan="2" align='center' class='whitefont_header'> 
              Country Details</td>
                </tr>
               
                
               <tr valign="top" class="postaddcontent"> 
                  <td><span class="whitefont">Country Name</span><span class="starcolor">*</span></td>
                  <td><input type="text" name="countryname" value="<?php echo stripslashes($country_obj->countryname['value']); ?>"></td>
                </tr>
                
                <tr valign="top" class="postaddcontent"> 
                  <td><span class="whitefont">Country Code</span><span class="starcolor">*</span></td>
                  <td><input type="text" name="countrycode" value="<?php echo stripslashes($country_obj->countrycode['value']); ?>"></td>
                </tr>
                <tr valign="top" class="postaddcontent"> 
                  <td><span class="whitefont">Country Status</span><span class="starcolor">*</span></td>
                  <td><select name="country_status" class="mediumtxtbox1">
		  <option value="0" selected="selected">In-Active</option>
            <option value="1" <?php echo ($country_obj->country_status['value'] == 1)?'selected="selected"':""; ?>>Active</option>
                
      </select></td>
                </tr>
                <tr valign="top" class="postaddcontent">
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr valign="top" class="postaddcontent"> 
                  <td colspan="2"><div align="center"> 
                      <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
                      <input type="hidden" name="countryid" value="<?php echo $country_obj->countryid['value']; ?>">
					  <input type="hidden" name="created_datetime" value="<?php echo (strlen($country_obj->created_datetime['value']) > 0)?$country_obj->created_datetime['value']:date("Y-m-d H:i:s"); ?>">
                      <input type="hidden" name="modify_datetime" value="<?php echo date("Y-m-d H:i:s"); ?>">
                      
                    </div></td>
                </tr>
          <tr> 
            <td align="center" colspan="2"> <input type="submit" name="Submit" value="Submit">            </td>
          </tr>
          <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
        </table>	  
	  </td>
    </tr> 
</form>	
  </table>