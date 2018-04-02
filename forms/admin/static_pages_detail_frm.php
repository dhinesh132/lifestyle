<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script language="javascript">
var frm_obj;
    function check_validate() 
	{
        error_message = "Errors have occurred during the process of your form.\n\nPlease make the following corrections:\n\n";  
		
		//check_empty(form.elements["pl_id"].name,"Page library should not be empty");
        check_empty(form.elements["EnTitle"].name,"Page/ Menu Title should not be empty");
		check_empty(form.elements["page_link"].name,"Page/ Menu Link should not be empty");
		check_empty(form.elements["page_content"].name,"Content should not be empty");
		
		
		  
	}

</script>

</script>
 
<?php 

$hid_action = "save";

if($edit == 1 && $edit_id > 0)
{
	
	$res = $sbg_obj->fetch_record($edit_id);
	$sbg_obj = set_values($sbg_obj, "db", $res[0]);

}


if(isset($_SESSION['ses_temp_spg_obj']) && is_array($_SESSION['ses_temp_spg_obj']))
{
	$sbg_obj = set_values($sbg_obj,"ses",$_SESSION['ses_temp_spg_obj']);
}

?>
<div class="whitebox mtop15">
<form action="" method="post" enctype="multipart/form-data" name="<?php echo $sbg_obj->frm_name; ?>" onSubmit="return check_form(window.document.<?php echo $sbg_obj->frm_name; ?>);">
<table width="70%" border="0" cellspacing="0" cellpadding="2" align="center" >
   
      
    
          <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">English Title </span><span class="starcolor">*</span></td>
            <td width="60%"><input type="text" name="EnTitle" style="width:250px" value="<?php echo stripslashes($sbg_obj->EnTitle['value']); ?>" class="mediumtxtbox">  </td>
    </tr>
      <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Chinese Title </span><span class="starcolor">*</span></td>
            <td width="60%"><input type="text" name="ChTitle" style="width:250px" value="<?php echo stripslashes($sbg_obj->ChTitle['value']); ?>" class="mediumtxtbox">  </td>
    </tr>
        <tr valign="top"> 
            <td  height="30" width="30%" class="postaddcontent"><span class="whitefont">Parent Type </span><span class="starcolor">*</span></td>
            <td width="60%"><select name="parent_id" class="mediumtxtbox">
            <option value="0" <?php if($sbg_obj->parent_id['value']==0){?> selected="selected"<?php }?>>Top Level</option>
			<?php $parent_res = $GLOBALS['db_con_obj']->fetch_flds($sbg_obj->cls_tbl,'EnTitle,Id','parent_id=0 order by EnTitle asc');
			while($parent_data = mysql_fetch_object($parent_res[0])){
			?>
            <option value="<?php echo $parent_data->Id;?>" <?php if($parent_data->Id==$sbg_obj->parent_id['value']){?> selected="selected"<?php }?>><?php echo $parent_data->EnTitle;?></option>
            <?php } ?>
            </select></td>
    </tr>
       <!-- <tr valign="top"> 
            <td  height="30" width="10%" class="postaddcontent"><span class="whitefont">Header </span><span class="starcolor">*</span></td>
            <td ><textarea name="page_header" style="width:250px" rows="4"  class="mediumtxtbox"> <?php echo stripslashes($sbg_obj->page_header['value']); ?></textarea>  </td>
    </tr> -->
       <tr valign="top"> 
            <td  height="30" class="postaddcontent"><span class="whitefont">Alias URL </span></td>
            <td width="60%"><input type="text" name="UniqueKey_temp" value="<?php echo stripslashes($sbg_obj->UniqueKey['value']); ?>" class="mediumtxtbox">   </td>
    </tr>
    <tr valign="top"> 
            <td  height="30" width="10%" class="postaddcontent"><span class="whitefont">Menu Type </span><span class="starcolor">*</span></td>
            <td ><select name="menu_type" class="mediumtxtbox">
			<option value="0" <?php echo ($sbg_obj->menu_type['value'] == 0)?"selected":""; ?>>Not in menu</option>
            <option value="3" <?php echo ($sbg_obj->menu_type['value'] == 3)?"selected":""; ?>>Main and Footer Menu</option>
            <option value="4" <?php echo ($sbg_obj->menu_type['value'] == 4)?"selected":""; ?>>Submenu</option>
            <option value="1" <?php echo ($sbg_obj->menu_type['value'] == 1)?"selected":""; ?>>Main menu</option>  
            <option value="2" <?php echo ($sbg_obj->menu_type['value'] == 2)?"selected":""; ?>>Footer menu</option>                
              </select></td>
    </tr>
        <tr valign="top"> 
            <td  height="30" width="10%" class="postaddcontent"><span class="whitefont">Banner Type</span><span class="starcolor">*</span></td>
            <td ><input type="radio" name="banner_type" <?php echo ($sbg_obj->banner_type['value']==1)?'checked="checked"':''; ?> value="1" />&nbsp;Flash &nbsp;&nbsp;<input type="radio" name="banner_type" value="2" <?php echo ($sbg_obj->banner_type['value']!=1)?'checked="checked"':''; ?> />&nbsp;Image</td>
    </tr>
         <tr valign="top"> 
            <td  height="30" width="10%" class="postaddcontent"><span class="whitefont">Banner Image</span><span class="starcolor">*</span></td>
            <td ><input type="file" name="banner_image" style="width:250px"/>
              <?php echo display_view_delete_links($sbg_obj, "banner_image"); ?>
    </tr>
	  	   <tr valign="top" class="postaddcontent">
	  	     <td><span class="whitefont">English Content</span></td>
	  	     <td>&nbsp;</td>
    </tr>
	  	   <tr valign="top" class="postaddcontent"> 
            <td colspan="2" align="center"><?php
$sBasePath = $_SERVER['PHP_SELF'] ;
$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;

$oFCKeditor = new FCKeditor('EnContent') ;
$oFCKeditor->Value = stripslashes($sbg_obj->EnContent['value']);
$oFCKeditor->BasePath	= $sBasePath ;
$oFCKeditor->Create() ;
?></td>
          </tr>
             <tr valign="top" class="postaddcontent">
	  	     <td><span class="whitefont">Chinese Content</span></td>
	  	     <td>&nbsp;</td>
             </tr>
		    <tr valign="top" class="postaddcontent"> 
            <td colspan="2" align="center"><?php
$sBasePath = $_SERVER['PHP_SELF'] ;
$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;

$oFCKeditor = new FCKeditor('ChContent') ;
$oFCKeditor->Value = stripslashes($sbg_obj->ChContent['value']);
$oFCKeditor->BasePath	= $sBasePath ;
$oFCKeditor->Create() ;
?></td>
          </tr>
            
      <tr valign="top"> 
            <td  height="30" width="10%" class="postaddcontent"><span class="whitefont">SEO Page Title</span><span class="starcolor">*</span></td>
            <td ><textarea name="meta_title" cols="70" rows="2"><?php echo $sbg_obj->meta_title['value']?></textarea>
    </tr>
    
         <tr valign="top"> 
            <td  height="30" width="10%" class="postaddcontent"><span class="whitefont">SEO Meta Keywords</span><span class="starcolor">*</span></td>
            <td ><textarea name="meta_keywords" cols="70" rows="3"><?php echo $sbg_obj->meta_keywords['value']?></textarea>
    </tr>
    
         <tr valign="top"> 
            <td  height="30" width="10%" class="postaddcontent"><span class="whitefont">SEO Meta Descriptions</span><span class="starcolor">*</span></td>
            <td ><textarea name="meta_description" cols="70" rows="4"><?php echo $sbg_obj->meta_description['value']?></textarea>
    </tr>
            
	        <tr valign="top" class="postaddcontent">
	          <td  height="30"><span class="whitefont">Status</span></td>
            <td><select name="display_status" class="mediumtxtbox1">
			<option value="0" <?php echo ($sbg_obj->display_status['value'] == 0)?"selected":""; ?>>In-Active</option>
                <option value="1" <?php echo ($sbg_obj->display_status['value'] == 1)?"selected":""; ?>>Active</option>
                
              </select></td>
           </tr>
     <?php if($_SESSION['ses_admin_id']==1){?>
    <tr valign="top"> 
            <td  height="30" width="10%" class="postaddcontent"><span class="whitefont">Rights to edit</span><span class="starcolor">*</span></td>
            <td ><select name="rights_to_visible" class="mediumtxtbox1">
            <option value="1">Superadmin Only</option>
            <?php $admin_res = $GLOBALS['db_con_obj']->fetch_flds("admin","admin_id,admin_uname","admin_id !=1");
			while($admin_data =mysql_fetch_object($admin_res[0])){
			?>
			<option value="<?php echo $admin_data->admin_id?>" <?php echo ($sbg_obj->rights_to_visible['value'] == $admin_data->admin_id)?"selected":""; ?>><?php echo $admin_data->admin_uname?></option>  
            <?php }?>           
              </select></td>
    </tr>
    <?php }?>
    <tr valign="top" class="postaddcontent"> 
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center"> 
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
               <input type="hidden" name="date_entered" value="<?php echo (strlen($sbg_obj->date_entered['value']) > 0)?$sbg_obj->date_entered['value']:date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="date_modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="Id" value="<?php echo $sbg_obj->Id['value']; ?>">
              </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="2"><a href="#"><img align="absmiddle" src="../images/reset.jpg" onClick="window.document.<?php echo $type_obj->frm_name; ?>.reset();" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;
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
frm_obj = window.document.<?php echo $sbg_obj->frm_name; ?>;	
</script>