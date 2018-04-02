<?php 
$step =2;
$cust_page = 1;
$from_page = "ship_bill";
$spl_doc_title ="Shopping Cart";
require_once("header.php"); 
$BreadCrumb = "Shipping & Billing Info";  
require_once("classes/customers.class.php"); 
require_once("classes/temp_cart.class.php"); 
$cust_obj = new customers();
$temp_cart = new temp_cart();

if(count($_SESSION['ses_cart_items']) <= 0)
{
	header("location:basket.php");
	exit;
}
$submit_action = $_REQUEST['submit_action'];

switch ($submit_action)
{

	case "save":
		$_SESSION['ses_ship_bill_arr'] = array();
		
		foreach($_REQUEST as $key => $value)
		{
			$_SESSION['ses_ship_bill_arr'][$key] = $value;
		}
		$redirect_page = 1;
		$redirect_url = $GLOBALS['site_config']['site_path']."checkout/cart-overview";
		
		
		break;
		

}

if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}
if($_SESSION['ses_customer_id'] >1){
	$res = $cust_obj->fetch_record($_SESSION['ses_customer_id']);
	$cust_obj = set_values($cust_obj, "db", $res[0]);

	$fname = $cust_obj->cust_firstname['value'];
	$lname = $cust_obj->cust_lastname['value'];
	$address1 = $cust_obj->cust_address1['value'];
	$address2 = $cust_obj->cust_address2['value'];
	$building = $cust_obj->cust_building['value'];
	$unit = $cust_obj->cust_unit['value'];
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
	$bbuilding = $cust_obj->cust_building['value'];
	$bunit = $cust_obj->cust_unit['value'];
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

 <?php  require_once("templates/breadcrumbs.php"); ?>
      <div class="pagetitle">
        <div>Shipping & Billing Info</div>
      </div>
      <div class="carttable w-clearfix">
        <div class="cart-table-con">
          <?php  require_once("templates/cart_steps.php"); ?>
          <div class="checkout-form">
            <div class="cheakout-form ">
                <form name="ShipBillForm" id="ShipBillForm" method="post" action="" >
               
                 <div class="form-section">Billing Info</div>
                 
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="First-name">*First Name:</label><input class="n-field w-input" data-name="First Name" id="FirstName" maxlength="256" name="bfname" value="<?php echo $bfname?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="Last-Name">*Last Name:</label><input class="n-field w-input" data-name="Last Name" id="LastName" maxlength="256" name="blname" value="<?php echo $blname?>" required="required" type="text"></div>
                </div>
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="City">*Block:</label><input class="n-field w-input" data-name="baddress1" id="baddress1" maxlength="256" name="baddress1" value="<?php echo $baddress1?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="State">*Street Name:</label><input class="n-field w-input" data-name="baddress1" id="baddress2" maxlength="256" name="baddress2" value="<?php echo $baddress2?>" type="text"></div>
                </div>
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="City">Unit No:</label><input class="n-field w-input" data-name="City" id="bunit" maxlength="256" name="bunit" value="<?php echo $bunit?>"  type="text"></div>
                  <div class="form-50b"><label for="State">Building Name:</label><input class="n-field w-input" data-name="State" id="bbuilding" maxlength="256" name="bbuilding" value="<?php echo $bbuilding?>" type="text"></div>
                </div>
                
               <!-- <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="City">*City:</label><input class="n-field w-input" data-name="City" id="City" maxlength="256" name="bcity" value="<?php echo $bcity?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="State">State:</label><input class="n-field w-input" data-name="State" id="State" maxlength="256" name="bstate" value="<?php echo $bstate?>" type="text"></div>
                </div>-->
               
               
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="City">*City:</label><input class="n-field w-input" data-name="City" id="City" maxlength="256" name="bcity" value="<?php echo $bcity?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="State">State:</label><input class="n-field w-input" data-name="State" id="State" maxlength="256" name="bstate" value="<?php echo $bstate?>" type="text"></div>
                </div>
                 <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="Phone-2">*Phone:</label><input class="n-field w-input" data-name="Phone" id="Phone" maxlength="256" name="bmobile" value="<?php echo $bmobile?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="Fax">Landline:</label><input class="n-field w-input" data-name="Fax" id="Fax" maxlength="256" name="blandline" value="<?php echo $blandline?>" type="text"></div>
                </div>
                 <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="Phone-2">*Zip Code:</label><input class="n-field w-input" data-name="Phone" id="PostalCode" maxlength="256" name="bzip" value="<?php echo $bzip?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="Fax">Country:</label> <?php
				   $ctry_styles = "class='n-field w-input'";
				  // $script_txt = "style='width:200px'";
				  $ctry_dd_name = "bcountry";
				   $ctry_dd_id = "Country";
				  $select_option = $bcountry;
				  
				  $ctry_default_selection = false;
				 				  
				  if(file_exists("../includes/country_dropdown.php")) 
				  	require("../includes/country_dropdown.php"); 
				else 
				  	require("includes/country_dropdown.php"); 
				  ?></div>
                  
                </div>
                 <div class="formrow"><label for="Address">*Email:</label><input class="n-field w-input" data-name="Card Number" id="Email" maxlength="256" name="bemail" type="email" required="required" value="<?php echo $ship_email ?>"></div>
                <div class="form-section">Shipping Info</div>
                 <div class="formrow"><input type='checkbox' name='bill_diff_flag' value=1 onclick='javascript:set_values("bill")' class="n-field w-input" style="width:10px;height: 10px;">Tick here if your shipping address same as billing address</div>
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="First-name">*First Name:</label><input class="n-field w-input" data-name="First Name" id="SFirstName" maxlength="256" name="fname" value="<?php echo $fname?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="Last-Name">*Last Name:</label><input class="n-field w-input" data-name="Last Name" id="SLastName" maxlength="256" name="lname" value="<?php echo $lname?>" required="required" type="text"></div>
                </div>
                
               
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="City">*Block:</label><input class="n-field w-input" data-name="sblock" id="saddress1" maxlength="256" name="saddress1" value="<?php echo $address1?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="State">*Street Name:</label><input class="n-field w-input" data-name="saddress2" id="saddress2" maxlength="256" name="saddress2" value="<?php echo $address2?>" type="text"></div>
                </div>
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="City">Unit No:</label><input class="n-field w-input" data-name="City" id="sunit" maxlength="256" name="sunit" value="<?php echo $unit?>"  type="text"></div>
                  <div class="form-50b"><label for="State">Building Name:</label><input class="n-field w-input" data-name="sbuilding" id="sbuilding" maxlength="256" name="sbuilding" value="<?php echo $building?>" type="text"></div>
                </div>
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="City">*City:</label><input class="n-field w-input" data-name="City" id="SCity" maxlength="256" name="city" value="<?php echo $city?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="State">State:</label><input class="n-field w-input" data-name="State" id="SState" maxlength="256" name="state" value="<?php echo $state?>" type="text"></div>
                </div>
                 <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="Phone-2">*Phone:</label><input class="n-field w-input" data-name="Phone" id="SPhone" maxlength="256" name="mobile" value="<?php echo $mobile?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="Fax">Landline:</label><input class="n-field w-input" data-name="landline" id="slandline" maxlength="256" name="landline" value="<?php echo $landline?>" type="text"></div>
                </div>
                 <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="Phone-2">*Zip Code:</label><input class="n-field w-input" data-name="Phone" id="SPostalCode" maxlength="256" name="zip" value="<?php echo $zip?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="Fax">Country:</label> <?php
				   $ctry_styles = "class='n-field w-input'";
				  // $script_txt = "style='width:200px'";
				  $ctry_dd_name = "country";
				  $ctry_dd_id = "SCountry";
				  $select_option = $country;
				  
				  $ctry_default_selection = false;
				 				  
				  if(file_exists("../includes/country_dropdown.php")) 
				  	require("../includes/country_dropdown.php"); 
				else 
				  	require("includes/country_dropdown.php"); 
				  ?></div>
                  
                </div>
                 <div class="formrow"><label for="Address">*Email:</label><input class="n-field w-input" data-name="Card Number" id="SEmail" maxlength="256"  name="email" type="email" required="required" value= "<?php echo $ship_email ?>"></div>
                <div class="formrow"> <input type="hidden" value="save" name="submit_action">
              <div class="proceed-blk"><input type="hidden" value="update" name="getvalues">
              <a class="update-cart-btn w-button continue" href="<?php echo $GLOBALS['site_config']['site_path']?>cart" style="margin-bottom:5px;">GO BACK</a>
              <a class="update-cart-btn w-button continue" href="javascript:void()" onclick="$('#ShipBillForm').submit()" style="margin-bottom:5px;">CONTINUE</a>
              <!--<input class="update-cart-btn w-button" data-wait="Please wait..." type="submit" value="Continue">--></div></div>
              </form>
              
            </div>
          </div>
          
          
        </div>
        <?php require_once(dirname(__FILE__) . '/templates/recently_viewed.php'); ?>
      </div>     
 
<script language="JavaScript">
function set_values(addr_typ)
{
	
	var doc=window.document.ShipBillForm;
	
	$("#SFirstName").prop('disabled', false);
	$("#SLastName").prop('disabled', false);
	$("#SEmail").prop('disabled', false);
	$("#bill_email").prop('disabled', false);
	$("#SPhone").prop('disabled', false);
	$("#SFax").prop('disabled', false);
	$("#SAddress").prop('disabled', false);
	$("#SCity").prop('disabled', false);
	$("#SState").prop('disabled', false);
	$("#SCountry").prop('disabled', false);
	$("#SPostalCode").prop('disabled', false);

	switch (addr_typ)
	{
	
		case "bill":
		
			if(doc.bill_diff_flag.checked)
			{				
				
				$("#SFirstName").val($("#FirstName").val());
				$("#SLastName").val($("#LastName").val());
				$("#SEmail").val($("#Email").val());
				$("#bill_email").val($("#ship_email").val());
				$("#SPhone").val($("#Phone").val());
				$("#slandline").val($("#Fax").val());
				$("#saddress1").val($("#baddress1").val());
				$("#saddress2").val($("#baddress2").val());
				$("#sunit").val($("#bunit").val());
				$("#sbuilding").val($("#bbuilding").val());
				$("#SCity").val($("#City").val());
				$("#SState").val($("#State").val());
				$("#SCountry").val($("#Country").val());
				$("#SPostalCode").val($("#PostalCode").val());
				
				
			}
			else
			{
				
				$("#SFirstName").val("");
				$("#SLastName").val("");
				$("#SEmail").val("");
				$("#bill_email").val("");
				$("#SPhone").val("");
				$("#saddress1").val("");
				$("#saddress2").val("");
				$("#sunit").val("");
				$("#sbuilding").val("");
				$("#SCity").val("");
				$("#SState").val("");
				$("#SCountry").val("");
				$("#SPostalCode").val("");
				$("#slandline").val("");
				
			}
			break;
	}}
	</script>
      <script language="JavaScript">
	function colection_on_door(addr_typ)
	{
		$("#SFirstName").prop('disabled', true);
		$("#SLastName").prop('disabled', true);
		$("#SEmail").prop('disabled', true);
		$("#bill_email").prop('disabled', true);
		$("#SPhone").prop('disabled', true);
		$("#SFax").prop('disabled', true);
		$("#SAddress").prop('disabled', true);
		$("#SCity").prop('disabled', true);
		$("#SState").prop('disabled', true);
		$("#SCountry").prop('disabled', true);
		$("#SPostalCode").prop('disabled', true);
	}
	</script>
<?php 

require_once("footer.php"); 

?>