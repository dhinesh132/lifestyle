<?php 
  $preview_url="../forms/admin/shipping_settings_preview_frm.php";
 $list_url="shipping_settings.php";

?>
<script language="JavaScript">
function delete_record(url)
{
 doyou = confirm("Do you want to Delete this category (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="<?php echo $admin_menu_file; ?>?" + url;
 }
}

function update_record(url)
{
 	  window.location.href="<?php echo $list_url; ?>?" + url;
}
</script>
<!--<p align="right" style="width: 90%;"><a href="shipping_settings.php?submit_action=add" class="blue_link">Add New </a></p>-->
<table width="80%" border="0" cellspacing="0" cellpadding="3" align="center" class="tableborder_new">
  <tr class="maincontentheading"  height=25px>
    <td width="15%" class="listtitle">Id</td>
	<td width="28%" class="listtitle">Weight</td>
	<td width="18%" align="center" class="listtitle">Price</td>
    <td width="22%" align="center" class="listtitle">Actions</td>
  </tr>
  <?php
  

	$qry = "select * from " . $setting_obj->cls_tbl . " order by id";

$paging_cls = new paging($qry);
unset($_SESSION['ses_shipping_settings_obj']);
//echo $paging_cls->start_index ." - " . $paging_cls->end_index . "<hr>";

for($i=$paging_cls->start_index;$i<$paging_cls->end_index;$i++)
{
  if(mysql_data_seek($paging_cls->resultset,$i))
  {
  	$data = mysql_fetch_object($paging_cls->resultset);  
  }
  else
  {
  	unset($data);
  }
  
  if(isset($data))
  {
 if(file_exists("../includes/admin_alternate_color.php"))
  include("../includes/admin_alternate_color.php");
  else
  include("includes/admin_alternate_color.php");
?>

  <tr <?php echo $row_bg_color; ?>  height=30px >
    <td><a class='blue_link'  href="#" onclick="popup_window('basedesign_nh.php?submit_action=preview&id=<?php echo stripslashes($data->id); ?>&url=<?php echo $preview_url; ?>&list_url=<?php echo $list_url; ?>',400,500,'yes','yes')";>
      <?php
	
	 echo stripslashes($data->id);  
	 ?>
    </a></td>
       
    <td >
     <?php  echo $data->Weight; ?>    </td>
	 <td  ><?php  echo $data->ZoneAPrice; ?></td>
	
    <td align="center">
	<a href="shipping_settings.php?submit_action=edit&<?php echo $setting_obj->primary_fld; ?>=<?php echo stripslashes($data->id); ?>"><img src="../images/icon_edit.gif" border=0 alt="Edit"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $setting_obj->primary_fld; ?>=<?php echo stripslashes($data->id); ?>')" alt="Delete"></a></td>
  </tr>
  <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan="5" algin='center'> <font class='redfont'>No Records Available !!.</font></td>
  </tr>
  <?php

}

?>
</table>
<br>
<table cellpadding="0" cellspacing=0 border="0" width="80%" align="center"> 
 <!-- <tr> 
    <td colspan="5" align="center"><span class="hintstyle">Note : To delete a 
      shipping_settings it should not contain any products in it.</span></td>
  </tr> -->
  <tr>
	  <td height=5px>
	  </td>
  </tr>
  <tr> 
    <td align="center" width="33%"> 
      <?php
	
	
$paging_cls->print_prev();


	
	
	?>
    </td>
    <td colspan="3" align="center" width="34%"> 
      <?php
	
$paging_cls->print_numbered_links();

$paging_cls->print_pages_of();

	
	?>
    </td>
    <td align="center" width="33%"> 
      <?php
	
	$paging_cls->print_next();

	
	?>
    </td>
  </tr>
</table>

