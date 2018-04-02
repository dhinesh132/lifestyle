<style>
	.login{
	font-weight:bold;
	color:#666;
	font-size:12px;	
}
.type{
	font-weight:bold;
	color:#666;
	font-size:12px;	
}
.newsletter{
	
	color:#666;
	font-size:12px;	
}
.itemfont{
	color:#666;
	font-size:12px;
	font-family:Century Gothic;
	padding-left:30px;
}
.postaddcontent{
	font-weight:bold;
	color:#666;
	font-size:12px;	
	font-family:Century Gothic;
}
.whitefont{
	font-weight:bold;
	color:#666;
	font-size:13px;	
	font-family:Century Gothic;
}
	</style>
<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="center"> 
      <table cellpadding="2" cellspacing="0" width="95%" border="0" bordercolor='#cccccc' class="tableborder_new">
        <tr class="maincontentheading"> 
          <td align="center" valign="top" colspan="2"> <font class="whitefont_header">Invoice&nbsp;-&nbsp;<?php echo $master_data->order_id; ?></font>          </td>
        </tr>
       <tr align="center" valign="top"> 
          <td align="left"><font class="login">To (Recipient):</font> </td>
          <td align="left" class="itemfont"><?php  
		  
		  	 echo stripslashes($master_data->ship_fname) . "<br>";
              echo stripslashes($master_data->ship_ads1);
			  if(strlen(trim($master_data->ship_ads2)) > 0)
              echo ", ".stripslashes($master_data->ship_ads2) . ",<br>";
              else
			  echo ",<br>";
			  echo stripslashes($master_data->ship_city);

              $bst = $db_con_obj->fetch_field("state", "statename", "state_code = '". $master_data->ship_state . "'");
			  if(strlen($bst) > 0)
			  	echo ", " . stripslashes($bst) . ",<br>";
			  else
			  	echo ",<br>";
			  
              $bctry = $db_con_obj->fetch_field("country", "countryname", "countryid = '". $master_data->ship_country . "'");
			  if(strlen($bctry) > 0)
			  echo stripslashes($bctry . ", " . $master_data->ship_zip); ?></td>
        </tr>
        
        <tr> 
          <td colspan=2 id="paydescid"></td>
        </tr>
        <tr> 
          <td colspan="2" align="left"> <hr size="0"></td>
        </tr>
        <tr>
          <td ><font class="postaddcontent">Invoice Number:</font></td><td class="itemfont"><?php echo $barcodeval; ?></td></tr>
         <tr>
           <td ><font class="postaddcontent">Invoice Barcode:</font></td><td class=""><img src="<?php echo $barcode_name?>"  /></td></tr>
        <tr> 
          <td colspan="2" align="left"> <hr size="0"></td>
        </tr>
		
       <tr> 
          <td width="33%" align="left" valign="top" nowrap> <font class="postaddcontent">From (Sender):</font> </td>
          <td width="67%" align="left" valign="top" nowrap class="itemfont">
            <?php

						echo trim(stripslashes($GLOBALS['site_config']['company_name'])) . "<br>";
						echo trim(stripslashes($GLOBALS['site_config']['company_address']));
											

										?></td>
        </tr>
      </table>
    </td>
              </tr>
            </table>
			
			<?php
			
			$temp_window_tilte1 = "Invoice ".$master_data->order_id; 
			?>