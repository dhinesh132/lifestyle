<?php
if($from_page == "payment")

{
	$back_page = "ship_bill.php";	
	$submit_action = "save_payment";
	$selection_ddname = "payment_method";
	$alert_msg = "Payment method should not be empty ";
	$action_url = "";

}
?>
<script language="javascript">
    function check_validate() {}
</script>

<form name="cart_frm" id="cart_frm" method="post" action="<?php echo $action_url; ?>" >

<input type="hidden" name="submit_action" value="<?php echo $submit_action; ?>">
<input type="text" name="payment_method" value="4" style="display : none;"><input type="hidden" name="ship1_email"  value="0" />
      <table width="100%" border="0" cellspacing="0" cellpadding="4">

         
        
          <tr> 

            <td align="left" width="20%" valign="top"> <font class="postaddcontent"><?php echo BILLINGADDRESS?>:</font></td>

            <td width="40%" valign="top" align="left" style="text-align:left;"><?php 
			  echo stripslashes($_SESSION['ses_ship_bill_arr']['bfname'] . " " . $_SESSION['ses_ship_bill_arr']['blname']) . "<br>";
              echo stripslashes($_SESSION['ses_ship_bill_arr']['baddress1']) . "<br>";
			  if(strlen(trim($_SESSION['ses_ship_bill_arr']['baddress2'])) > 0)
              echo stripslashes($_SESSION['ses_ship_bill_arr']['baddress2']) . "<br>";
			  echo stripslashes($_SESSION['ses_ship_bill_arr']['bcity']).",";
              echo $_SESSION['ses_ship_bill_arr']['bstate']."<br>";
              $bctry = $db_con_obj->fetch_field("country", "countryname", "countryid = '". $_SESSION['ses_ship_bill_arr']['bcountry'] . "'");

			  if(strlen($bctry) > 0)

			  echo stripslashes($bctry . "- " . $_SESSION['ses_ship_bill_arr']['bzip']);?>.
              <br /> 
			  <?php 
			  echo "Mobile :". $_SESSION['ses_ship_bill_arr']['bmobile']."<br>";
			  if(strlen($_SESSION['ses_ship_bill_arr']['blandline']) >0)
			  echo "Landline :". $_SESSION['ses_ship_bill_arr']['blandline']."<br>";
			  ?>
              </td>

            <td nowrap width="30%" align="right" valign="top"> <font class="postaddcontent"><?php echo COMPANYADDRESS;?>:</font> </td>

            <td width="20%" valign="top" align="left" nowrap style="text-align:left;"> <font class="itemfont"><?php
											echo trim($GLOBALS['site_config']['company_name']) . "<br>";
											echo nl2br($GLOBALS['site_config']['company_address']) . "<br>";
										?>

              </font> </td>

          </tr>

         
          <tr valign="top"> 
            <td align="left"><?php echo SHIPPINGADDRESS?>:</td>
            <td style="text-align:left;"><?php 
			  echo stripslashes($_SESSION['ses_ship_bill_arr']['fname'] . " " . $_SESSION['ses_ship_bill_arr']['lname']) . "<br>";
              echo stripslashes($_SESSION['ses_ship_bill_arr']['address1']) . "<br>";
			  if(strlen(trim($_SESSION['ses_ship_bill_arr']['address2'])) > 0)
              echo stripslashes($_SESSION['ses_ship_bill_arr']['address2']) . "<br>";
			  echo stripslashes($_SESSION['ses_ship_bill_arr']['city']).",";
			  echo $_SESSION['ses_ship_bill_arr']['state']."<br>";
              $bctry_res = $db_con_obj->fetch_flds("country", "countryname,countrycode", "countryid = '". $_SESSION['ses_ship_bill_arr']['country'] . "'");
			  $bctry_data = mysql_fetch_object($bctry_res[0]);
			  if(strlen($bctry) > 0)
			  echo stripslashes($bctry_data->countryname . " " . $_SESSION['ses_ship_bill_arr']['zip']);
			  ?>.
               <br /> 
			  <?php 
			  echo "Mobile :". $_SESSION['ses_ship_bill_arr']['mobile']."<br>";
			  if(strlen($_SESSION['ses_ship_bill_arr']['landline']) >0)
			  echo "Landline :". $_SESSION['ses_ship_bill_arr']['landline']."<br>";
			  ?>
			</td>
            <td align="right"><?php echo SHIPFROM;?>:</td>
            <td style="text-align:left;">
              <?php	
			   echo trim(stripslashes($GLOBALS['site_config']['company_name'])) . "<br>";
			   echo nl2br(stripslashes($GLOBALS['site_config']['company_address'])) . "<br>";
			  ?>
              </font></td>
          </tr>
          </table>
          
              <?php
				require_once("forms/viewbasket_frm.php");
			  ?>
              <br />
               <div align="center"><a style=" margin-left:10px;" class="gradient-btn" href="ship_bill.php"><?php echo GOBACK ?></a>
                 <a href="javascript:void(0)" class="orage_gradient-btn" style="color:#FFFFFF; margin-left:510px;" onclick="if(check_form(window.document.cart_frm)){$('#cart_frm').submit();};"><?php echo PAYNOWBTN ?></a>
                 </div>
 </form>


