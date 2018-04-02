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
  <?php if($_SESSION['ses_selected_prnt_prod'] > 0) { ?>
  <a href="product_master.php" class="blue_link">Back To Book List</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
  <?php } ?>
  <a href="<?php echo $product_page_url; ?>?submit_action=add" class="blue_link">Add 
  New Product</a></p>
<table width="95%" border="0" cellspacing="0" cellpadding="3" align="center" class="tableborder_new">
  <tr class="maincontentheading" height=25px> 
    <td width="7%" nowrap>Id</td>
    <td width="20%">Stock Code</td>
    <td width="19%">Model No</td>
    <td width="19%">Color Code</td>
    <td width="11%" nowrap>Qty</td>
    <td width="11%" nowrap>Price($)</td>
    <td width="9%" nowrap>Size</td>
    <?php if($GLOBALS['site_config']['parent_child_option'] == 1 && $children_product != 1) { ?>
    <?php } ?>
    <td width="15%" align="center">Actions</td>
  </tr>
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/product_master_preview_frm.php";
  $list_url="product_master.php";
$qry = "select prod_id, stock_code, date_entered,model_no, size,price,date_modified, color_code, prod_status,stocks_available from " . $prod_obj->cls_tbl . " order by prod_id asc ," . $prod_obj->primary_fld . " desc";

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
  
  if(!array_key_exists($data->category_id, $category_name_arr))
  {
  	$category_name_arr[$data->category_id] = stripslashes($GLOBALS['db_con_obj']->fetch_field($productcategory_obj->cls_tbl, "cat_name", $productcategory_obj->primary_fld . " = '" . $data->category_id . "'"));
  }
  
?>
  <tr <?php echo $row_bg_color; ?>  height=30px> 
    <td><a class='blue_link' href="#" onClick="popup_window('basedesign_nh.php?submit_action=preview&id=<?php echo stripslashes($data->prod_id); ?>&url=<?php echo $preview_url; ?>&list_url=<?php echo $list_url; ?>',450,740,'yes','yes');" ><?php echo stripslashes($data->prod_id); ?></a></td>
    <td> <?php  echo stripslashes($data->stock_code); ?></td>
    <td><?php echo stripslashes($data->model_no); ?></td>
    <td><?php echo stripslashes($data->color_code); ?></td>
    <td><?php                   $buyed = "";									
								$order_qry = "select prod_quantity from order_details where prod_id='".$data->prod_id."'";
								$order_res = $GLOBALS['db_con_obj']->execute_sql($order_qry);
								while($order_data = mysql_fetch_object($order_res[0]))
								{
								    $buyed = $buyed + $order_data->prod_quantity;
								}
								
							  echo $remaining = $data->stocks_available - $buyed;?></td>
    <td><?php echo $data->price; ?></td>
    <td> 
      <?php  echo $data->size; ?>    </td>
    <?php if($GLOBALS['site_config']['parent_child_option'] == 1 && $children_product != 1) { ?>
    <?php } ?>
    <td align="center"><a href="<?php echo $product_page_url; ?>?submit_action=edit&<?php echo $prod_obj->primary_fld; ?>=<?php echo stripslashes($data->prod_id); ?>"><img src="../images/icon_edit.gif" border=0 title="Edit" alt="Edit" align="absmiddle"></a>&nbsp;&nbsp;<a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $prod_obj->primary_fld; ?>=<?php echo stripslashes($data->prod_id); ?>')" title="Delete" alt="Delete" align="absmiddle"></a>&nbsp;&nbsp;<a href="<?php echo $product_page_url; ?>?submit_action=status&id=<?php echo stripslashes($data->prod_id);?>&status=<?php echo stripslashes($data->prod_status);?>"><?php if($data->prod_status == 1){ ?><img src="../images/icon_approve.gif" align="absmiddle" title="Inactivate" alt="Inactivate" hspace="3" border="0" style="cursor: hand"><? }else {?><img src="../images/icon_disapprove.gif" align="absmiddle" title="Activate"  alt="Activate" hspace="3" border="0" style="cursor: hand"><?php } ?></a></td>
  </tr>
  <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan="8" algin='center'> <font class='redfont'>No Products Available 
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

