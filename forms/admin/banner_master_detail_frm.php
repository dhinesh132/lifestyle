<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script language="javascript">
var frm_obj;
    function check_validate() 
	{
        error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  
		
        check_empty(form.elements["ban_name"].name,"Product name should not be empty");
       
		
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
<table width="65%" border="0" cellspacing="0" cellpadding="2" align="center" >
      
          <tr valign="top" class="postaddcontent"> 
            <td height="30" width="50%"><span class="whitefont">Masthead Images Title </span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="ban_name" value="<?php echo stripslashes($ban_obj->ban_name['value']); ?>" class="mediumtxtbox">            </td>
          </tr>
		   <tr valign="top" class="postaddcontent"> 
            <td height="30" width="50%"><span class="whitefont">Masthead Images Link </span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="ban_link" value="<?php echo stripslashes($ban_obj->ban_link['value']); ?>" class="mediumtxtbox">            </td>
          </tr>
		   <tr valign="top" class="postaddcontent"> 
            <td height="31"><span class="whitefont">Masthead Images(English) </span><span class="starcolor">(800px X 350px)</span></td>
            <td><input type="file" name="EnBanimage" />
              <?php echo display_view_delete_links($ban_obj, "EnBanimage"); ?></td>
          </tr>
		   <tr valign="top"> 
                <td  height="30" width="30%" colspan="2" class="postaddcontent"><span class="whitefont">Captions</span></td>
                </tr>
                <tr valign="top"><td width="100%" colspan="2">
                <?php
					$sBasePath = $_SERVER['PHP_SELF'] ;
					$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
					
					$fckEnInfo = new FCKeditor('ban_caption') ;
					$fckEnInfo->Value = stripslashes($ban_obj->ban_caption['value']);
					$fckEnInfo->BasePath	= $sBasePath ;
					$fckEnInfo->Create() ;
				?>
                  </td>
    	 	</tr>
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center"> 
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
               <input type="hidden" name="date_modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="ban_id" value="<?php echo $ban_obj->ban_id['value']; ?>">
              </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="2"> <img align="absmiddle" src="<?php echo ($GLOBALS['in_admin']==1)?"../":"";?>images/reset.jpg" onClick="window.document.<?php echo $ban_obj->frm_name; ?>.reset();">&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="image" src="<?php echo ($GLOBALS['in_admin']==1)?"../":""; ?>images/submit.jpg" name="Submit" border="0" style="border:0px;" align="absmiddle"> 
              <input type="hidden" value="0" name="boolcheck"> </td>
          </tr>
           <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
  </table>
</form>	
</div>
<script language="javascript">
frm_obj = window.document.<?php echo $ban_obj->frm_name; ?>;	
</script>