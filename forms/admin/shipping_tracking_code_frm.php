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
	
	$res = $ser_obj->fetch_record($edit_id);
	$ser_obj = set_values($ser_obj, "db", $res[0]);

}


if(isset($_SESSION['ses_temp_ser_obj']) && is_array($_SESSION['ses_temp_ser_obj']))
{
	$ser_obj = set_values($ser_obj,"ses",$_SESSION['ses_temp_ser_obj']);
}

?>
<form action="" method="post" enctype="multipart/form-data" name="<?php echo $ser_obj->frm_name; ?>" onSubmit="return check_form(window.document.<?php echo $ser_obj->frm_name; ?>);">
<table width="70%" border="0" cellspacing="0" cellpadding="2" align="center" class="tableborder_new">
   <tr class="maincontentheading"> 
            <td height="29" colspan="2" align='center' class='whitefont_header'>Update Shipping Details</td>
          </tr> <tr valign="top">
            <td  height="15" class="postaddcontent">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		
          <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Invoice No</span><span class="starcolor">*</span></td>
            <td width="70%"><?php 
			$order_id = stripslashes($ser_obj->order_id['value']);
			if(strlen($order_id ) <4){
			$len = strlen($order_id )+1;
			for($i=$len; $i<=4;$i++){
				$str .= "0";
			}
			}
			else
			$str='';
			$barcodeval = $str.$order_id ;

			$barcodeval = date("Ymd",strtotime($ser_obj->date_entered['value'])).$barcodeval;
		   echo $barcodeval;
			?></td>
    	 </tr>
               
         <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Shipping Tracking Number</span><span class="starcolor">*</span></td>
            <td width="70%"><input type="text" name="ship_tracking_number" value="<?php echo stripslashes($ser_obj->ship_tracking_number['value']); ?>" class="smalltxtbox">
            </td>
    	 </tr>
                  
         <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Change Invoice Status </span></td>
            <td width="70%"><select name="order_status" >
            <option value="2" <?php echo ($ser_obj->order_status['value'] ==2)?'selected="selected"':'';?> > Mark as Shipped</option>
             <option value="1" <?php echo ($ser_obj->order_status['value'] ==1)?'selected="selected"':'';?>>Mark as Paid/ Shippmend pending</option>
              <option value="0" <?php echo ($ser_obj->order_status['value'] ==0)?'selected="selected"':'';?>>Mark as Not Paid</option>
            </select>
            </td>
    	 </tr>
		 
         
         
    <tr valign="top" class="postaddcontent"> 
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center"> 
               <input type="hidden" name="submit_action" value="update_tracking_no">
               <input type="hidden" name="Modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="order_id" value="<?php echo $ser_obj->order_id['value']; ?>">
              </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="2"><a href="#"><img align="absmiddle" src="../images/reset.jpg" onClick="window.document.<?php echo $ser_obj->frm_name; ?>.reset();" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="image" src="../images/submit.jpg" name="Submit" border="0" style="border:0px;" align="absmiddle"> 
              <input type="hidden" value="0" name="boolcheck"> </td>
          </tr>
          <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
  </table>
</form>	

<script language="javascript">
frm_obj = window.document.<?php echo $ser_obj->frm_name; ?>;	
</script>