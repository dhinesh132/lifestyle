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
<input type="hidden" name="promotion_cat_id" value = "<?php echo $_REQUEST['promotion_cat_id'];?>" />
<table width="70%" border="0" cellspacing="0" cellpadding="2" align="center" class="listing">
  		    <tr valign="top" class="postaddcontent"> 
            <td height="25" ><span class="whitefont">Category</span></td>
            <td width="70%"> <select name="ListCate[]" id="CatId" class="mediumtxtbox">
            <option value="" >Select Category</option>
            <?php 
			$category = $ban_obj->Categories['value'];
			$categories = explode(",",$ban_obj->Categories['value']);
			$cat_res = $db_con_obj->fetch_flds("category", "Id,EnName", "1=1 and Status =1 order by EnName asc"); 
			while($cat_data = mysql_fetch_object($cat_res[0])){
			?>
			<option value="<?php echo $cat_data->Id; ?>" <?php if(in_array($cat_data->Id,$categories)){?>selected="selected" <?php }?>><?php echo $cat_data->EnName; ?></option>
			<?php } ?>
            </select>
            
            </td>
          </tr>
		  
            <tr valign="top" class="postaddcontent"> 
            <td height="25" width="20%"><span class="whitefont">Products</span><br /></td>
            <td width="70%"><span id="Prod">
            	<select name="product_id" id="ProductId" class="mediumtxtbox" >
            	<?php 	
            		$product = $ban_obj->Products['value'];
					$products = explode(",",$ban_obj->Products['value']);
					$prod_res = $GLOBALS['db_con_obj']->fetch_flds("products","EnName,Id","Category in (".$category.") and ProdStatus=1");
					
    				while($prod_data = mysql_fetch_object($prod_res[0])){	?>
                    <option value="<?php echo $prod_data->Id;?>" <?php if(in_array($prod_data->Id,$products)){?>selected="selected" <?php }?>><?php echo $prod_data->EnName;?></option>
                    <?php } ?>
              </select>
            </span>
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td height="25" width="20%"><span class="whitefont">Package</span><br /></td>
            <td width="70%"><span id="Packages">
            	<select name="package_id" id="PackageId" class="mediumtxtbox" >
            		<?php 	
					$packages = explode(",",$ban_obj->Packages['value']);
					$package_res = $GLOBALS['db_con_obj']->fetch_flds("product_sizes","EnTitle,Id","ProdId in (".$product.") and Status=1");
    				while($package_data = mysql_fetch_object($package_res[0])){	?>
                    <option value="<?php echo $package_data->Id;?>" <?php if(in_array($package_data->Id,$packages)){?>selected="selected" <?php }?>><?php echo $package_data->EnTitle;?></option>
                    <?php } ?>
              </select>
            </span>
            </td>
          </tr>
          
       <tr valign="top" class="postaddcontent">
          <td  height="26"><span class="whitefont">Status</span></td>
          <td><select name="status" class="mediumtxtbox">
              <option value="0" <?php echo ($ban_obj->status['value'] == 0)?"selected":""; ?>>In-Active</option>
                <option value="1" <?php echo ($ban_obj->status['value'] == 1)?"selected":""; ?>>Active</option>
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
function select_promotion_type(val){
	$("#package").hide();
	$("#menu").hide();
	$("#item").hide();
	if(val ==1){
		$("#package").show();
	}
	else if(val==2){
		$("#menu").show();
	}
	else if(val==3){
		$("#item").show();
		
	}
}
frm_obj = window.document.<?php echo $ban_obj->frm_name; ?>;

$(function() {
$("#ExpiryDate" ).datepicker({
	changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    yearRange: "-0:+10",
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
  $('#ProductId').append(get_dynamic_dropdown('ProductId', 'admin_ajax_content.php', 'required=productsbycat&category='+str))
  
});

$('#ProductId').change(function(){
	
		  var selected = $('#ProductId').val()
		  var str = '';
		  for (var i=0;i<selected.length;i++){
		    if (i>0) str += ', ';
		      str += selected[i];
		    }
		    
		  $('#PackageId').append(get_dynamic_dropdown('PackageId', 'admin_ajax_content.php', 'required=packagesbyprod&product_id='+str))
		  
	  
	});


</script>
