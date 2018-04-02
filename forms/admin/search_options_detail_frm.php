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
<table width="70%" border="0" cellspacing="0" cellpadding="2" align="center" class="listing">
  		    <tr valign="top"> 
            <td  height="30" width="20%" class="postaddcontent"><span class="whitefont">Title</span><span class="starcolor">*</span></td>
            <td width="80%"><input type="text" name="EnTitle" value="<?php echo stripslashes($ban_obj->EnTitle['value']); ?>" class="mediumtxtbox">   </td>
    	 </tr>
           <tr valign="top" class="postaddcontent"> 
            <td height="30" ><span class="whitefont">Unique Key</span></td>
            <td > <input type="text" name="UniqueKey_temp" value="<?php echo stripslashes($ban_obj->UniqueKey['value']); ?>" class="mediumtxtbox">            </td>
          </tr>
          <?php if(1==2) {?>
		   <tr valign="top" class="postaddcontent"> 
            <td height="31"><span class="whitefont">Banner Image</span><span class="starcolor">(471px X 245px & less then 1.5 MB)</span></td>
            <td><input type="file" name="BanImage" />
              <?php echo display_view_delete_links($ban_obj, "BanImage"); ?></td>
          </tr>
          
           <tr valign="top" class="postaddcontent"> 
            <td height="30" ><span class="whitefont">Expiry Date</span></td>
            <td > <input type="text" name="ExpiryDate" value="<?php echo stripslashes($ban_obj->ExpiryDate['value']); ?>" class="mediumtxtbox" id="ExpiryDate">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td height="30" ><span class="whitefont">Discount </span><span class="starcolor">(%)</span></td>
            <td > <input type="text" name="Discount" value="<?php echo stripslashes($ban_obj->Discount['value']); ?>" class="mediumtxtbox" id="ExpiryDate">            </td>
          </tr>
         <?php } ?>
         <tr valign="top"> 
            <td  height="30" width="20%" class="postaddcontent"><span class="whitefont">Functions</span><span class="starcolor">*</span></td>
            <td width="80%">
            <?php
			
				$menu_array = explode(",",$ban_obj->FunctionsIds['value']);
				
			?>
            <select name="FunArray[]" class="mediumtxtbox" multiple="multiple" style="height:100px;" id="MenuId">
            <option value="">Please select</option>
			<?php $menu_res = $GLOBALS['db_con_obj']->fetch_flds("functions",'EnName,FunId','FunStatus=1 order by EnName asc');
			while($menu_data = mysql_fetch_object($menu_res[0])){?>
            <option value="<?php echo $menu_data->FunId;?>" <?php if(in_array($menu_data->FunId,$menu_array)){?> selected="selected"<?php }?>><?php echo $menu_data->EnName;?></option>
            <?php } ?>
            </select> 
            </td>
    	 </tr>
          
         <tr>
         <td colspan="2">
         <table width="90%" border="0" cellspacing="0" cellpadding="2" align="center" >
             <tr>
               <td  height="30" width="45%" style="left:150px;"><span class="whitefont">Products(s)</span></td>
               <td  height="30" width="5%" ></td>
               <td width="50%"><span class="whitefont">Selected Products(s)</span></td>
             </tr>
              <tr>
               <td  height="30" width="50%" align="right" ><div id="Items" style="padding-top:10px;">
			   <?php if($menu_array !=''){ ?>
               <select name="SelectedItemId[]" class="mediumtxtbox" multiple="multiple" style="height:150px;width:350px" id="SelectedItemId">
              
                    </select>
               <?php } ?>
               </div></td>
                <td  ><table><tr><td><div align="right" class="pagination">
                <a href="javascript:void(0)" class="pagelink" onclick="add_item()"> &gt;&gt;</a></div></td></tr>
                <tr><td><div align="right" class="pagination"><a href="javascript:void(0)" onclick="remove_item()" class="pagelink">&lt;&lt;</a></div></td></tr></table></td>
                <td width="50%"> <div id="selectedItem" style="padding-top:10px;">
                
                <select name="ItemIds[]" class="mediumtxtbox" multiple="multiple" style="height:150px;width:350px" id="ItemId">
                 <?php 	
					 $qry = "select EnName,Id from products where ProdStatus=1 and Id in(".$ban_obj->ItemId['value'].") order by FIND_IN_SET(Id,'".$ban_obj->ItemId['value']."')";
					 $dish_res = $GLOBALS['db_con_obj']->execute_sql($qry,"select");
					while($dish_data = mysql_fetch_object($dish_res[0])){ ?>
                  
                     <option value="<?php echo $dish_data->Id?>" selected="selected"><?php echo $dish_data->EnName?></option>
                       <?php } ?>
               </select></div></td>
             </tr>
           </table>
           </td>           
          </tr>
           
             
        <!--  <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Details</span></td>
	  	     <td><?php
			$sBasePath = $_SERVER['PHP_SELF'] ;
			$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
			
			$oFCKeditor = new FCKeditor('EnDetails') ;
			$oFCKeditor->Value = stripslashes($ban_obj->EnDetails['value']);
			$oFCKeditor->BasePath	= $sBasePath ;
			$oFCKeditor->Create() ;
			?></td>
          </tr>-->
            
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
$('#MenuId').change(function(){
  var selected = $('#MenuId').val()
  var str = '';
  for (var i=0;i<selected.length;i++){
    if (i>0) str += ', ';
      str += selected[i];
    }
  $fltrby = $('#Filterby').val();
  get_dynamic_dropdown('Items', '../ajax_content.php', 'required=promotions&filterby='+$fltrby+'&menu='+str)
});

$('#Filterby').blur(function(){
  var selected = $('#MenuId').val()
  var str = '';
  for (var i=0;i<selected.length;i++){
    if (i>0) str += ', ';
      str += selected[i];
    }
  $fltrby = $('#Filterby').val();
  get_dynamic_dropdown('Items', '../ajax_content.php', 'required=promotions&filterby='+$fltrby+'&menu='+str)
});

function add_item(){
 return !$('#SelectedItemId option:selected').appendTo('#ItemId')
}

function remove_item(){
	return !$('#ItemId option:selected').remove(); 	
	$("#ItemId option").each(function()
	{
    $(this).prop('selected', true);
	});
}
</script>
