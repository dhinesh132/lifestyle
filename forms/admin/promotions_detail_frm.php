<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script language="javascript">
var frm_obj;
    function check_validate() 
	{
        error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  
		
        check_empty(form.elements["ban_name"].name,"Title should not be empty");
       
		
	}

</script>
 
<?php 

$img_dim_arr = explode(",",$ban_obj->image_copies['prod_thimg'][1]);
$th_img_arr = explode("|", $img_dim_arr[0]);
$lrg_img_arr = explode("|", $img_dim_arr[1]);


$hid_action = "save";

if($edit == 1 && $edit_id > 0)
{
	
	$res = $ban_obj->fetch_record($edit_id);
	$ban_obj = set_values($ban_obj, "db", $res[0]);

}


if(isset($_SESSION['ses_temp_ban_obj']) && is_array($_SESSION['ses_temp_ban_obj']))
{
	$ban_obj = set_values($ban_obj,"ses",$_SESSION['ses_temp_ban_obj']);
}

?>
<div class="whitebox mtop15">
<form action="" method="post" enctype="multipart/form-data" name="<?php echo $ban_obj->frm_name; ?>" onSubmit="return check_form(window.document.<?php echo $ban_obj->frm_name; ?>);">
<table width="65%" border="0" cellspacing="0" cellpadding="2" align="center" class="listing">
  
          <tr valign="top" class="postaddcontent"> 
            <td height="30" width="35%"><span class="whitefont">Code</span><span class="starcolor">*</span></td>
            <td width="65%"> <input type="text" name="Code" value="<?php echo stripslashes($ban_obj->Code['value']); ?>" class="mediumtxtbox">            </td>
          </tr>
		   <tr valign="top" class="postaddcontent"> 
            <td height="30" ><span class="whitefont">Value</span></td>
            <td ><select name="Type" class="mediumtxtbox" style="width:100px">
            <option value="$" <?php if($ban_obj->Type['value'] =="$"){?> selected="selected"<?php } ?>>$</option>
            <option value="%" <?php if($ban_obj->Type['value'] =="%"){?> selected="selected"<?php } ?>>%</option>
             <option value="Free" <?php if($ban_obj->Type['value'] =="Free"){?> selected="selected"<?php } ?>>Free Shipping</option>
            </select>
             &nbsp;<input type="text" name="Value" value="<?php echo stripslashes($ban_obj->Value['value']); ?>" class="mediumtxtbox" style="width:143px"></td>
          </tr>
           <tr valign="top" class="postaddcontent"> 
            <td height="30" width="25%"><span class="whitefont">Start Date</span></td>
            <td width="75%"> <input type="text" name="StartDate" value="<?php echo stripslashes($ban_obj->StartDate['value']); ?>" class="mediumtxtbox" id="StartDate">            </td>
          </tr>
           <tr valign="top" class="postaddcontent"> 
            <td height="30" width="25%"><span class="whitefont">Expiry Date</span></td>
            <td width="75%"> <input type="text" name="ExpiryDate" value="<?php echo stripslashes($ban_obj->ExpiryDate['value']); ?>" class="mediumtxtbox" id="ExpiryDate">            </td>
          </tr>
          
           <tr valign="top" class="postaddcontent"> 
            <td height="30" width="25%"><span class="whitefont">Min Cart Amount</span></td>
            <td width="75%"><input type="checkbox" value="1" name="MinAmountVal" <?php if($ban_obj->MinAmountVal['value'] ==1) {?> checked="checked"<?php } ?>/> &nbsp;Yes &nbsp;&nbsp;<input type="text" name="MinAmount" value="<?php echo stripslashes($ban_obj->MinAmount['value']); ?>" class="mediumtxtbox" id="MinAmount" style="width:150px">            </td>
          </tr>
           <tr valign="top" class="postaddcontent"> 
            <td height="30" width="25%"><span class="whitefont">Customer Login Required?</span></td>
            <td width="75%"><input type="checkbox" value="1" name="CustomerLogin" <?php if($ban_obj->CustomerLogin['value'] ==1) {?> checked="checked"<?php } ?>/> &nbsp;Yes             </td>
          </tr>
           <tr valign="top" class="postaddcontent"> 
            <td height="30" width="25%"><span class="whitefont">No.of Times to Use per Customer</span></td>
            <td width="75%"><input type="text" name="NoOfUseByCustomer" value="<?php echo stripslashes($ban_obj->NoOfUseByCustomer['value']); ?>" class="mediumtxtbox" id="ReUse" placeholder="No.of Times" style="width:150px"> </td>
          </tr>
           <tr valign="top" class="postaddcontent"> 
            <td height="30" width="25%"><span class="whitefont">Total No.of Times to Use this Coupon</span></td>
            <td width="75%"><input type="text" name="ReUse" value="<?php echo stripslashes($ban_obj->ReUse['value']); ?>" class="mediumtxtbox" id="ReUse" placeholder="No.of Times" style="width:150px">            </td>
          </tr>
		    <tr valign="top" class="postaddcontent"> 
            <td height="30" ><span class="whitefont">Promotion Apply To</span></td>
                    <td ><select name="ListCate[]" id="CatId" class="mediumtxtbox" multiple="multiple" style="height:60px;">
                    <option value="" >Select Category</option>
                    <?php 
                    $category = $ban_obj->CateId['value'];
                    $categories = explode(",",$ban_obj->CateId['value']);
                    $cat_res = $db_con_obj->fetch_flds("functions", "FunId,EnName", "1=1 and FunStatus =1 order by EnName asc"); 
                    while($cat_data = mysql_fetch_object($cat_res[0])){
                    ?>
                    <option value="<?php echo $cat_data->FunId; ?>" <?php if(in_array($cat_data->FunId,$categories)){?>selected="selected" <?php }?>><?php echo $cat_data->EnName; ?></option>
                    <?php } ?>
                    </select>
                  <br />
                <div id="Prod" style="padding-top:10px;">  
                   <select name="PromoItems[]" multiple="multiple" class="mediumtxtbox"  style="height:120px;">
            		<?php 	
					$products = explode(",",$ban_obj->ItemId['value']);
					$prod_res = $GLOBALS['db_con_obj']->fetch_flds("products","EnName,Id","Id in (".$ban_obj->ItemId['value'].") and ProdStatus=1");
    				while($prod_data = mysql_fetch_object($prod_res[0])){	?>
                    <option value="<?php echo $prod_data->Id;?>" <?php if(in_array($prod_data->Id,$products)){?>selected="selected" <?php }?>><?php echo $prod_data->EnName;?></option>
                    <?php } ?>
              </select>
                </div>
             
            
            </td>
          </tr>
          
       <tr valign="top" class="postaddcontent">
          <td  height="26"><span class="whitefont">Status</span></td>
          <td><select name="Status" class="mediumtxtbox">
              <option value="0" <?php echo ($ban_obj->Status['value'] == 0)?"selected":""; ?>>In-Active</option>
                <option value="1" <?php echo ($ban_obj->Status['value'] == 1)?"selected":""; ?>>Active</option>
          </select></td>
      </tr>
        
          <tr> 
            <td align="center" colspan="2"> <img align="absmiddle" src="<?php echo ($GLOBALS['in_admin']==1)?"../":"";?>images/reset.jpg" onClick="window.document.<?php echo $ban_obj->frm_name; ?>.reset();">&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="image" src="<?php echo ($GLOBALS['in_admin']==1)?"../":""; ?>images/submit.jpg" name="Submit" border="0" style="border:0px;" align="absmiddle"> 
              <input type="hidden" value="0" name="boolcheck">  <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
               <input type="hidden" name="date_modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="Id" value="<?php echo $ban_obj->Id['value']; ?>"> </td>
          </tr>
          
  </table>
</form>	
</div>

<script language="javascript">

frm_obj = window.document.<?php echo $ban_obj->frm_name; ?>;

$(function() {
$("#ExpiryDate" ).datepicker({
	changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    yearRange: "-5:+10",
	dateFormat:"yy-mm-dd"   
});
$("#StartDate" ).datepicker({
	changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    yearRange: "-5:+10",
	dateFormat:"yy-mm-dd"   
});
});
</script>

<script language="javascript">
$('#CatId').change(function(){
  var selected = $('#CatId').val()
  var str = '';
  for (var i=0;i<selected.length;i++){
    if (i>0) str += ', ';
      str += selected[i];
    }
  get_dynamic_dropdown('Prod', 'admin_ajax_content.php', 'required=promotion&category='+str)
});
</script>
