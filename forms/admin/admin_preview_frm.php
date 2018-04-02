<?php 

if( $admin_id > 0)
{
	
	$res = $admin_obj->fetch_record($admin_id);
	$admin_obj = set_values($admin_obj, "db", $res[0]);

}


if(isset($_SESSION['ses_temp_admin_obj']) && is_array($_SESSION['ses_temp_admin_obj']))
{
	$admin_obj = set_values($admin_obj,"ses",$_SESSION['ses_temp_admin_obj']);
}


?>

<table width="75%" border="0" cellspacing="0" cellpadding="2" align="center">
    <tr> 
      <td>

<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
                <tr class="maincontentheading"> 
                  
          <td height="29" colspan="2" align='center' class='whitefont_header'> 
           Admin Preview</td>
                </tr>
               
                
                
            <tr valign="top" class="postaddcontent"> 
                  
            <td><span class="whitefont">Admin Name</span></td>
                  
            <td> <?php echo stripslashes($admin_obj->admin_uname['value']); ?></td>
                </tr>
                
             
                
                <tr valign="top" class="postaddcontent"> 
                  
          <td><span class="whitefont">Admin</span> password</td>
                  <td><?php echo stripslashes($admin_obj->admin_password['value']); ?></td>
                </tr>
                <tr valign="top" class="postaddcontent"> 
                  
          <td><span class="whitefont">Admin</span> Priority</td>
                  <td><?php echo stripslashes($admin_obj->priority['value']); ?></td>
                </tr>
                
        <tr align="center" valign="top" class="postaddcontent"> 
          <td colspan="2">
              <input type="button" name="Submit" value="Close" onClick="window.close();">
            </td>
                </tr>
				
              </table>	  
	  </td>
    </tr>
    
</form>	
  </table>

