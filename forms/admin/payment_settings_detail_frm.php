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

	
<div class="whitebox mtop15">
  <table width="75%" border="0" cellspacing="0" cellpadding="2" align="center">

<form name="settings_frm" method="post" action="" onSubmit="return check_form(window.document.settings_frm);">


    <tr> 

      <td>



<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
    
                    <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Paypal Url</span><span class="starcolor">*</span></td>
            <td><input type="text" name="paypal_url" value="<?php echo stripslashes($GLOBALS['site_config']['paypal_url']); ?>" class="mediumtxtbox"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Paypal Email</span><span class="starcolor">*</span></td>
            <td><input type="text" name="paypal_email" value="<?php echo stripslashes($GLOBALS['site_config']['paypal_email']); ?>" class="mediumtxtbox"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Max Amount</span><span class="starcolor">*</span></td>
            <td><input type="text" name="paypal_max_amount" value="<?php echo stripslashes($GLOBALS['site_config']['paypal_max_amount']); ?>" class="mediumtxtbox">
              ($) <input type="hidden" name="auth_max_amount" value="<?php echo abs(stripslashes($GLOBALS['site_config']['auth_max_amount'])); ?>" class="mediumtxtbox"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Currency Type</span><span class="starcolor">*</span></td>
            <td><input type="text" name="currency_type" value="<?php echo stripslashes($GLOBALS['site_config']['currency_type']); ?>" class="mediumtxtbox"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Free Shipping Amount </span></td>
            <td><input type="text" name="freeshipping_amt" value="<?php echo stripslashes($GLOBALS['site_config']['freeshipping_amt']); ?>" class="mediumtxtbox"><br /><span class="starcolor">(Sub Total should >=,  Singapore only)</span></td>
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

    

</form>	

  </table>

</div>