<?php 



$hid_action = "save";



?>



	

  <table width="75%" border="0" cellspacing="0" cellpadding="2" align="center">

<form name="settings_frm" method="post" action="">


    <tr valign="top"> 

      <td>



<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
          <tr class="maincontentheading"> 
            <td height="29" colspan="2" align='center' class='whitefont_header'>Project 
              Setting Information </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Require Shipment</span><span class="starcolor">*</span></td>
            <td><select name="require_shipment">
			<option value="0">No</option>
			<option value="1" <?php echo ($GLOBALS['site_config']['require_shipment'] == 1)?"selected":""; ?>>Yes</option>
			</select></td>
          </tr>
		  <?php if(1==2) { ?>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Require Payment Gateway</span><span class="starcolor">*</span></td>
            <td width="50%"><select name="require_payment_gateway">
			<option value="0">No</option>
			<option value="1" <?php echo ($GLOBALS['site_config']['require_payment_gateway'] == 1)?"selected":""; ?>>Yes</option>
			</select></td>
          </tr>
		  <?php } ?>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Require Discount Coupon</span><span class="starcolor">*</span></td>
            <td width="50%"><select name="require_discount_coupon">
			<option value="0">No</option>
			<option value="1" <?php echo ($GLOBALS['site_config']['require_discount_coupon'] == 1)?"selected":""; ?>>Yes</option>
			</select></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Require Product Individual Discount</span><span class="starcolor">*</span></td>
            <td width="50%"><select name="require_product_discount">
			<option value="0">No</option>
			<option value="1" <?php echo ($GLOBALS['site_config']['require_product_discount'] == 1)?"selected":""; ?>>Yes</option>
			</select></td>
          </tr>
		  <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Payment Approval Number of Emails</span><span class="starcolor">*</span></td>
            <td><input type="text" name="pay_app_nof_email" value="<?php echo stripslashes($GLOBALS['site_config']['pay_app_nof_email']); ?>"></td>
          </tr>
		  <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Shipment Approval Number of Emails</span><span class="starcolor">*</span></td>
            <td><input type="text" name="ship_app_nof_email" value="<?php echo stripslashes($GLOBALS['site_config']['ship_app_nof_email']); ?>"></td>
          </tr>
          <!-- Product Related Informations -->
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


