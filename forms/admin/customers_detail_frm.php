<script language="javascript">
    function check_validate() {
        error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  
		
        check_empty(form.elements["cust_firstname"].name,"First name should not be empty");
        check_empty(form.elements["cust_lastname"].name,"Last name should not be empty");
			 
		check_empty(form.elements["cust_password"].name,"New Password should not be empty");
		Check_Lengthlow(form.elements["cust_password"].name,"New Password should have minimum 6 characters and maximum 12 character",6);
		Check_Lengthhigh(form.elements["cust_password"].name,"New Password should have minimum 6 characters and maximum 12 character",12);
		check_match(form.elements["cust_password"].name,form.elements["cust_cpassword"].name,"Password should be match");		
						
        check_empty(form.elements["cust_address1"].name,"Address1 should not be empty");
        check_empty(form.elements["cust_city"].name,"City should not be empty");
        check_empty(form.elements["cust_country"].name,"Country should not be empty");
       // check_empty(form.elements["cust_state"].name,"State should not be empty");
		check_empty(form.elements["cust_zip"].name,"Zipcode should not be empty");
		check_empty(form.elements["cust_phone"].name,"Mobile should not be empty");
    }
</script>
 
<?php 

$hid_action = "save";

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
<div class="whitebox mtop15">
<table width="75%" border="0" cellspacing="0" cellpadding="2" align="center">
<form name="<?php echo $cust_obj->frm_name; ?>" method="post" action="" onSubmit="return check_form(window.document.<?php echo $cust_obj->frm_name; ?>);">
<?php

//echo $cust_obj->frame_validation_script();

?>
    <tr> 
      <td>

<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">

          <tr>
          <td colspan="2">
          <table width="100%">
          <tr>
             <td height="30" width="30%" class="postaddcontent">First Name:<span class="starcolor">*</span></td>
             <td width="70%"><input type="text"  class="mediumtxtbox"  name="cust_firstname"   value="<?php echo stripslashes($cust_obj->cust_firstname['value']); ?>">   </td>
           </tr>
           <tr>
            <td height="30" width="30%" class="postaddcontent">Last Name:<span class="starcolor">*</span></td>
             <td ><input type="text" class="mediumtxtbox" name="cust_lastname"  value="<?php echo stripslashes($cust_obj->cust_lastname['value']); ?>">   </td>
          </tr> 
          <tr>
            <td height="30" width="30%" class="postaddcontent">Chinese Name:</td>
             <td ><input type="text" class="mediumtxtbox" name="cust_chinesename"  value="<?php echo stripslashes($cust_obj->cust_chinesename['value']); ?>"></td>
          </tr>   
           <tr valign="top" > 
            <td height="30" width="30%" class="postaddcontent">Email<span class="starcolor">*</span></td>
            <td><input type="text" class="mediumtxtbox" name="cust_email"  value="<?php echo stripslashes($cust_obj->cust_email['value']); ?>"></td>
          </tr>
          <tr valign="top" > 
            <td height="30" width="30%" class="postaddcontent">Password<span class="starcolor">*</span></td>
            <td><input type="text" name="cust_password" class="mediumtxtbox" value="<?php echo stripslashes($cust_obj->cust_password['value']); ?>"></td>
          </tr>
          <tr valign="top" > 
            <td height="30" width="30%" class="postaddcontent">Confirm Password<span class="starcolor">*</span></td>
            <td><input type="text" name="cust_cpassword"  class="mediumtxtbox" value="<?php echo stripslashes($cust_obj->cust_password['value']); ?>"></td>
          </tr>  
          <tr>
            <td height="30" width="30%" class="postaddcontent">Recommented By:</td>
             <td ><input type="text" class="mediumtxtbox" name="cust_recom_by"  value="<?php echo stripslashes($cust_obj->cust_recom_by['value']); ?>"></td>
          </tr>        
          </table><br />
                
                <h1>Particulars</h1><br />
                <table width="100%">   
         
          <tr valign="top" > 
            <td height="30" width="30%" class="postaddcontent">Address Line 1<span class="starcolor">*</span></td>
            <td><input type="text" class="mediumtxtbox" name="cust_address1"  value="<?php echo stripslashes($cust_obj->cust_address1['value']); ?>">(<?php echo ADDRESS1DESC?>)</td>
          </tr>
          <tr valign="top" > 
            <td height="30" width="30%" class="postaddcontent">Address Line 2</td>
            <td><input type="text" class="mediumtxtbox" name="cust_address2"  value="<?php echo stripslashes($cust_obj->cust_address2['value']); ?>"></td>
          </tr>
          <tr valign="top" > 
            <td height="30" width="30%" class="postaddcontent">City<span class="starcolor">*</span></td>
            <td><input type="text" class="mediumtxtbox" name="cust_city"  value="<?php echo stripslashes($cust_obj->cust_city['value']); ?>"></td>
          </tr>
           <tr valign="top" > 
            <td height="30" width="30%" class="postaddcontent">State</td>
			<td><input type="text" class="mediumtxtbox" name="cust_state" value="<?php echo stripslashes($cust_obj->cust_state['value']); ?>" /></td>
          </tr>
          <tr valign="top" > 
           <td height="30" width="30%" class="postaddcontent">Country<span class="starcolor">*</span></td>
            <td> 
              <?php
				   $ctry_styles = "class='select'";
				   $script_txt = "style='width:200px'";
				  $ctry_dd_name = "cust_country";
				  
				  $select_option = $cust_obj->cust_country['value'];
				  				  
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
           <td height="30" width="30%" class="postaddcontent">Zip Code<span class="starcolor">*</span></td>
            <td><input type="text" class="mediumtxtbox" name="cust_zip"  value="<?php echo stripslashes($cust_obj->cust_zip['value']); ?>"></td>
          </tr>
          <tr valign="top" > 
            <td height="30" width="30%" class="postaddcontent">Mobile<span class="starcolor">*</span></td>
            <td><input type="text" class="mediumtxtbox" name="cust_phone"  value="<?php echo stripslashes($cust_obj->cust_phone['value']); ?>"></td>
          </tr>
           <tr valign="top" > 
            <td height="30" width="30%" class="postaddcontent">Landline</td>
            <td><input type="text" class="mediumtxtbox" name="cust_landline"  value="<?php echo stripslashes($cust_obj->cust_landline['value']); ?>"></td>
          </tr>
         <tr valign="top" > 
            <td height="30" width="30%" class="postaddcontent">Office</td>
            <td><input type="text" class="mediumtxtbox" name="cust_office"  value="<?php echo stripslashes($cust_obj->cust_office['value']); ?>"></td>
          </tr>          
         </table><br />
                
                <h1>More Details</h1><br />
                <table width="100%">
         <!-- <tr  valign="top" > 
            <td width="162px" class="whitefont"><?php echo ICORPASSPORT; ?><span class="starcolor">*</span></td>
            <td width="523px"><input type="text" class="mediumtxtbox" name="cust_ic"  value="<?php echo stripslashes($cust_obj->cust_ic['value']); ?>"></td>
          </tr> -->
          <tr  valign="top" > 
            <td height="30" width="30%" class="postaddcontent">Date of Birth<span class="starcolor">*</span></td>
            <td width="523px"><select name="cust_dob_day" class="select">
            <option value=""> Day </option>
            <?php for($day =1;$day<=31;$day++){?>
            <option value="<?php echo $day?>" <?php if($cust_obj->cust_dob_day['value']==$day){?> selected="selected"<?php }?>> <?php echo $day?> </option>
            <?php } ?>
            </select>&nbsp;
            <select name="cust_dob_month" class="select">
            <option value=""> Month </option>
            <?php
            foreach ($CONFIG_MONTH as $num => $var) {?>
            <option value="<?php echo $num?>" <?php if($cust_obj->cust_dob_month['value']==$num){?> selected="selected"<?php }?>> <?php echo $var?> </option>
            <?php }?>
            </select>&nbsp;
            <select name="cust_dob_year" class="select">
            <option value=""> Year </option>
            <?php 
			$lastyear=  date("Y")-100;
			for($year = date("Y");$year>$lastyear;$year--){?>
            <option value="<?php echo $year?>" <?php if($cust_obj->cust_dob_year['value']==$year){?> selected="selected"<?php }?>> <?php echo $year?> </option>
            <?php } ?>
            </select> (<?php echo DOBDESC?>)</td>
          </tr>
          <!-- <tr  valign="top" > 
            <td width="162px" class="whitefont">Time of Birth<span class="starcolor">*</span></td>
            <td width="523px"><input type="text" class="mediumtxtbox" name="cust_username"  value="<?php echo stripslashes($cust_obj->cust_username['value']); ?>"></td>
          </tr>
          <tr  valign="top" > 
            <td width="162px" class="whitefont">Place of Birth<span class="starcolor">*</span></td>
            <td width="523px"><input type="text" class="mediumtxtbox" name="cust_username"  value="<?php echo stripslashes($cust_obj->cust_username['value']); ?>"></td>
          </tr>-->
           <tr  valign="top" > 
            <td height="30" width="30%" class="postaddcontent">Prefession</td>
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
            <td height="30" width="30%" class="postaddcontent">Income Level</td>
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
                
                <input type="checkbox" name="cust_newsletter" value="1"  <?php if($cust_obj->cust_newsletter['value']){?>checked="checked" <?php }?> > I wish to receive newsletter and promotion events from Way OnNet<br /><br />
          </td>
          <tr> 
            <td align="center" colspan="2"> <input type="submit" name="Submit" value="Submit"> 
            </td>
          </tr>
          <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
        </table>	  
	  </td>
    </tr> 
</form>	
  </table>
  
  </div>
