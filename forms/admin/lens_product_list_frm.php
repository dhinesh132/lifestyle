<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to Delete this product (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="<?php echo $product_page_url; ?>?" + url;
 }
}
</script>
<style type="text/css">
.bktitle { font-weight: normal; }
</style>
<p align="right">
  <a href="<?php echo $product_page_url; ?>?submit_action=add" class="blue_link">Add 
  New Product</a></p>
<table width="95%" border="0" cellspacing="0" cellpadding="3" align="center" class="tableborder_new">
  <tr class="maincontentheading" height=25px> 
    <td width="7%" nowrap>Id</td>
    <td width="20%">Lens Type</td>
    <td width="19%">Lens Number</td>
    <td width="19%">Price</td>
    <td width="11%" nowrap>Created On</td>
    <td width="9%" nowrap>Modified On</td>
    <?php if($GLOBALS['site_config']['parent_child_option'] == 1 && $children_product != 1) { ?>
    <?php } ?>
    <td width="15%" align="center">Actions</td>
  </tr>
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/product_master_preview_frm.php";
  $list_url="product_master.php";
$qry = "select lens_id, lens_no,lenstype_id,base_price, date_entered, date_modified, prod_status from " . $lens_obj->cls_tbl . " order by lens_id asc ," . $lens_obj->primary_fld . " desc";

$paging_cls = new paging($qry);

unset($_SESSION['ses_lens_product_obj']);
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
    <td><a class='blue_link' href="#" onClick="popup_window('basedesign_nh.php?submit_action=preview&id=<?php echo stripslashes($data->lens_id); ?>&url=<?php echo $preview_url; ?>&list_url=<?php echo $list_url; ?>',450,740,'yes','yes');" ><?php echo stripslashes($data->lens_id); ?></a></td>
    <td> <?php  echo $type= $GLOBALS['db_con_obj']->fetch_field("lense_master","len_name","len_id='".$data->lenstype_id."'"); ?></td>
    <td><?php echo stripslashes($data->lens_no); ?></td>
    <td><?php echo stripslashes($data->base_price); ?></td>
    <td><?php echo convert_date($data->date_entered); ?></td>
    <td> 
      <?php  echo convert_date($data->date_modified); ?>    </td>
    <?php if($GLOBALS['site_config']['parent_child_option'] == 1 && $children_product != 1) { ?>
    <?php } ?>
    <td align="center"><a href="<?php echo $product_page_url; ?>?submit_action=edit&<?php echo $lens_obj->primary_fld; ?>=<?php echo stripslashes($data->lens_id); ?>"><img src="../images/icon_edit.gif" border=0 title="Edit" alt="Edit" align="absmiddle"></a>&nbsp;&nbsp;<a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $lens_obj->primary_fld; ?>=<?php echo stripslashes($data->lens_id); ?>')" title="Delete" alt="Delete" align="absmiddle"></a>&nbsp;&nbsp;<a href="<?php echo $product_page_url; ?>?submit_action=status&id=<?php echo stripslashes($data->lens_id);?>&status=<?php echo stripslashes($data->prod_status);?>"><?php if($data->prod_status == 1){ ?><img src="../images/icon_approve.gif" align="absmiddle" title="Inactivate" alt="Inactivate" hspace="3" border="0" style="cursor: hand"><? }else {?><img src="../images/icon_disapprove.gif" align="absmiddle" title="Activate"  alt="Activate" hspace="3" border="0" style="cursor: hand"><?php } ?></a></td>
  </tr>
  <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan="7" algin='center'> <font class='redfont'>No Products Available 
      !!.</font></td>
  </tr>
  <?php

}

?>
</table>
<br>
<table cellpadding="0" cellspacing=0 border="0" width="100%"> 
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

