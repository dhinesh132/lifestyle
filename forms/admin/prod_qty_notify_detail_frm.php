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

$img_dim_arr = explode(",",$qty_notify->image_copies['prod_thimg'][1]);
$th_img_arr = explode("|", $img_dim_arr[0]);
$lrg_img_arr = explode("|", $img_dim_arr[1]);


$hid_action = "save";

if($edit == 1 && $edit_id > 0)
{
	
	$res = $qty_notify->fetch_record($edit_id);
	$qty_notify = set_values($qty_notify, "db", $res[0]);

}


if(isset($_SESSION['ses_temp_qty_notify']) && is_array($_SESSION['ses_temp_qty_notify']))
{
	$qty_notify = set_values($qty_notify,"ses",$_SESSION['ses_temp_qty_notify']);
}

?>
<form action="" method="post" enctype="multipart/form-data" name="<?php echo $qty_notify->frm_name; ?>" onSubmit="return check_form(window.document.<?php echo $qty_notify->frm_name; ?>);">
<table width="65%" border="0" cellspacing="0" cellpadding="2" align="center" class="tableborder_new">
   <tr class="maincontentheading"> 
            <td height="29" colspan="2" align='center' class='whitefont_header'>Masthead Details</td>
          </tr> <tr valign="top">
            <td  height="15" class="postaddcontent">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>    
          <tr valign="top" class="postaddcontent"> 
            <td height="30" width="50%"><span class="whitefont">Masthead Images Title </span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="ban_name" value="<?php echo stripslashes($qty_notify->ban_name['value']); ?>" class="inputtxtfld">            </td>
          </tr>
		   <tr valign="top" class="postaddcontent"> 
            <td height="30" width="50%"><span class="whitefont">Masthead Images Link </span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="ban_link" value="<?php echo stripslashes($qty_notify->ban_link['value']); ?>" class="inputtxtfld">            </td>
          </tr>
		   <tr valign="top" class="postaddcontent"> 
            <td height="31"><span class="whitefont">Masthead Images(English)</span></td>
            <td><input type="file" name="EnBanimage" />
              <?php echo display_view_delete_links($qty_notify, "EnBanimage"); ?></td>
          </tr>
		   <tr valign="top" class="postaddcontent"> 
            <td height="31"><span class="whitefont">Masthead Images(Chinese)</span></td>
            <td><input type="file" name="ChBanimage" />
              <?php echo display_view_delete_links($qty_notify, "ChBanimage"); ?></td>
          </tr>
        
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center"> 
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
               <input type="hidden" name="date_modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="ban_id" value="<?php echo $qty_notify->ban_id['value']; ?>">
              </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="2"> <img align="absmiddle" src="<?php echo ($GLOBALS['in_admin']==1)?"../":"";?>images/reset.jpg" onClick="window.document.<?php echo $qty_notify->frm_name; ?>.reset();">&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="image" src="<?php echo ($GLOBALS['in_admin']==1)?"../":""; ?>images/submit.jpg" name="Submit" border="0" style="border:0px;" align="absmiddle"> 
              <input type="hidden" value="0" name="boolcheck"> </td>
          </tr>
           <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
  </table>
</form>	

<script language="javascript">
frm_obj = window.document.<?php echo $qty_notify->frm_name; ?>;	
</script>