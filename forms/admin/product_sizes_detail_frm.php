<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script language="javascript">
var frm_obj;
    function check_validate() 
	{
        error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  
		
     check_empty(form.elements["EnTitle"].name,"Pack should not be empty");
	 check_empty(form.elements["Price"].name,"Price should not be empty");
		
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
<div class="whitebox mtop15">
<form action="" method="post" enctype="multipart/form-data" name="<?php echo $prod_obj->frm_name; ?>" onSubmit="return check_form(window.document.<?php echo $prod_obj->frm_name; ?>);">
<table width="75%" border="0" cellspacing="0" cellpadding="2" align="center" class="listing">
  
           <tr valign="top" class="postaddcontent"> 
            <td height="25" width="30%"><span class="whitefont">Size </span><span class="starcolor">*</span></td>
            <td width="70%"> <input type="text" name="EnTitle" value="<?php echo $prod_obj->EnTitle['value']; ?>" class="mediumtxtbox">
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td height="25" width="30%"><span class="whitefont">Product Code</span></td>
            <td width="70%"> <input type="text" name="prod_code" value="<?php echo $prod_obj->prod_code['value']; ?>" class="mediumtxtbox">
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td height="25" width="30%"><span class="whitefont">Weight</span> (<span class="starcolor">Kg</span>)</td>
            <td width="70%"> <input type="text" name="Weight" value="<?php echo $prod_obj->Weight['value']; ?>" class="mediumtxtbox">
            </td>
          </tr>
            <tr valign="top" class="postaddcontent"> 
            <td height="25" width="30%"><span class="whitefont">Standard Price</span><span class="starcolor">*</span></td>
            <td width="70%"> <input type="text" name="Price" value="<?php echo $prod_obj->Price['value']; ?>" class="mediumtxtbox">
            </td>
          </tr>
         <!-- <tr valign="top" class="postaddcontent"> 
            <td height="25" width="30%"><span class="whitefont">Promotion Price</span><span class="starcolor"></span></td>
            <td width="70%"> <input type="text" name="StandardPrice" value="<?php echo $prod_obj->StandardPrice['value']; ?>" class="mediumtxtbox">
            </td>
          </tr>-->
         
         <!-- <tr valign="top" class="postaddcontent"> 
            <td height="25" width="30%"><span class="whitefont">Picture</span> <span class="starcolor">&nbsp;(269px X 308px, Less then 1.5 MB )</span></td>
            <td width="70%"> <input type="file" name="Picture" value="<?php echo $prod_obj->Picture['value']; ?>" class="mediumtxtbox"> <?php echo display_view_delete_links($prod_obj, "Picture"); ?>
            </td>
          </tr>-->
            <tr valign="top" class="postaddcontent">
	          <td  height="30"><span class="whitefont">Status</span></td>
            <td><select name="Status" class="mediumtxtbox">
			<option value="0" <?php echo ($prod_obj->Status['value'] == 0)?"selected":""; ?>>In-Active</option>
                <option value="1" <?php echo ($prod_obj->Status['value'] == 1)?"selected":""; ?>>Active</option>
                
              </select></td>
         </tr>
        
          <tr> 
            <td align="center" colspan="2"> <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
               <input type="hidden" name="date_modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
               <input type="hidden" name="Id" value="<?php echo $prod_obj->Id['value']; ?>">
                <input type="hidden" name="ProdId" value="<?php echo $_SESSION['ses_prod_id']; ?>">
               <input type="hidden" name="Status" value="1"> <img align="absmiddle" src="<?php echo ($GLOBALS['in_admin']==1)?"../":"";?>images/reset.jpg" onClick="window.document.<?php echo $prod_obj->frm_name; ?>.reset();">&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="image" src="<?php echo ($GLOBALS['in_admin']==1)?"../":""; ?>images/submit.jpg" name="Submit" border="0" style="border:0px;" align="absmiddle"> 
              <input type="hidden" value="0" name="boolcheck"> </td>
          </tr>
          
  </table>
</form>
</div>	

<script language="javascript">
frm_obj = window.document.<?php echo $prod_obj->frm_name; ?>;	
</script>