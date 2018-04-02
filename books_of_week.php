<?php
//$GLOBALS['site_config']['debug'] =1;
$data = $GLOBALS['db_con_obj']->fetch_flds($prod_obj->cls_tbl,"prod_desc,prod_med_image","is_book_of_week = 1 order by date_modified desc limit 0,1");

$week = mysql_fetch_object($data[0]);

$file_path = $prod_obj->attachment_path.$week->prod_med_image;

?>
<table width="95%" cellpadding="0" cellspacing="0" align="center" >
<tr>
  <td colspan="2" valign="top" class="content"><font class="heading">Books of the Week</font></td>
  </tr>
  
<tr>
 <td width="397" class="content" valign="top"><font class="newsletter"><?php echo $week->prod_desc; ?></font></td>
                            <td width="171" align="center" ><img src="<?php echo $file_path;?>"  /></td>
                          </tr>
						 <tr>
                         <td valign="top" colspan="2" height="5" width="200"></td>
</tr>
  <td valign="top" colspan="2" background="images/ash.png" height="2" width="200"></td>
</tr>
</table>