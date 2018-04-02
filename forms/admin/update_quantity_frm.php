<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>js/jquery.js" type="text/javascript"></script>
<script language="javascript">
var frm_obj;
    function check_validate() 
	{
        error_message = "Errors have occurred during the process of your form.\n\nPlease make the following corrections:\n\n";  
		check_empty(form.elements["EnName"].name,"English Title should not be empty");
		check_empty(form.elements["ChName"].name,"Chinese Title should not be empty");
		check_empty(form.elements["Price"].name,"Price should not be empty");
		check_empty(form.elements["Quantity"].name,"Quantity should not be empty");	  
	}


</script>


<?php 

$hid_action = "save";

if($edit == 1 && $edit_id > 0)
{
	
	$res = $prod_obj->fetch_record($edit_id);
	$prod_obj = set_values($prod_obj, "db", $res[0]);

}


if(isset($_SESSION['ses_temp_prod_obj']) && is_array($_SESSION['ses_temp_prod_obj']))
{
	$prod_obj = set_values($prod_obj,"ses",$_SESSION['ses_temp_prod_obj']);
}

?>
<form action="" method="post" enctype="multipart/form-data" name="<?php echo $prod_obj->frm_name; ?>" onSubmit="return check_form(window.document.<?php echo $prod_obj->frm_name; ?>);">
<table width="70%" border="0" cellspacing="0" cellpadding="2" align="center" class="tableborder_new">
   <tr class="maincontentheading"> 
            <td height="29" colspan="2" align='center' class='whitefont_header'>Update Quantity</td>
          </tr> <tr valign="top">
            <td  height="15" class="postaddcontent">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		
          <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">English Name </span><span class="starcolor">*</span></td>
            <td width="70%"><?php echo stripslashes($prod_obj->EnName['value']); ?></td>
    	 </tr>
               
         <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Total Quantity</span><span class="starcolor">*</span></td>
            <td width="70%"><?php echo stripslashes($prod_obj->Quantity['value']); ?><input type="hidden" name="TotalQty" value="<?php echo stripslashes($prod_obj->Quantity['value']); ?>" class="mediumtxtbox">
            </td>
    	 </tr>
         <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Purchased Quantity</span></td>
            <td width="70%"><?php echo PurchasedQuantity($prod_obj->Id['value']); ?>
            </td>
    	 </tr>
          <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Loged Quantity(For 1 Day)</span></td>
            <td width="70%"><?php echo LogedQuantity($prod_obj->Id['value']); ?>
            </td>
    	 </tr>
         <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Remainig Quantity</span></td>
            <td width="70%"><?php echo ProductQuantity($prod_obj->Id['value']); ?>
            </td>
    	 </tr>
         <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Add Extra(Quantity)</span><span class="starcolor">*</span></td>
            <td width="70%"><input type="text" name="ExtraQty" value="" class="smalltxtbox">
            </td>
    	 </tr>
		 
         
         
    <tr valign="top" class="postaddcontent"> 
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center"> 
               <input type="hidden" name="sub_action" value="Quantity">
               <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
               <input type="hidden" name="Created" value="<?php echo (strlen($prod_obj->Created['value']) > 0)?$prod_obj->Created['value']:date("Y-m-d H:i:s"); ?>">
               <input type="hidden" name="Modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="Id" value="<?php echo $prod_obj->Id['value']; ?>">
              </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="2"><a href="#"><img align="absmiddle" src="../images/reset.jpg" onClick="window.document.<?php echo $prod_obj->frm_name; ?>.reset();" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="image" src="../images/submit.jpg" name="Submit" border="0" style="border:0px;" align="absmiddle"> 
              <input type="hidden" value="0" name="boolcheck"> </td>
          </tr>
          <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
  </table>
</form>	

<script language="javascript">
frm_obj = window.document.<?php echo $prod_obj->frm_name; ?>;	
</script>