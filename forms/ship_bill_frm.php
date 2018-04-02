<?php
if($_SESSION['ses_customer_id'] !=2){
	$res = $cust_obj->fetch_record($_SESSION['ses_customer_id']);
	$cust_obj = set_values($cust_obj, "db", $res[0]);

	$fname = $cust_obj->cust_firstname['value'];
	$lname = $cust_obj->cust_lastname['value'];
	$address1 = $cust_obj->cust_address1['value'];
	$address2 = $cust_obj->cust_address2['value'];
	$mobile = $cust_obj->cust_phone['value'];
	$landline = $cust_obj->cust_landline['value'];
	$city = $cust_obj->cust_city['value'];
	if(is_numeric($cust_obj->cust_state['value']))
	{
		$state = $db_con_obj->fetch_field("state","state_code",$cust_obj->cust_state['value']);
	}
	else
		$state = $cust_obj->cust_state['value'];
	
	$zip = $cust_obj->cust_zip['value'];
	$country = $cust_obj->cust_country['value'];
	$ship_email = $cust_obj->cust_email['value'];

	$bfname = $cust_obj->cust_firstname['value'];
	$blname = $cust_obj->cust_lastname['value'];
	$baddress1 = $cust_obj->cust_address1['value'];
	$baddress2 = $cust_obj->cust_address2['value'];
	$bmobile = $cust_obj->cust_phone['value'];
	$blandline = $cust_obj->cust_landline['value'];
	$bcity = $cust_obj->cust_city['value'];
	if(is_numeric($cust_obj->cust_state['value']))
	{
		$bstate = $db_con_obj->fetch_field("state","state_code",$cust_obj->cust_state['value']);
	}
	else
		$bstate = $cust_obj->cust_state['value'];
	
	$bzip = $cust_obj->cust_zip['value'];
	$bcountry = $cust_obj->cust_country['value'];
	
	$display_fld = "state_code";

}
if(is_array($_SESSION['ses_ship_bill_arr']) && count($_SESSION['ses_ship_bill_arr']) > 0)
{
	foreach($_SESSION['ses_ship_bill_arr'] as $key => $value)
	${$key} = $value;
}

?>
<script language="javascript">
    function check_validate() {

        error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";
        check_empty(form.elements["fname"].name,"First name for shipping details should not be empty");
        check_empty(form.elements["lname"].name,"Last name for shipping details should not be empty");
        check_empty(form.elements["address1"].name,"Address1 for shipping details should not be empty");
		check_empty(form.elements["mobile"].name,"Mobile for shipping details should not be empty");
        check_empty(form.elements["city"].name,"City for shipping details should not be empty");
        check_empty(form.elements["state"].name,"State for shipping details should not be empty");
        check_empty(form.elements["country"].name,"Country for shipping details should not be empty");
        if((form.country.value != 222)&&(form.country.value != 36))
           check_numeric(form.elements["zip"].name,"zip code for shipping details should be numeric");
          
		check_email(form.elements["ship_email"].name,"Email should not be empty");

		
        check_empty(form.elements["bfname"].name,"First name for billing details should not be empty");
        check_empty(form.elements["blname"].name,"Last name for billing details should not be empty");
        check_empty(form.elements["baddress1"].name,"Address1 for billing details should not be empty");
		 check_empty(form.elements["bmobile"].name,"Mobile for billing details should not be empty");
        check_empty(form.elements["bcity"].name,"City for billing details should not be empty");
        check_empty(form.elements["bstate"].name,"State for billing details should not be empty");
        check_empty(form.elements["bcountry"].name,"Country for billing details should not be empty");
        if((form.bcountry.value != 222)&&(form.bcountry.value != 36))
           check_numeric(form.elements["bzip"].name,"zip code for billing details should be numeric");
          
        //check_email(form.elements["email"].name,"Email is invalid");

      	

		

   }
        </script>
            
  <form name="ship_bill_frm" id="ship_bill_frm" method="post" action="" >
   <div class="registration">
                <h1><?php echo SHIPPINGADDRESS?></h1><br />
                
         <table width="687px">
          <tr> 
            <td colspan=2><input type='checkbox' name='ship_diff_flag' value=1 onclick='javascript:set_values("ship")' style="width:10px;height: 10px;"> 
              <font class="login_fld"><?php echo ISYOURSHIPPING?><!--<a href="javascript:void(0)" onclick='if(window.document.ship_bill_frm.ship_diff_flag.checked == false) { window.document.ship_bill_frm.ship_diff_flag.checked = true; set_values("ship"); }'><?php echo CLICKHERE ?></a> -->
              <input type="hidden" value="save" name="submit_action">
              <input type="hidden" value="update" name="getvalues">
              </font></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo FIRSTNAME; ?>:<em>*</em> </td>
            <td width="524px"><input type="text" name="fname" value="<?=$fname?>" ></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo LASTNAME; ?>:<em>*</em></td>
            <td><input type="text" name="lname" value="<?=$lname?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo ADDRESSLINE1; ?>:<em>*</em></td>
            <td><input type="text" name="address1" value="<?=$address1?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo ADDRESSLINE2; ?> </td>
            <td><input type="text" name="address2" value="<?=$address2?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo MOBILEPHONE; ?><em>*</em></td>
            <td><input type="text" name="mobile" value="<?=$mobile?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo LANDPHONE; ?> </td>
            <td><input type="text" name="landline" value="<?=$landline?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo CITY; ?>:<em>*</em></td>
            <td><input type="text" name="city" value="<?=$city?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo STATE;?>:<em>*</em></td>
            <td nowrap> <input type="text" name="state" value="<?=$state?>">
             
            </td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo ZIPCODE?>:<em>*</em> 
            </td>
            <td><input type="text" name="zip" value="<?=$zip?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo COUNTRY; ?>:<em>*</em></td>
            <td> 
              <?php
				   $ctry_styles = "class='select'";
				   $script_txt = "style='width:200px'";
				  $ctry_dd_name = "country";
				  
				  $select_option = $country;
				  
				  $ctry_default_selection = false;
				 				  
				  if(file_exists("../includes/country_dropdown.php")) 
				  	require_once("../includes/country_dropdown.php"); 
				else 
				  	require_once("includes/country_dropdown.php"); 
				  ?>
            </td>
          </tr>
          <tr> 
            <td align="left" height="30" class="light-bg"><?php echo EMAILADDRESS; ?><em>*</em></td>
            <td><input type="text" name="ship_email" value="<?php echo $ship_email ; ?>" ></td>
          </tr>
         
        </table><br />
                
                <h1><?php echo BILLINGADDRESS?></h1><br />
                
        <table width="687px">
            <tr> 
            <td colspan=2><input type='checkbox' name='bill_diff_flag' value=1 onclick='javascript:set_values("bill")' style="width:10px;height: 10px;"> 
              <font class="login_fld">Tick here if your billing address same as shipping address</font></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"> <?php echo FIRSTNAME; ?>:<em>*</em></td>
            <td width="524px"><input type="text" name="bfname" value="<?=$bfname?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo LASTNAME; ?>:<em>*</em></td>
            <td><input type="text" name="blname" value="<?=$blname?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo ADDRESSLINE1; ?>:<em>*</em></td>
            <td><input type="text" name="baddress1" value="<?=$baddress1?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo ADDRESSLINE2; ?> </td>
            <td><input type="text" name="baddress2" value="<?=$baddress2?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo MOBILEPHONE; ?><em>*</em> </td>
            <td><input type="text" name="bmobile" value="<?=$bmobile?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo LANDPHONE; ?> </td>
            <td><input type="text" name="blandline" value="<?=$blandline?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo CITY; ?>:<em>*</em></td>
            <td><input type="text" name="bcity" value="<?=$bcity?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo STATE;?>:<em>*</em></td>
            <td nowrap><input type="text" name="bstate" value="<?=$bstate?>">
              
            </td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo ZIPCODE?>:<em>*</em>
            </td>
            <td><input type="text" name="bzip" value="<?=$bzip?>"></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo COUNTRY; ?>:<em>*</em></td>
            <td> 
              <?php
				   $ctry_styles = "class='select'";
				   $script_txt = "style='width:200px'";
				  $ctry_dd_name = "bcountry";
				  
				  $select_option = $bcountry;
				  
				  $ctry_default_selection = false;
				  
				  if(file_exists("../includes/country_dropdown.php")) 
				  	include("../includes/country_dropdown.php"); 
				else 
				  	include("includes/country_dropdown.php"); 
				  ?>
            </td>
          </tr>
          
        </table>
        
         <?php if($_SESSION['ses_customer_id']==2) {?>
          <table width="687px"> 
         <tr> 
            <td colspan=2>
           
            <input type='checkbox' name='signup' value=1 onclick='javascript:showlogin("signup_data")' style="width:10px;height: 10px;"> 
             Sign up as a member to view your invoice/news and articles
             
               <input type="hidden" value="save" name="submit_action">
              <input type="hidden" value="update" name="getvalues"></font></td>
          </tr>
        </table>
        <div id="signup_data" style="display:none;">
        <br />
        
         <table width="687px"> 
          <tr> 
            <td colspan=2>Login Information
            </td>
            </tr>          
          <tr> 
            <td width="162px" class="light-bg"> <?php echo EMAILADDRESS; ?>:<em>*</em></td>
            <td width="524px"><input type="text" name="cust_email" id="cust_email" value=""></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo PASSWORD; ?>:<em>*</em></td>
            <td><input type="password" name="cust_password" id="cust_password" value=""></td>
          </tr>
          <tr> 
            <td width="162px" class="light-bg"><?php echo CONFIRMPASSWORD; ?>:<em>*</em></td>
            <td><input type="password" name="cust_cpassword" id="cust_cpassword" value=""></td>
          </tr>
          <tr>
          <td colspan="2">
           <div align="left" style="padding-bottom:25px;"> <input type="checkbox" style="width:10px;height: 10px;" name="cust_newsletter" value="1"   >PDPA  CONSENT<br>
 <ul style=" margin-top:10px;padding-left:20px;"> <li style="width:100%;">I would like to be kept informed of  marketing, advertising and promotions on products and services marketed by Way  OnNet Group Pte Ltd (WON) and WON&rsquo;s affiliates (collectively &ldquo;Way OnNet Group&rdquo;).<br><br>
  I hereby authorise, agree and consent that WON  and WON&rsquo;s affiliates<br />
  </li>
  </ul>
<ul style="padding-left:50px; margin-top:90px;">
  <li style="width:100%;">a) may send me marketing,  advertising and promotional information about products/services <br />&nbsp;&nbsp;&nbsp;&nbsp;that WON and  &nbsp;&nbsp;&nbsp;&nbsp;WON&rsquo;s affiliates may be selling, marketing, offering or promoting</li>
  <li style="width:100%;">b) contact me for the purposes of  providing me with information on any promotions, <br />&nbsp;&nbsp;&nbsp;&nbsp;products and services &nbsp;&nbsp;&nbsp;&nbsp;marketed  by WON and WON&rsquo;s affiliates, via the following <br />&nbsp;&nbsp;&nbsp;&nbsp;mode of communications:</li>

<ul style="padding-left:20px;">
  <li style="width:100%;"> - Electronic mail to my email  address.</li>
  <li style="width:100%;"> - SMS to my Singapore mobile  number(s) provided above.</li>
  <li style="width:100%;"> - Voice calls to my Singapore  telephone number(s) provided above.</li>
   
</ul>
 <li style="width:100%;"><br />c) Please log in to your profile if you wish to unsubscribe from receiving news & update.</li>
</ul>
</div>
 <div align="left" style="margin-top:160px;"><input type="checkbox" name="cust_terms_agreed"  style="width:10px;height: 10px;" value="1"  > <?php echo IHAVEREAD?> <a href="terms-of-service.php" target="_blank" style="text-decoration:underline;"><?php echo TERMSOFBREADCRUMB?></a><br /><br /></div>
 </td>
 </tr>
          </table>
          </div>
          <?php } ?>
        <br />
               <div align="center"><a style=" margin-left:10px;" class="gradient-btn" href="basket.php"><?php echo GOBACK ?></a>
                 <a href="javascript:void(0)" class="orage_gradient-btn" style="color:#FFFFFF; margin-left:500px;" onclick="if(check_form(window.document.ship_bill_frm)){$('#ship_bill_frm').submit();};"><?php echo CONTINUEBTN ?></a>
                 </div>
                 
       
</div>
  </form>

<script language="JavaScript">
function showlogin(id){
	var doc=window.document.ship_bill_frm;
	if(doc.signup.checked)
	{
		document.getElementById(id).style.display = 'block';
		
	}
	else{
		doc.cust_email.value="";
		doc.cust_password.value="";
		doc.cust_cpassword.value="";
		document.getElementById(id).style.display = 'none';
		
	}
}


function set_values(addr_typ)
{
	var doc=window.document.ship_bill_frm;

	switch (addr_typ)
	{
		
		case "bill":
			if(doc.bill_diff_flag.checked)
			{
				doc.bfname.value=doc.fname.value;
				doc.blname.value=doc.lname.value;
				doc.baddress1.value=doc.address1.value;
				doc.baddress2.value=doc.address2.value;
				doc.bmobile.value=doc.mobile.value;
				doc.blandline.value=doc.landline.value;
				doc.bcity.value=doc.city.value;
				doc.bstate.value=doc.state.value;
				doc.bzip.value=doc.zip.value;
				}
			else
			{
				
				doc.bfname.value="";
				doc.blname.value="";
				doc.baddress1.value="";
				doc.baddress2.value="";
				doc.bmobile.value="";
				doc.blandline.value="";
				doc.bcity.value="";
				doc.bstate.value="";
				doc.bzip.value="";
			
			}
			break;
			
		case "ship":
			if(doc.ship_diff_flag.checked)
			{
				doc.fname.value="";
				doc.lname.value="";
				doc.address1.value="";
				doc.address2.value="";				
				doc.mobile.value="";
				doc.landline.value="";
				doc.city.value="";
				doc.state.value="";
				doc.zip.value="";
				doc.ship_email.value="";
			}
			else
			{
				doc.fname.value="<?php echo $fname;?>";
				doc.lname.value="<?php echo $lname;?>";
				doc.address1.value="<?php echo $address1;?>";
				doc.address2.value="<?php echo $address2;?>";
				doc.mobile.value="<?php echo $mobile;?>";
				doc.landline.value="<?php echo $landline;?>";
				doc.city.value="<?php echo $city;?>";;
				doc.state.value="<?php echo $state;?>";
				doc.zip.value="<?php echo $zip;?>";
				doc.ship_email.value="<?php echo $ship_email;?>";
			}
			break;
	
	}//end switch
		
}

</script>
