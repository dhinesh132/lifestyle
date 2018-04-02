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
    <tr> 
      <td>

<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
                <tr class="maincontentheading"> 
                  
          <td height="29" colspan="2" align='center' class='whitefont_header'> 
            View Country Details</td>
                </tr>
               
                
                <tr valign="top" class=""> 
                  
          
        <td><span class="whitefont">Country Id</span></td>
                  
            <td> 
              <?php echo stripslashes($country_obj->countryid['value']);
				  
				 
				  ?>
            </td>
                </tr>
                
                <tr valign="top" class=""> 
                  
          
        <td><span class="whitefont">Country Name</span></td>
                  <td><?php echo stripslashes($country_obj->countryname['value']); ?></td>
                </tr>
				
				<tr valign="top" class=""> 
                  
          
        <td><span class="whitefont">Country Code</span></td>
                  <td><?php echo stripslashes($country_obj->countrycode['value']); ?></td>
                </tr>
                <tr valign="top" class=""> 
            
        <td><span class="whitefont">Country Created</span></td>
            <td> <?php echo convert_date(stripslashes($country_obj->created_datetime['value']),"m/d/Y h:i:s"); ?> </td>
          </tr> 
		   <tr valign="top" class=""> 
            
        <td><span class="whitefont">Country Modified</span></td>
            <td> <?php echo convert_date(stripslashes($country_obj->modify_datetime['value']),"m/d/Y h:i:s"); ?> </td>
          </tr> 
				
               <tr> 
				<td align="center" colspan="2"> <input type="button" name="Submit" value="Close" onClick="window.close();">
				</td>
            </tr>
          <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
        </table>	  
 