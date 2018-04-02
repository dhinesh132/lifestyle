<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to this record? (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="banner_master.php?" + url;
 }
}
function order_record(url)
{
 	  window.location.href="banner_master.php?"  + url;
}
function update_record(url)
{
 	  window.location.href="banner_master.php?" + url;
}
</script>
<style type="text/css">
.bktitle { font-weight: normal; }
</style>
 <table width="90%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr > 
    <td align="right"><div align="right" class="pagination"><a href="banner_master.php?submit_action=add" class="pagelink">Add New </a> </div></td></tr></table>

<div align="center" class="whitebox mtop15">
<table width="60%" cellspacing="0" cellpadding="4" border="0" class="listing">
<tbody>
  <tr class="maincontentheading" height=25px> 
    <th width="10%" nowrap class="listtitle">Image # </th>
    <th width="40%" class="listtitle">Banner Title</th>
     <th width="20%" style="text-align:center" class="listtitle">Display Order</th>
    <th width="30%"  style="text-align:center" class="listtitle">Actions</th>
  </tr>
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/banner_master_preview_frm.php";
  $list_url="banner_master.php";
  
  $qry = "select ban_id, ban_name,ban_status,display_order from " . $ban_obj->cls_tbl . " order by display_order desc";

$paging_cls = new paging($qry);

unset($_SESSION['ses_temp_product_obj']);
//echo $paging_cls->start_index ." - " . $paging_cls->end_index . "<hr>";

$category_name_arr = array();

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
  <tr <?php echo $row_bg_color; ?>  height=30px> 
    <td align="center"><?php echo stripslashes($data->ban_id); ?></td>
    <td > 
      <a title="<?php  echo stripslashes($data->ban_name); ?>" class="bktitle"><?php  echo trim_text($data->ban_name,30); ?></a>    </td>
       <td align="center"><?php
	if($data->display_order == $cat_count_data[1]) {?><a href="#"><img border="0" onclick="order_record('submit_action=order&perform=down&menu_type=<?php echo $data->menu_type;?>&order_id=<?php echo $data->display_order;?>&<?php echo $ban_obj->primary_fld; ?>=<?php echo stripslashes($data->ban_id); ?>')" align="absmiddle" src="../images/down.gif" alt="Down" title="Down"></a><?php }  
else if($data->display_order == $cat_count_data[0]) {	?>
<a href="#"><img border="0" onclick="order_record('submit_action=order&perform=up&menu_type=<?php echo $data->menu_type;?>&order_id=<?php echo $data->display_order;?>&<?php echo $ban_obj->primary_fld; ?>=<?php echo stripslashes($data->ban_id); ?>')" align="absmiddle" src="../images/up.gif" alt="Up" title="Up"></a> <?php } 
else { ?>
<a href="#"><img border="0" onclick="order_record('submit_action=order&perform=down&menu_type=<?php echo $data->menu_type;?>&order_id=<?php echo $data->display_order;?>&<?php echo $ban_obj->primary_fld; ?>=<?php echo stripslashes($data->ban_id); ?>')" align="absmiddle" src="../images/down.gif" alt="Down" title="Down"></a>&nbsp;&nbsp;<a href="#"><img border="0" onclick="order_record('submit_action=order&perform=up&menu_type=<?php echo $data->menu_type;?>&order_id=<?php echo $data->display_order;?>&<?php echo $ban_obj->primary_fld; ?>=<?php echo stripslashes($data->ban_id); ?>')" align="absmiddle" src="../images/up.gif" alt="Up" title="Up"></a>
<?php }

	?></td>
    <td align="center"><?php if($data->ban_status == 1) { ?><a href="#"  onclick="update_record('submit_action=status&ban_status=1&ban_id=<?php echo stripslashes($data->ban_id); ?>')" >De-Activate</a> <?php } else {?> <a href="#" onclick="update_record('submit_action=status&ban_status=0&ban_id=<?php echo stripslashes($data->ban_id); ?>')" >Activate</a> &nbsp;&nbsp;&nbsp; <?php }?>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="<?php echo $product_page_url; ?>?submit_action=edit&<?php echo $ban_obj->primary_fld; ?>=<?php echo stripslashes($data->ban_id); ?>"><img src="<?php echo $img_pth; ?>images/icon_edit.gif" border=0 alt="Edit"></a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="#"><img src="<?php echo $img_pth; ?>images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $ban_obj->primary_fld; ?>=<?php echo stripslashes($data->ban_id); ?>')" alt="Delete"></a></td>
  </tr>
  <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan="3" algin='center'> <font class='redfont'>No Image Available 
      !!.</font></td>
  </tr>
  <?php

}

?>
</table>
<br>
<table cellpadding="0" align="center" cellspacing=0 border="0" width="55%"> 
 <!-- <tr> 
    <td colspan="5" align="center"><span class="hintstyle">Note : To delete a 
      customers it should not contain any products in it.</span></td>
  </tr> -->
  <tr>
	  <td height=5px colspan="5">
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
</div>

