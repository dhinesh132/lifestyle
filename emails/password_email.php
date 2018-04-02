<?php 


$table_class = "border:1px #efead4 solid;";
$class_bottom_border= "font-size:13px; font-family:'DINNextLTPro-Light'; color:#807b5f; line-height:16px; border-bottom:1px #efead4 solid;  padding:10px 0 10px 5px; text-align:left; vertical-align:top;";
$class_only_font= "padding:10px 0 10px 0; text-align:left; vertical-align:top;font-size:13px; font-family:'DINNextLTPro-Light'; color:#807b5f; line-height:16px;";
$content='<table width="500px" border="0" cellspacing="0" cellpadding="2" align="center" style="'.$table_class.'">
    <tr> 
      <td> 
	  <p align="left" style="'.$class_only_font.'"><strong>Dear '.$data->cust_firstname." ". $data->cust_lastname.'</strong>';
	  
	  $content .='</p>
	  <table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
          <tr class="maincontentheading"> 
            <td colspan="2" height="30" align="left" style="'.$class_only_font.'">Your '.$GLOBALS['site_config']['company_name'].' login details are:</td>
          </tr>';
          $content .='<tr valign="top" class="postaddcontent" style="'.$class_only_font.'"> 
            <td width="12%" style="'.$class_only_font.'"><span class="whitefont">Email:</span></td>
            <td width="70%" style="'.$class_only_font.'">'.$data->cust_email.'</td>
          </tr><tr valign="top" class="postaddcontent" style="'.$class_only_font.'"> 
            <td width="12%" style="'.$class_only_font.'"><span class="whitefont">Password:</span></td>
            <td width="70%" style="'.$class_only_font.'">'.$data->cust_password.'</td>
          </tr>';
          $content .='</table></td>
    </tr>
  <tr>
    <td height="10"></td>
</tr>
  <tr> 
    <td style="'.$class_only_font.'">With Regards</td>
  </tr>
  <tr> 
    <td style="'.$class_only_font.'">'.$GLOBALS['site_config']['company_name'].'</td></tr>
</table>';
?>
