<script language="javascript">
    function check_validate() {
        error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  
		
        check_empty(form.elements["user_fname"].name,"First name should not be empty");
        check_empty(form.elements["user_lname"].name,"Last name should not be empty");
        check_email(form.elements["email_address"].name,"Email address should not be empty");
        check_empty(form.elements["phone"].name,"Phone should not be empty");
		/*
		var st_msg = new Array();
		st_msg[0] = "Select the start date that you prefer for consultation";
		st_msg[1] = "Select a year for the start date";
		st_msg[2] = "Select a month for the start date";
		st_msg[3] = "Select a date for the start date";
		st_msg[4] = "Select a valid start date that you prefer";
		check_date(form.prefered_start_dt_dt,form.prefered_start_dt_mt,form.prefered_start_dt_yr,1,st_msg)
		var end_msg = new Array();
		end_msg[0] = "Select the end date that you prefer for consultation";
		end_msg[1] = "Select a year for the end date";
		end_msg[2] = "Select a month for the end date";
		end_msg[3] = "Select a date for the end date";
		end_msg[4] = "Select a valid end date that you prefer";
		check_date(form.prefered_end_dt_dt,form.prefered_end_dt_mt,form.prefered_end_dt_yr,1,end_msg)
		*/
		check_expire(form.elements["prefered_start_dt_mt"].name,form.elements["prefered_start_dt_dt"].name,form.elements["prefered_start_dt_yr"].name,"Select a future date for consultation");
		
		var bet_st_msg = new Array();
		bet_st_msg[0] = "Select start and end dates that you prefer to have consultation with us";
		bet_st_msg[1] = "End date should be greater than or equal to the begining date";
		bet_st_msg[2] = "Select the start date that you prefer for consultation";
		bet_st_msg[3] = "Select a year for the start date";
		bet_st_msg[4] = "Select a month for the start date";
		bet_st_msg[5] = "Select a date for the start date";
		bet_st_msg[6] = "Select a valid start date that you prefer";
		bet_st_msg[7] = "Select the end date that you prefer for consultation";
		bet_st_msg[8] = "Select a year for the end date";
		bet_st_msg[9] = "Select a month for the end date";
		bet_st_msg[10] = "Select a date for the end date";
		bet_st_msg[11] = "Select a valid end date that you prefer";
		
		compare_dates(form.prefered_start_dt_yr,form.prefered_start_dt_mt,form.prefered_start_dt_dt,form.prefered_end_dt_yr,form.prefered_end_dt_mt,form.prefered_end_dt_dt,1,bet_st_msg);
        
		check_empty(form.elements["consultation_reason"].name,"Reason for the consultation should not be empty");

    }
	
	
</script>
 
<?php 

$hid_action = "save";


if(isset($_SESSION['ses_temp_consult_obj']) && is_array($_SESSION['ses_temp_consult_obj']))
{
	$consult_obj = set_values($consult_obj,"ses",$_SESSION['ses_temp_consult_obj']);
}
?>

<table width="95%" border="0" cellspacing="0" cellpadding="2" align="center">
<form name="<?php echo $consult_obj->frm_name; ?>" method="post" action="" onSubmit="return check_form(window.document.<?php echo $consult_obj->frm_name; ?>);">
<?php

//echo $consult_obj->frame_validation_script();

?>
    <tr> 
      <td>
<p><strong>Please fill in the following form to fix up an appointment for consultation with us :</strong></p>
        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
          <tr valign="top" class="maincontentheading"> 
            <td height="29" colspan="2" align='center' class='whitefont_header'> 
              Consultation Appointment Request</td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">First Name</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="user_fname" value="<?php echo stripslashes($consult_obj->user_fname['value']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Last Name</span><span class="starcolor">*</span></td>
            <td> <input type="text" name="user_lname" value="<?php echo stripslashes($consult_obj->user_lname['value']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Email</span><span class="starcolor">*</span></td>
            <td> <input type="text" name="email_address" value="<?php echo stripslashes($consult_obj->email_address['value']); ?>"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Phone</span><span class="starcolor">*</span></td>
            <td> <input type="text" name="phone" value="<?php echo stripslashes($consult_obj->phone['value']); ?>"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Preferred Dates for consultation</span><span class="starcolor">*</span></td>
            <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td>From</td>
                  <td> 
                    <?php
				  
				  $mth_name = "prefered_start_dt_mt";
				  $mth_val = $consult_obj->prefered_start_dt['value']['mt'];
				  
				  $dt_name = "prefered_start_dt_dt";
				  $dt_val = $consult_obj->prefered_start_dt['value']['dt'];

				  $yr_name = "prefered_start_dt_yr";
				  $yr_val = $consult_obj->prefered_start_dt['value']['yr'];

				  $popup_name = "selcal";
				  $popup_frmname = $consult_obj->frm_name;
				  
				  if(file_exists("../includes/"))
				  	
					require_once("../includes/date_field.php");
					
				  else
				  
				    require_once("includes/date_field.php");

				  ?>
                  </td>
                </tr>
                <tr> 
                  <td>Till</td>
                  <td>
                    <?php
				  
				  $mth_name = "prefered_end_dt_mt";
				  $mth_val = $consult_obj->prefered_end_dt['value']['mt'];
				  
				  $dt_name = "prefered_end_dt_dt";
				  $dt_val = $consult_obj->prefered_end_dt['value']['dt'];

				  $yr_name = "prefered_end_dt_yr";
				  $yr_val = $consult_obj->prefered_end_dt['value']['yr'];
				  
				  $popup_name = "selcal1";
				  $popup_frmname = $consult_obj->frm_name;
				  
				  if(file_exists("../includes/"))
				  	
					include("../includes/date_field.php");
					
				  else
				  
				    include("includes/date_field.php");
				  ?>
                  </td>
                </tr>
              </table></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td>Reason for consultation<span class="starcolor">*</span></td>
            <td> <textarea name="consultation_reason" cols="40" rows="5"><?php echo stripslashes($consult_obj->consultation_reason['value']); ?></textarea></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"> <div align="center"> 
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
                <input type="hidden" name="consultation_id" value="<?php echo $consult_obj->consultation_id['value']; ?>">
                <input type="hidden" value="0" name="consultation_status">
                <input type="hidden" name="date_entered" value="<?php echo (strlen($consult_obj->date_entered['value']) > 0)?$consult_obj->date_entered['value']:date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="date_modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
              </div></td>
          </tr>
          <tr valign="top">
            <td colspan="2" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><img align="absmiddle" src="templates/godess/images/back.jpg" onClick="window.location.href='basket.php';" ></td>
                  <td align="right">
<input align="absmiddle" style="border:0px;" type="image" src="templates/godess/images/next.jpg" name="Submit2">
                  </td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
        </table>	  
	  </td>
    </tr> 
</form>	
  </table>
