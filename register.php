<?php 
$BreadCrumb = "Registration"; 
$spl_doc_title = "Member";
require_once("header.php"); 
$BreadCrumb = "Registration"; 
require_once("classes/customers.class.php");

$cust_obj = new customers();

$submit_action = $_REQUEST['submit_action'];

$display_what = "detail_frm";

switch ($submit_action)
{

	case "save":
		//$GLOBALS['site_config']['debug'] =1;
		$id = $_REQUEST['cust_id'];
		if($id <1) {
			
			$cust_autocode = userAutoGeneratedCode();			
			$cust_obj->cust_autocode['save_todb'] = "true";
			$cust_obj->cust_autocode['value'] = $cust_autocode;
			
			if($cust_obj->insert())
				{
				
				$redirect_url= $GLOBALS['site_config']['site_path']."index/Thank-You";
			}
			else{
				$redirect_url= $GLOBALS['site_config']['site_path']."account/create";
			}
		}
		else {
			if($cust_obj->update($id))
				$redirect_url = $GLOBALS['site_config']['site_path']."myaccount";
			else
				$redirect_url = $GLOBALS['site_config']['site_path']."account/create";
			
			}
		
		//exit;
		header("location:$redirect_url");
		exit();
		break;

	case "regd":
		$display_what = "thankyou";
		
		break;

}//end switch

?>
<?php 

$hid_action = "save";

if(isset($_SESSION['ses_customer_id']) && $_SESSION['ses_customer_id'] >0) {
	$edit_id = $_SESSION['ses_customer_id'];
	$edit = 1;

}

if($edit == 1 && $edit_id > 0)
{
	
	$res = $cust_obj->fetch_record($edit_id);
	$cust_obj = set_values($cust_obj, "db", $res[0]);

}


if(isset($_SESSION['ses_temp_cust_obj']) && is_array($_SESSION['ses_temp_cust_obj']))
{
	$cust_obj = set_values($cust_obj,"ses",$_SESSION['ses_temp_cust_obj']);
}

?>

    <?php  require_once("templates/breadcrumbs.php"); ?>
      <div class="pagetitle">
        <div>Customer Registration</div>
      </div>
      <div class="carttable w-clearfix">
      <?php	
		require_once(dirname(__FILE__) . '/includes/error_message.php');
		?>
        <div class="normal-con-with-sb">
          
          <div class="checkout-form">
            <div class="cheakout-form ">
              <form data-name="Email Form 3" id="email-form-3" name="email-form-3" method="post">
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="First-name">*First Name:</label><input class="n-field w-input" data-name="First name" id="First-name" maxlength="256" name="cust_firstname"   value="<?php echo stripslashes($cust_obj->cust_firstname['value']); ?>" required="required" type="text" ></div>
                  <div class="form-50b"><label for="Last-Name">*Last Name:</label><input class="n-field w-input" data-name="Last Name" id="Last-Name" maxlength="256" name="cust_lastname"   value="<?php echo stripslashes($cust_obj->cust_lastname['value']); ?>"required="required" type="text" ></div>
                </div>
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="First-name">Chinese Name:</label><input class="n-field w-input" data-name="First name" id="First-name" maxlength="256" name="cust_chinesename"   value="<?php echo stripslashes($cust_obj->cust_chinesename['value']); ?>"  type="text"></div>
                  <div class="form-50b"><label for="Last-Name">*Email:</label><input class="n-field w-input" data-name="Last Name" id="Last-Name" maxlength="256" name="cust_email"   value="<?php echo stripslashes($cust_obj->cust_email['value']); ?>"required="required" type="email"></div>
                </div>
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="First-name">*Password:</label><input class="n-field w-input" data-name="First name" id="First-name" maxlength="256" name="cust_password"   required="required" type="password"></div>
                  <div class="form-50b"><label for="Last-Name">*Confirm Password:</label><input class="n-field w-input" data-name="Last Name" id="Last-Name" maxlength="256" name="cust_cpassword"   value=""required="required" type="password"></div>
                </div>
                
                <div class="form-section">Particulars</div>
              <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="City">*Block:</label><input class="n-field w-input" data-name="City" id="cust_address1" maxlength="256" name="cust_address1" value="<?php echo stripslashes($cust_obj->cust_address1['value']); ?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="State">*Street Name:</label><input class="n-field w-input" data-name="State" id="cust_address2" maxlength="256" name="cust_address2" value="<?php echo stripslashes($cust_obj->cust_address2['value']); ?>" type="text"></div>
                </div>
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="City">*Unit No:</label><input class="n-field w-input" data-name="City" id="cust_unit" maxlength="256" name="cust_unit" value="<?php echo stripslashes($cust_obj->cust_unit['value']); ?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="State">Building Name:</label><input class="n-field w-input" data-name="State" id="cust_building" maxlength="256" name="cust_building" value="<?php echo stripslashes($cust_obj->cust_building['value']); ?>" type="text"></div>
                </div>
               <!-- <div class="formrow"><label for="Address">*Address:</label><textarea class="ntext w-input" data-name="Address" id="Address" maxlength="5000" name="cust_address1"  value="<?php echo stripslashes($cust_obj->cust_address1['value']); ?>" required="required"></textarea></div>-->
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="City">*City:</label><input class="n-field w-input" data-name="City" id="City" maxlength="256" name="cust_city" value="<?php echo stripslashes($cust_obj->cust_address1['value']); ?>" required="required" type="text"></div>
                  <div class="form-50b"><label for="State">State:</label><input class="n-field w-input" data-name="State" id="State" maxlength="256" name="cust_state" value="<?php echo stripslashes($cust_obj->cust_state['value']); ?>" type="text"></div>
                </div>
                 <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="City">*Country:</label><?php
				   $ctry_styles = "class='n-field w-input'";
				    $ctry_dd_name = "cust_country";
				  
				  if(isset($cust_obj->cust_country['value']) && $cust_obj->cust_country['value'] >0)
				  $select_option = $cust_obj->cust_country['value'];
				  else
				  $select_option = 189;
				  				  
				  $ctry_default_selection = false;
				  $fpath = ($GLOBALS['in_admin'] == 1)?"../":"";
				  
				 // $script_txt = "onChange=\"get_dynamic_dropdown('state_fld','" . $fpath . "ajax_content.php','required=state&frm_fld_name=cust_state1&selected_val=" . $cust_obj->cust_state['value'] . "&country_id=' + this.value);\"";
				
				  
				if(file_exists("../includes/country_dropdown.php")) 
				  	require_once("../includes/country_dropdown.php"); 
				else 
				  	require_once("includes/country_dropdown.php"); 
				
				//$script_str = "<script language='javascript'>\n var fpth = '" . $fpath . "';\n var ";
				
				?></div>
                  <div class="form-50b"><label for="State">*Zip Code:</label><input class="n-field w-input" data-name="State" id="State" maxlength="256" name="cust_zip" value="<?php echo stripslashes($cust_obj->cust_zip['value']); ?>" type="text" required="required"></div>
                </div>
                 
                <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="Phone-2">*Mobile:</label><input class="n-field w-input" data-name="Phone" id="Phone-2" maxlength="256" name="cust_phone" required="required" type="text" value="<?php echo stripslashes($cust_obj->cust_phone['value']); ?>"></div>
                  <div class="form-50b"><label for="Fax">Landline:</label><input class="n-field w-input" data-name="Fax" id="Fax" maxlength="256" name="cust_landline" type="text" value="<?php echo stripslashes($cust_obj->cust_landline['value']); ?>"></div>
                </div>
                 <div class="form-section">More About You</div>
                 <div class="formrow w-clearfix">
                  <div class="form-50a"><label for="Phone-2">Date of Birth (yyyy-mm-dd):</label><input class="n-field w-input" placeholder="yyyy-mm-dd" data-name="cust_dob" id="cust_dob1" maxlength="256" name="cust_dob" type="text" value="<?php echo stripslashes($cust_obj->cust_dob['value']); ?>"></div>
                  <div class="form-50b"><label for="Fax">Income Level:</label><select class="n-field w-input" name="cust_income" id="cust_income" >
            	<option selected="selected" value="">--Please select--</option>
                <option value="Below30K">Below $30,000</option>
                <option value="30K1to40K">$30,001 to $40,000</option>
                <option value="40K1to60K">$40,001 to $60,000</option>
                <option value="Above60K">Above $60,000</option>
            </select>
            <script>
			$('#cust_income').val('<?php echo stripslashes($cust_obj->cust_income['value']); ?>')
			</script></div>
                </div>
                 <div class="formrow"><label for="Address">Profession:</label> <select id="position" class="n-field w-input" name="cust_profession" >
            <option value="AdministrativeExecutive">Administrative Executive</option>
                <option value="CompanyDirector">Company Director</option>
                <option value="Engineer">Engineer</option>
                <option value="GeneralExecutive">General Executive</option>
                <option value="Home maker">Home maker</option>
                <option value="ITProfessional">IT Professional</option>
                <option value="Manager">Manager</option>
                <option value="Marketing/Sales Executive">Marketing/Sales Executive</option>
                <option value="Professional">Professional</option>
                <option value="Retired">Retired</option>
                <option value="SelfEmployed">Self-Employed</option>
                <option value="Supervisor">Supervisor</option>
                <option value="Teaching Professional">Teaching Professional</option>
                <option value="Technician">Technician</option>
                <option value="Others">Others</option>
                </select> <script>
			$('#position').val('<?php echo stripslashes($cust_obj->cust_profession['value']); ?>')
			</script></div>
                <div class="formrow"><input type="checkbox" name="cust_newsletter" value="1"  checked="checked" /> &nbsp;PDPA CONSENT
               <p> I would like to be kept informed of  marketing, advertising and promotions on products and services marketed by Way Fengshui Group and Way Fengshui affiliates .<br><br>
  I hereby authorise, agree and consent that Way Fengshui Group and Way Fengshui affiliates<br />
 </p>
<p>
  a) may send me marketing,  advertising and promotional information about products/services that Way Fengshui Group and Way Fengshui affiliates may be selling, marketing, offering or promoting</p>
 <p> b) contact me for the purposes of  providing me with information on any promotions, products and services marketed  by Way Fengshui Group and Way Fengshui affiliates, via the following mode of communications:

<ul style="padding-left:20px; list-style-type:none">
  <li > - Electronic mail to my email  address.</li>
  <li > - SMS to my Singapore mobile  number(s) provided above.</li>
  <li > - Voice calls to my Singapore  telephone number(s) provided above.</li>
   
</ul>
</p>
<p>c) Please log in to your profile if you wish to unsubscribe from receiving news & update.
</p>
                </div>
                <div class="formrow"><input type="checkbox" name="cust_terms_agreed"  value="1" checked="checked" required="required" >&nbsp;I have read and agreed to the  <a href="<?php echo $GLOBALS['site_config']['site_path']?>index/Terms-of-Services" target="_blank" style="text-decoration:underline;">Terms of Service</a>
                </div>
                 <input type="hidden" name="submit_action" value="save">
                <input type="hidden" name="cust_id" value="<?php echo $cust_obj->cust_id['value']; ?>">
                <input type="hidden" value="wayonnet" name="cust_register_from">
                <input type="hidden" value="1" name="cust_status">
                <input type="hidden" name="cust_create_datetime" value="<?php echo (strlen($cust_obj->cust_create_datetime['value']) > 0)?$cust_obj->cust_create_datetime['value']:date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="cust_modify_datetime" value="<?php echo date("Y-m-d H:i:s"); ?>">
                
                <div class="proceed-blk formrow"><input class="n-btn-orange w-button" data-wait="Please wait..." type="submit" value="Register"></div>
              </form>
             
            </div>
          </div>
        </div>
        <?php require_once(dirname(__FILE__) . '/templates/recently_viewed.php'); ?>
      </div>

 <br />
 <script>

$.noConflict();  //Not to conflict with other scripts
jQuery(document).ready(function($) {
$("#cust_dob" ).datepicker({
	changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    yearRange: "-100:-10",
	dateFormat:"yy-mm-dd"   
});
});
</script>
<?php 

require_once("footer.php"); 

?>