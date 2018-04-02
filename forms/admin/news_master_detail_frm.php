<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script language="javascript">
var frm_obj;
    function check_validate() 
	{
        error_message = "Errors have occurred during the process of your form.\n\nPlease make the following corrections:\n\n";  
		check_empty(form.elements["heading"].name,"Heading should not be empty");
		check_empty(form.elements["news"].name,"Description should not be empty");
		
		  
	}

</script>

</script>
 
<?php 

$hid_action = "save";

if($edit == 1 && $edit_id > 0)
{
	
	$res = $news_obj->fetch_record($edit_id);
	$news_obj = set_values($news_obj, "db", $res[0]);

}


if(isset($_SESSION['ses_temp_news_obj']) && is_array($_SESSION['ses_temp_news_obj']))
{
	$news_obj = set_values($news_obj,"ses",$_SESSION['ses_temp_news_obj']);
}

?>
<form action="" method="post" enctype="multipart/form-data" name="<?php echo $news_obj->frm_name; ?>" onSubmit="return check_form(window.document.<?php echo $news_obj->frm_name; ?>);">
<table width="55%" border="0" cellspacing="0" cellpadding="2" align="center" class="tableborder_new">
   <tr class="maincontentheading"> 
            <td height="29" colspan="2" align='center' class='whitefont_header'>Frame Details</td>
          </tr> <tr valign="top">
            <td  height="15" class="postaddcontent">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		  <?php
				if(isset($_SESSION['ses_pl_id']))
				{
				?>
         
			<?php
				}
				else
				{
				  ?>
				  <input type="hidden" name="pl_id" value="<?php echo $_SESSION['ses_pl_id'];?>">
				  <?php
				}
			?>
          <tr valign="top"> 
            <td  height="30" width="23%" class="postaddcontent"><span class="whitefont">Heading </span><span class="starcolor">*</span></td>
            <td width="77%"><input type="text" name="heading" value="<?php echo stripslashes($news_obj->heading['value']); ?>" class="mediumtxtbox">   </td>
    </tr>
          

	        <tr valign="top">
              <td  height="30" class="postaddcontent"><span class="whitefont">Description </span><span class="starcolor">*</span></td>
	          <td><textarea name="news"  cols="45" rows="5"><?php echo stripslashes($news_obj->news['value']); ?></textarea>
              </td>
    </tr>
    <tr valign="top" class="postaddcontent">
      <td  height="26"><span class="whitefont">Status</span></td>
      <td><select name="status" class="mediumtxtbox1">
		  <option value="0" <?php echo ($news_obj->status['value'] == 0)?"selected":""; ?>>In-Active</option>
            <option value="1" <?php echo ($news_obj->status['value'] == 1)?"selected":""; ?>>Active</option>
                
      </select></td>
    <tr valign="top" class="postaddcontent"> 
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center"> 
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
               <input type="hidden" name="date_entered" value="<?php echo (strlen($news_obj->date_entered['value']) > 0)?$news_obj->date_entered['value']:date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="date_modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="id" value="<?php echo $news_obj->id['value']; ?>">
              </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="2"><a href="#"><img align="absmiddle" src="../images/reset.jpg" onClick="window.document.<?php echo $news_obj->frm_name; ?>.reset();" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="image" src="../images/submit.jpg" name="Submit" border="0" style="border:0px;" align="absmiddle"> 
              <input type="hidden" value="0" name="boolcheck"> </td>
          </tr>
          <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
  </table>
</form>	

<script language="javascript">
frm_obj = window.document.<?php echo $news_obj->frm_name; ?>;	
</script>