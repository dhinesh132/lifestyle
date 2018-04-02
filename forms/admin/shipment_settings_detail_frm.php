<?php 



$hid_action = "save";



?>


<script language="JavaScript">

function check_validate()
{

	error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  

	check_empty(form.elements["single_book"].name,"Single book shipping rate should not be empty !!");
	check_empty(form.elements["two_book"].name,"Two book shipping rate should not be empty !!");
	check_empty(form.elements["three_book"].name,"Three book shipping rate should not be empty !!");
	//check_empty(form.elements["free_ship_qty"].name,"Paypal max amount should not be empty !!");
	
}

</script>

	

  <table width="75%" border="0" cellspacing="0" cellpadding="2" align="center">
<form name="settings_frm" method="post" action="">
    <tr valign="top"><td><table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
          <tr class="maincontentheading"> 
            <td height="29" colspan="2" align='center' class='whitefont_header'> 
              Shipment Settings Information </td>
          </tr>
          <!-- Product Related Informations -->
          
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Single Book</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="single_book" value="<?php echo stripslashes($GLOBALS['site_config']['single_book']); ?>">&nbsp;$</td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Two Books</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="two_books" value="<?php echo stripslashes($GLOBALS['site_config']['two_books']); ?>">&nbsp;$</td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Three Books</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="three_books" value="<?php echo stripslashes($GLOBALS['site_config']['three_books']); ?>"> &nbsp;$</td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Free shipping Quantity For S'pore, KL </span></td>
            <td width="50%"> <input type="text" name="free_ship_qty" value="<?php echo stripslashes($GLOBALS['site_config']['free_ship_qty']); ?>"></td>
          </tr>
           <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">USD /SGD Dolor rate </span><span class="starcolor">*</span></td>
            <td><input type="text" name="us_rate" value="<?php echo stripslashes($GLOBALS['site_config']['us_rate']); ?>"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center"> 
                <input type="submit" name="Submit" value="Submit">
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

