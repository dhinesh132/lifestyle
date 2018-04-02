<?php 



$hid_action = "save";



?>

<script language="JavaScript">

function check_validate()
{

	error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  

	check_empty(form.elements["paypal_url"].name,"Paypal url should not be empty !!");
	Check_website(form.elements["paypal_url"].name,"Enter a valid Paypal url, Paypal url should start with http:// or https://!!");
	check_email(form.elements["paypal_email"].name,"Paypal email should not be empty !!");
	check_empty(form.elements["paypal_max_amount"].name,"Paypal max amount should not be empty !!");
	
}

</script>

	

  <table width="75%" border="0" cellspacing="0" cellpadding="2" align="center">

<form name="settings_frm" method="post" action="" onSubmit="return check_form(window.document.settings_frm);">


    <tr> 

      <td>



<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
          <tr class="maincontentheading"> 
            <td height="29" colspan="2" align='center' class='whitefont_header'>GST settings</td>
          </tr>         
         
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">GST (%)</span><span class="starcolor">*</span></td>
            <td><input type="text" name="gst_percentage" value="<?php echo stripslashes($GLOBALS['site_config']['gst_percentage']); ?>"></td>
          </tr>
           <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">GST Reg No</span><span class="starcolor">*</span></td>
            <td><input type="text" name="gst_reg_no" value="<?php echo stripslashes($GLOBALS['site_config']['gst_reg_no']); ?>"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Check Email</span><span class="starcolor">*</span></td>
            <td><input type="text" name="check_email" value="<?php echo stripslashes($GLOBALS['site_config']['check_email']); ?>"> (0=No, 1=Yes)</td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Check IP</span><span class="starcolor">*</span></td>
            <td><input type="text" name="check_ip" value="<?php echo stripslashes($GLOBALS['site_config']['check_ip']); ?>"> (0=No, 1=Yes)</td>
          </tr>          
          <tr valign="top" class="postaddcontent"> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <!-- Product Related Informations -->
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center"> 
                <input type="image" src="../images/submit.jpg"  name="Submit" value="Submit">
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
              </div></td>
          </tr>
        </table>	  

	  </td>

    </tr>

    <tr> 

            <td align="center">



            </td>

    </tr>

</form>	

  </table>

