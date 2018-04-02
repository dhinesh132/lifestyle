<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script language="javascript">
    function check_validate() {
        error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  
		
        check_empty(form.elements["cust_firstname"].name,"First name should not be empty");
        check_empty(form.elements["cust_lastname"].name,"Last name should not be empty");
		check_email(form.elements["cust_email"].name,"Email should not be empty");		 
        check_empty(form.elements["cust_password"].name,"Password should not be empty");
		Check_Lengthlow(form.elements["cust_password"].name,"Password should have minimum 6 characters and maximum 12 character",6);
		Check_Lengthhigh(form.elements["cust_password"].name,"Password should have minimum 6 characters and maximum 12 character",12);
        check_match(form.elements["cust_password"].name,form.elements["cust_cpassword"].name,"Password should be match");
		  
        check_empty(form.elements["cust_address1"].name,"Address1 should not be empty");
        check_empty(form.elements["cust_city"].name,"City should not be empty");
        check_empty(form.elements["cust_country"].name,"Country should not be empty");
       // check_empty(form.elements["cust_state"].name,"State should not be empty");
		check_empty(form.elements["cust_zip"].name,"Zipcode should not be empty");
		check_empty(form.elements["cust_phone"].name,"Mobile should not be empty");
		
        if((form.cust_newsletter.checked == false )){
			error_message += "* Please accept PDPA!\n";
			error = true;
        }
		
		if((form.cust_terms_agreed.checked == false )){
			error_message += "* Please accept Terms of Service!\n";
			error = true;
        }
		
    }
	
	
</script>
 
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
 <div class="right">
        	<div class="title-header">
            	<img src="images/t-member.jpg" alt="" />
            </div>
            	<div class="registration">
                <h1><?php echo MEMBERREGISTRATION?></h1><br />
                <?php require_once("includes/error_message.php");?>
                          <form name="<?php echo $cust_obj->frm_name; ?>" id="register" method="post" action="" >
       
	<table width="685px">
          <tr>
             <td width="162px" class="light-bg"><?php echo FIRSTNAME; ?>:<em>*</em></td>
             <td width="523px"><input type="text"  name="cust_firstname"   value="<?php echo stripslashes($cust_obj->cust_firstname['value']); ?>">   </td>
           </tr>
           <tr>
             <td  class="light-bg"><?php echo LASTNAME; ?>:<em>*</em></td>
             <td ><input type="text" name="cust_lastname"  value="<?php echo stripslashes($cust_obj->cust_lastname['value']); ?>">   </td>
          </tr> 
          <tr>
             <td  class="light-bg"><?php echo CHINESENAME; ?>:</td>
             <td ><input type="text" name="cust_chinesename"  value="<?php echo stripslashes($cust_obj->cust_chinesename['value']); ?>"></td>
          </tr>   
           <tr valign="top" > 
            <td class="light-bg"><?php echo EMAILADDRESS; ?><em>*</em></td>
            <td><input type="text" name="cust_email"  value="<?php echo stripslashes($cust_obj->cust_email['value']); ?>"><br /><em>This will be your User Id, Verfication will be send to this email.</em></td>
          </tr>
          <tr valign="top" > 
            <td class="light-bg"><?php echo PASSWORD; ?><em>*</em></td>
            <td><input type="password" name="cust_password"  value="<?php echo stripslashes($cust_obj->cust_password['value']); ?>"></td>
          </tr>
          <tr valign="top" > 
            <td class="light-bg"><?php echo CONFIRMPASSWORD; ?><em>*</em></td>
            <td><input type="password" name="cust_cpassword"  value="<?php echo stripslashes($cust_obj->cust_password['value']); ?>"></td>
          </tr>  
          <tr>
             <td  class="light-bg"><?php echo RECOMMENDEDBY; ?>:</td>
             <td ><input type="text" name="cust_recom_by"  value="<?php echo stripslashes($cust_obj->cust_recom_by['value']); ?>"></td>
          </tr>        
          </table><br />
                
                <h1><?php echo PARTICULARS; ?></h1><br />
                <table width="685px">   
         
          <tr valign="top" > 
            <td width="162px" class="light-bg"><?php echo ADDRESSLINE1; ?><em>*</em></td>
            <td><input type="text" name="cust_address1"  value="<?php echo stripslashes($cust_obj->cust_address1['value']); ?>">(<?php echo ADDRESS1DESC?>)</td>
          </tr>
          <tr valign="top" > 
            <td class="light-bg"><?php echo ADDRESSLINE2; ?></td>
            <td><input type="text" name="cust_address2"  value="<?php echo stripslashes($cust_obj->cust_address2['value']); ?>"></td>
          </tr>
          <tr valign="top" > 
            <td class="light-bg"><?php echo CITY; ?><em>*</em></td>
            <td><input type="text" name="cust_city"  value="<?php echo stripslashes($cust_obj->cust_city['value']); ?>"></td>
          </tr>
           <tr valign="top" > 
            <td class="light-bg"><?php echo STATE; ?></td>
			<td><input type="text" name="cust_state" value="<?php echo stripslashes($cust_obj->cust_state['value']); ?>" /></td>
          </tr>
          <tr valign="top" > 
            <td  class="light-bg"><?php echo COUNTRY; ?><em>*</em></td>
            <td> 
              <?php
				   $ctry_styles = "class='select'";
				   $script_txt = "style='width:200px'";
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
				
				?>            </td>
          </tr>
		  
         
          <tr valign="top" > 
            <td  class="light-bg"><?php echo ZIPCODE; ?><em>*</em></td>
            <td><input type="text" name="cust_zip"  value="<?php echo stripslashes($cust_obj->cust_zip['value']); ?>"></td>
          </tr>
          <tr valign="top" > 
            <td class="light-bg"><?php echo MOBILEPHONE; ?><em>*</em></td>
            <td><input type="text" name="cust_phone"  value="<?php echo stripslashes($cust_obj->cust_phone['value']); ?>"></td>
          </tr>
           <tr valign="top" > 
            <td class="light-bg"><?php echo LANDPHONE; ?></td>
            <td><input type="text" name="cust_landline"  value="<?php echo stripslashes($cust_obj->cust_landline['value']); ?>"></td>
          </tr>
         <tr valign="top" > 
            <td class="light-bg"><?php echo OFFICEPHONE; ?></td>
            <td><input type="text" name="cust_office"  value="<?php echo stripslashes($cust_obj->cust_office['value']); ?>"></td>
          </tr>          
         </table><br />
                
                <h1><?php echo MOREABOUTYOU; ?></h1><br />
                <table width="685px">
         <!-- <tr  valign="top" > 
            <td width="162px" class="light-bg"><?php echo ICORPASSPORT; ?><em>*</em></td>
            <td width="523px"><input type="text" name="cust_ic"  value="<?php echo stripslashes($cust_obj->cust_ic['value']); ?>"></td>
          </tr> -->
          <tr  valign="top" > 
            <td width="162px" class="light-bg"><?php echo DATEOFBIRTH; ?><em>*</em></td>
            <td width="523px"><select name="cust_dob_day" class="select">
            <option value=""> Day </option>
            <?php for($day =1;$day<=31;$day++){?>
            <option value="<?php echo $day?>"> <?php echo $day?> </option>
            <?php } ?>
            </select>&nbsp;
            <select name="cust_dob_month" class="select">
            <option value=""> Month </option>
            <?php
            foreach ($CONFIG_MONTH as $num => $var) {?>
            <option value="<?php echo $num?>"> <?php echo $var?> </option>
            <?php }?>
            </select>&nbsp;
            <select name="cust_dob_year" class="select">
            <option value=""> Year </option>
            <?php 
			$lastyear=  date("Y")-100;
			for($year = date("Y");$year>$lastyear;$year--){?>
            <option value="<?php echo $year?>"> <?php echo $year?> </option>
            <?php } ?>
            </select> (<?php echo DOBDESC?>)</td>
          </tr>
          <!-- <tr  valign="top" > 
            <td width="162px" class="light-bg">Time of Birth<em>*</em></td>
            <td width="523px"><input type="text" name="cust_username"  value="<?php echo stripslashes($cust_obj->cust_username['value']); ?>"></td>
          </tr>
          <tr  valign="top" > 
            <td width="162px" class="light-bg">Place of Birth<em>*</em></td>
            <td width="523px"><input type="text" name="cust_username"  value="<?php echo stripslashes($cust_obj->cust_username['value']); ?>"></td>
          </tr>-->
           <tr  valign="top" > 
            <td width="162px" class="light-bg"><?php echo PROFESSION; ?></td>
            <td width="523px">
            <select id="position" name="cust_profession" class="select" style="width:200px">
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
                </select>
                <script>
				 document.getElementById("position").value = '<?php echo stripslashes($cust_obj->cust_profession['value']); ?>';
			   </script>
            </td>
          </tr>
           <tr  valign="top" > 
            <td width="162px" class="light-bg"><?php echo INCOMELEVEL; ?></td>
            <td width="523px"> 
            <select name="cust_income" id="annual_salary" class="select" style="width:200px">
            	<option selected="selected" value="">--Please select--</option>
                <option value="Below30K">Below $30,000</option>
                <option value="30K1to40K">$30,001 to $40,000</option>
                <option value="40K1to60K">$40,001 to $60,000</option>
                <option value="Above60K">Above $60,000</option>
            </select>
            <script>
				 document.getElementById("annual_salary").value = '<?php echo stripslashes($cust_obj->cust_income['value']); ?>';
			</script>
           </td>
          </tr>
          
          <tr valign="top" > 
            <td colspan="2"><div align="center"> 
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
                <input type="hidden" name="cust_id" value="<?php echo $cust_obj->cust_id['value']; ?>">
                <input type="hidden" value="wayonnet" name="cust_register_from">
                <input type="hidden" value="1" name="cust_status">
                <input type="hidden" name="cust_create_datetime" value="<?php echo (strlen($cust_obj->cust_create_datetime['value']) > 0)?$cust_obj->cust_create_datetime['value']:date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="cust_modify_datetime" value="<?php echo date("Y-m-d H:i:s"); ?>">
              </div></td>
                </tr>
       
          </table>
          <br />
                
<div align="left" style="padding-bottom:25px;"> <input type="checkbox" name="cust_newsletter" value="1"   >PDPA  CONSENT<br>
 <ul style=" margin-top:10px;padding-left:20px;"> <li style="width:680px;">I would like to be kept informed of  marketing, advertising and promotions on products and services marketed by Way  OnNet Group Pte Ltd (WON) and WON&rsquo;s affiliates (collectively &ldquo;Way OnNet Group&rdquo;).<br><br>
  I hereby authorise, agree and consent that WON  and WON&rsquo;s affiliates<br />
  </li>
  </ul>
<ul style="padding-left:50px; margin-top:90px;">
  <li style="width:680px;">a) may send me marketing,  advertising and promotional information about products/services that WON and  &nbsp;&nbsp;&nbsp;&nbsp;WON&rsquo;s affiliates may be selling, marketing, offering or promoting</li>
  <li style="width:680px;">b) contact me for the purposes of  providing me with information on any promotions, products and services &nbsp;&nbsp;&nbsp;&nbsp;marketed  by WON and WON&rsquo;s affiliates, via the following mode of communications:</li>

<ul style="padding-left:20px;">
  <li style="width:680px;"> - Electronic mail to my email  address.</li>
  <li style="width:680px;"> - SMS to my Singapore mobile  number(s) provided above.</li>
  <li style="width:980px;"> - Voice calls to my Singapore  telephone number(s) provided above.</li>
   
</ul>
 <li style="width:680px;"><br />c) Please log in to your profile if you wish to unsubscribe from receiving news & update.</li>
</ul>
</div>
 <div align="left" style="margin-top:170px;"><input type="checkbox" name="cust_terms_agreed"  value="1"  > <?php echo IHAVEREAD; ?> <a href="terms-of-service.php" target="_blank" style="text-decoration:underline;"><?php echo TERMSOFUSEBREADCRUMB?></a><br /><br /></div>
                
                <a  href="#"class="orage_gradient-btn" onclick="if(check_form(window.document.customer_frm)){$('#register').submit();};" style="margin-left:280px; color:#FFFFFF"><?php echo SUBMIT; ?></a>
              </form>
 </div>