<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>js/jquery.js" type="text/javascript"></script>
<script language="javascript">
var frm_obj;
    function check_validate() 
	{
        error_message = "Errors have occurred during the process of your form.\n\nPlease make the following corrections:\n\n";  
		check_empty(form.elements["EnName"].name,"English Title should not be empty");
		check_empty(form.elements["ChName"].name,"Chinese Title should not be empty");
		check_empty(form.elements["ProdCode"].name,"Products code should not be empty");
		check_empty(form.elements["Price"].name,"Price should not be empty");
		check_empty(form.elements["Quantity"].name,"Quantity should not be empty");	  
	}

$(document).ready(function() {

	//Default Action
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content
	
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	});

});
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
<table width="70%" border="0" cellspacing="0" cellpadding="2" align="center" class="tableborder_new">
 
		
          <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">English Name </span><span class="starcolor">*</span></td>
            <td width="70%"><input type="text" name="EnName" value="<?php echo stripslashes($prod_obj->EnName['value']); ?>" class="mediumtxtbox">   </td>
    	 </tr>
         <tr valign="top"> 
            <td  height="30" class="postaddcontent"><span class="whitefont">Alias URL </span></td>
            <td width="60%"><input type="text" name="UniqueKey_temp" value="<?php echo stripslashes($prod_obj->UniqueKey['value']); ?>" class="mediumtxtbox">   </td>
    </tr>
<!--         <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Chinese Name </span><span class="starcolor">*</span></td>
            <td width="70%"><input type="text" name="ChName" value="<?php echo stripslashes($prod_obj->ChName['value']); ?>" class="mediumtxtbox">   </td>
    	 </tr>-->
          <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Code </span><span class="starcolor">*</span></td>
            <td width="70%"><input type="text" name="ProdCode" value="<?php echo stripslashes($prod_obj->ProdCode['value']); ?>" class="mediumtxtbox">   </td>
    	 </tr>
          <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Type </span><span class="starcolor">*</span></td>
            <td width="70%"><select name="TypeArray[]" multiple="multiple"  class="mediumtxtbox" style=" height:60px;" >
            <?php 
			$SelectedTypes = explode(",",$prod_obj->Types['value']);
			$type_res = $db_con_obj->fetch_flds("types", "TypeId,EnName", "1=1 and TypeStatus =1 order by EnName asc"); 
			while($type_data = mysql_fetch_object($type_res[0])){
			?>
			<option value="<?php echo $type_data->TypeId; ?>" <?php if(in_array($type_data->TypeId,$SelectedTypes)){?> selected="selected"<?php }?>><?php echo $type_data->EnName; ?></option>
			<?php } ?>
            </select>
            </td>
    	 </tr>
          <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Material </span><span class="starcolor">*</span></td>
            <td width="70%"><select name="MaterialArray[]"  multiple="multiple"  class="mediumtxtbox" style=" height:60px;" >
            <?php 
			$SelectedMat = explode(",",$prod_obj->Material['value']);
			$mat_res = $db_con_obj->fetch_flds("materials", "MatId,EnName", "1=1 and MatStatus =1 order by EnName asc"); 
			while($mat_data = mysql_fetch_object($mat_res[0])){
			?>
			<option value="<?php echo $mat_data->MatId; ?>" <?php if(in_array($mat_data->MatId,$SelectedMat)){?> selected="selected"<?php }?>><?php echo $mat_data->EnName; ?></option>
			<?php } ?>
            </select>
            </td>
    	 </tr>
         <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Function </span><span class="starcolor">*</span></td>
            <td width="70%"><select name="FunctionArray[]"  multiple="multiple"  class="mediumtxtbox" style=" height:60px;" >
            <?php 
			$SelectedFun = explode(",",$prod_obj->Function['value']);
			$fun_res = $db_con_obj->fetch_flds("functions", "FunId,EnName", "1=1 and FunStatus =1 order by EnName asc"); 
			while($fun_data = mysql_fetch_object($fun_res[0])){
			?>
			<option value="<?php echo $fun_data->FunId; ?>" <?php if(in_array($fun_data->FunId,$SelectedFun)){?> selected="selected"<?php }?>><?php echo $fun_data->EnName; ?></option>
			<?php } ?>
            </select>
            </td>
    	 </tr>
         <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Product Group </span></td>
            <td width="70%"><select name="GroupArray[]" multiple="multiple"  class="mediumtxtbox" style=" height:60px;" >
            <?php 
			$SelectedTypes = explode(",",$prod_obj->Groups['value']);
			$group_res = $db_con_obj->fetch_flds("groups", "GroupId,EnName", "1=1 and GroupStatus =1 order by EnName asc"); 
			while($group_data = mysql_fetch_object($group_res[0])){
			?>
			<option value="<?php echo $group_data->GroupId; ?>" <?php if(in_array($group_data->GroupId,$SelectedTypes)){?> selected="selected"<?php }?>><?php echo $group_data->EnName; ?></option>
			<?php } ?>
            </select>
            </td>
    	 </tr>
          <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Price</span><span class="starcolor">*</span></td>
            <td width="70%"><input type="text" name="Price" value="<?php echo stripslashes($prod_obj->Price['value']); ?>" class="mediumtxtbox">
            </td>
    	 </tr>
         <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Quantity</span><span class="starcolor">*</span></td>
            <td width="70%"><input type="text" name="Quantity" value="<?php echo stripslashes($prod_obj->Quantity['value']); ?>" class="mediumtxtbox">
            </td>
    	 </tr>
        <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Star</span><span class="starcolor">*</span></td>
            <td width="70%"><input type="text" name="admin_star" value="<?php echo stripslashes($prod_obj->admin_star['value']); ?>" class="mediumtxtbox">
            </td>
    	 </tr>
         <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Weight(in kg)</span><span class="starcolor">*</span></td>
            <td width="70%"><input type="text" name="Weight" value="<?php echo stripslashes($prod_obj->Weight['value']); ?>" class="mediumtxtbox">
            </td>
    	 </tr>
		 <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Picture</span><span class="starcolor">*</span><span class="starcolor">(Resizable and Recommended size 900px X 730px)</span></td>
            <td width="70%"><input type="file" name="Image"  class="">
            <?php echo display_view_delete_links($prod_obj, "Image"); ?></td>
    	 </tr>
          <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Video</span><span class="starcolor">(Less than 1.5MB)</span></td>
            <td width="70%"><input type="file" name="Video" class="">
            <?php echo display_view_delete_links($prod_obj, "Video"); ?></td>
    	 </tr>
         <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Is Featured Product?</span></td>
            <td width="70%"><input type="checkbox" name="IsFeatured" value="1"  <?php if($prod_obj->IsFeatured['value']==1){?> checked="checked"<?php }?> />
            </td>
    	 </tr>
	        <tr valign="top" class="postaddcontent">
	          <td  height="30"><span class="whitefont">ProdStatus</span></td>
            <td><select name="ProdStatus" class="mediumtxtbox1">
			<option value="0" <?php echo ($prod_obj->ProdStatus['value'] == 0)?"selected":""; ?>>In-Active</option>
                <option value="1" <?php echo ($prod_obj->ProdStatus['value'] == 1)?"selected":""; ?>>Active</option>
                
              </select></td>
         </tr>
         
          <tr valign="top"> 
                <td  height="30" width="20%" class="postaddcontent"><span class="whitefont">Summary</span></td><td width="80%" >
               <textarea name="EnShortDesc" cols="60" rows="5"><?php echo stripslashes($prod_obj->EnShortDesc['value']); ?></textarea>
                  </td>
    	 	</tr>
            <tr valign="top"> 
                <td  height="20" width="20%"  class="postaddcontent"><span class="whitefont">Description</span></td>
                <td width="80%" colspan="2">
                <?php
					/*$sBasePath = $_SERVER['PHP_SELF'] ;
					$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
					
					$fckChDesc = new FCKeditor('ChLongDesc') ;
					$fckChDesc->Value = stripslashes($prod_obj->ChLongDesc['value']);
					$fckChDesc->BasePath	= $sBasePath ;
					$fckChDesc->Create() ; */
					
				?>
                <textarea name="EnLongDesc" cols="60" rows="5"><?php echo stripslashes($prod_obj->EnLongDesc['value']); ?></textarea>
                  </td>
    	 	</tr>
           
            <tr valign="top"> 
                <td  height="30" width="30%" colspan="2" class="postaddcontent"><span class="whitefont">Information</span></td>
                </tr>
                <tr valign="top"><td width="100%" colspan="2">
                <?php
					$sBasePath = $_SERVER['PHP_SELF'] ;
					$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
					
					$fckEnInfo = new FCKeditor('EnInfo') ;
					$fckEnInfo->Value = stripslashes($prod_obj->EnInfo['value']);
					$fckEnInfo->BasePath	= $sBasePath ;
					$fckEnInfo->Create() ;
				?>
                  </td>
    	 	</tr>
             <tr valign="top"> 
                <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Search Tags</span></td>
                <td width="70%"><textarea name="serach_tags" cols="50" rows="3"><?php echo stripslashes($prod_obj->serach_tags['value']); ?></textarea> </td>
    	 	</tr>
         
            <tr valign="top"> 
                <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Title</span></td>
                <td width="70%"><textarea name="MetaTitle" cols="50" rows="3"><?php echo stripslashes($prod_obj->MetaTitle['value']); ?></textarea>  </td>
    	 	</tr>
            <tr valign="top"> 
                <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Keywords</span></td>
                <td width="70%"><textarea name="MetaKey" cols="50" rows="3"><?php echo stripslashes($prod_obj->MetaKey['value']); ?></textarea> </td>
    	 	</tr>
            <tr valign="top"> 
                <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Description</span></td>
                <td width="70%"><textarea name="MetaDesc" cols="50" rows="3"><?php echo stripslashes($prod_obj->MetaDesc['value']); ?></textarea>   </td>
    	 	</tr>
         
    <tr valign="top" class="postaddcontent"> 
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center"> 
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
</div>
<script language="javascript">
frm_obj = window.document.<?php echo $prod_obj->frm_name; ?>;	
</script>