
<script language="javascript">
    function check_validate_rew() {
        error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  
		
		  check_empty(form.elements["heading"].name,"Heading should not be empty");
		  check_empty(form.elements["review_text"].name,"Review Text should not be empty");
		  check_empty(form.elements["rating"].name,"Ovarall Rating should not be empty");
		  
		  if(window.document.review_frm.review_text.value !="")
		  {
		  Check_Lengthlow(form.elements["review_text"].name,"Review Text should have minimum 100 characters and maximum 2000 character",100);
		  }
		 
		  
		  if(window.document.review_frm.rating.value !="")
		  {
		 check_numeric(form.elements["rating"].name,"Overall Rating must be numeric value");
		  }
		   if(window.document.review_frm.rating.value > 5)
		  {
			check_limit(form.elements["rating"].name,"Rating must be between 0 and 5");
		  }
		  
		 }
		
	function chk_msglength(lenval)
		{
		var lenval= lenval;
		if(window.document.review_frm.review_text.value != "")
		{
		message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";

			if(window.document.review_frm.review_text.value.length >=lenval)
			{
			
				message += "* Review should not exceed 2000 characters\n";
				orig_txt =window.document.review_frm.review_text.value;
				display_txt = window.document.review_frm.review_text.value.substr(0,lenval);
				window.document.review_frm.review_text.value = display_txt;
				alert(message);
			}
		}
		
		}
		
		function chk_msglength1(lenval)
		{
		var lenval= lenval;
		if(window.document.review_frm.pros.value != "")
		{
		message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";

			if(window.document.review_frm.pros.value.length >=lenval)
			{
			
				message += "* Pros description should not exceed 500 characters\n";
				orig_txt =window.document.review_frm.pros.value;
				display_txt = window.document.review_frm.pros.value.substr(0,lenval);
				window.document.review_frm.pros.value = display_txt;
				alert(message);
			}
		}
		
		}	
		
		function chk_msglength2(lenval)
		{
		var lenval= lenval;
		if(window.document.review_frm.cons.value != "")
		{
		message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";

			if(window.document.review_frm.cons.value.length >=lenval)
			{
			
				message += "* Cons description should not exceed 500 characters\n";
				orig_txt =window.document.review_frm.cons.value;
				display_txt = window.document.review_frm.cons.value.substr(0,lenval);
				window.document.review_frm.cons.value = display_txt;
				alert(message);
			}
		}
		
		}		
</script>
<?php

$hid_action = "save";



?>
<table width="100%" align="center" class="tableborder_new"  border="0" cellpadding="5" cellspacing="0">
<form name="review_frm" method="post" action="" onSubmit="return check_form_review(window.document.review_frm);">
<tr><td colspan="4" align='center' height="30" class="maincontentheading">
<font class='whitefont_header'>Submit your review for this Book:</font>
</td></tr>
<tr><td>


        <table width="100%" cellpadding="0" cellspacing="0" height="200">
          <tr valign="top" class="postaddcontent"> 
            <td height="25"><span class="whitefont">Review Title:</span><span class="starcolor">*</span></td>
            <td><textarea name="heading" cols="60" rows="1" onKeyUp="" class=""><?php echo $rev_data->heading; ?></textarea></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td height="75"><span class="whitefont">Review Text:</span> <span class="starcolor">*</span></td>
            <td><textarea name="review_text" cols="60" rows="5" onKeyUp="chk_msglength(2000);" onKeyDown="chk_msglength(2000);" class=""><?php echo $rev_data->review_text; ?></textarea></td></tr>
			<tr><td width="35%"></td>
            <td colspan="" align="left" height="25" valign="top"><span class="starcolor">Review 
              text should be between 100 and 2000 characters.</span></td>
          </tr>
			
          <?php 
		  if (1 == 2)
		  {?>
          <tr valign="top" class="postaddcontent"> 
            <td height="35"><span class="whitefont">Pros</span></td>
            <td><textarea name="pros" cols="60" rows="2" onKeyUp="chk_msglength1(500);" class=""><?php echo $rev_data->pros; ?></textarea></td>
          </tr>
		  <tr><td width="35%"></td><td  align="left" height="25" valign="top"><span class="starcolor">Pros should be between 0 and 500 characters..</span></td></tr>
         <tr valign="top" class="postaddcontent"> 
            <td height="35"><span class="whitefont">Cons</span></td>
            <td><textarea name="cons" cols="60" rows="2" onKeyUp="chk_msglength2(500)" class=""><?php echo $rev_data->cons; ?></textarea></td>
          </tr> 
		  <tr><td width="35%"></td><td  align="left" height="25" valign="top"><span class="starcolor">Cons should be between 0 and 500 characters.</span></td></tr>
		  <?php
		  }
		  ?>
          <tr valign="top" class="postaddcontent"> 
            <td height="25"><span class="whitefont">Overall Rating</span><span class="starcolor">*</span></td>
            <td><input type="text" name="rating" value="<?php echo $rev_data->rating; ?>"  onfocus="setbool(frm_obj.boolcheck, '1')" onblur="setbool(frm_obj.boolcheck, '0')" onkeypress="check_float_value(this.value)"></td>
          </tr>
		   <tr><td width="35%"></td><td  align="left" height="25" valign="top"><span class="starcolor">Rating must be between 0 and 5. Decimal values (eg 4.7) are allowed.</span></td></tr>
         
       <tr>
        
       <td align="center" valign="bottom" colspan="2">
<input type="image" src="images/buttons/submit.jpg"  border="0" style="border:0px;" align="absmiddle"></td>
</tr>
 <tr><td colspan="2"><div align="center">
 				<input type="hidden" name="id" value="<?php echo $rev_data->id; ?>"> 
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
				 <input type="hidden" name="user_id" value="<?php echo $customer_id ?>">
				 <input type="hidden" name="status" value="0">
				<input type="hidden" name="prod_id" value="<?php echo $data->prod_id; ?>">
				<input type="hidden" name="created_datetime" value="<?php echo (strlen($rev_data->created_datetime) > 0)?$rev_data->created_datetime:date("Y-m-d H:i:s"); ?>">
                      <input type="hidden" name="modify_datetime" value="<?php echo date("Y-m-d H:i:s"); ?>">
				
				</div>
				</td></tr>

</table>
</td></tr></form></table>