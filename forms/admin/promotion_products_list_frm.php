<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to this record? (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="promotion_products.php?" + url;
 }
}
function update_record(url)
{
 	  window.location.href="promotion_products.php?" + url;
}
function order_record(url)
{
 	  window.location.href="promotion_products.php?" + url;
}
</script>
<style type="text/css">
.bktitle { font-weight: normal; }
</style>
<?php 
$promotionCatId = $_REQUEST['promotion_cat_id'];
  
  //Get Promotion Category
  $promotion_res = $GLOBALS['db_con_obj']->fetch_flds('promotion_banner',"EnTitle","Id='".$promotionCatId."'");
  $promotion_data = mysql_fetch_object($promotion_res[0]);
 
?>
<table width="90%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr > 
    <td align="right"><div align="right" class="pagination"><a href="promotion_products.php?submit_action=add&promotion_cat_id=<?php echo $_REQUEST['promotion_cat_id'];?>" class="pagelink">Add New</a> <a href="javascript:void(0)" onclick="delete_selected_item()" class="pagelink">Delete</a></div></td></tr></table>

<div align="center" class="whitebox mtop15">
<table width="70%" cellspacing="0" cellpadding="4" border="0" class="listing">
<tbody>
  <tr class="maincontentheading" height=25px> 
    <th width="10%" nowrap class="listtitle">Id # </th>
    <th width="30%" class="listtitle">Product</th>
    <th width="20%" class="listtitle">Package</th>
    <th width="20%" align="center" class="listtitle">Actions</th>
  </tr>
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/promotion_products_preview_frm.php";
  $list_url="promotion_banner.php";
  $qry = "select * from " . $ban_obj->cls_tbl . " where promotion_cat_id = $promotionCatId order by Id desc";

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
  
  $promotionCatId = $_REQUEST['promotion_cat_id'];
  //Get Package data
  $package_res = $GLOBALS['db_con_obj']->fetch_flds('product_sizes',"EnTitle","Id='".$data->package_id."'");
  $package_data = mysql_fetch_object($package_res[0]);
  
  //Get Product data
  $product_res = $GLOBALS['db_con_obj']->fetch_flds('products',"EnName","Id='".$data->product_id."'");
  $product_data = mysql_fetch_object($product_res[0]);
  
?>
  <tr <?php echo $row_bg_color; ?>  height=30px> 
    <td ><?php echo stripslashes($data->id); ?></td>
    <td > <?php 
			echo stripslashes($product_data->EnName);?></td>
        <td ><?php  echo stripslashes($package_data->EnTitle); ?></td>
    <td ><?php if($data->status == 1) { ?><a href="#"><img border="0" onclick="update_record('submit_action=status&status=1&promotion_cat_id=<?php echo stripslashes($promotionCatId);?>&id=<?php echo stripslashes($data->id); ?>')"  src="../images/icon_approve.gif" alt="De-Activate" title="De-Activate"></a> &nbsp;&nbsp;&nbsp;<?php } else {?> <a href="#"><img border="0" onclick="update_record('submit_action=status&status=0&promotion_cat_id=<?php echo stripslashes($promotionCatId);?>&id=<?php echo stripslashes($data->id); ?>')"  src="../images/icon_disapprove.gif" alt="Activate" title="Activate"></a> &nbsp;&nbsp;&nbsp; <?php }?><a href="#"><img src="<?php echo $img_pth; ?>images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&promotion_cat_id=<?php echo stripslashes($promotionCatId);?>&<?php echo $ban_obj->primary_fld; ?>=<?php echo stripslashes($data->id); ?>')" alt="Delete"></a></td>
  </tr>
  <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan="4" algin='center'> <font class='redfont'>No Products Available !!.</font></td>
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

