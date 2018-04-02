
<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to Delete this image? (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="product_images.php?" + url;
 }
}
function update_record(url)
{
 	  window.location.href="product_images.php?" + url;
}
function order_record(url)
{
 	  window.location.href="product_images.php?" + url;
}
</script>
<style type="text/css">
.bktitle { font-weight: normal; }
</style>

 <table width="80%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr > 
    <td align="right"><div align="right" class="pagination"><a href="product_images.php?submit_action=add" class="pagelink">Add New </a> </div></td></tr></table>
 <br />
<div align="center" class="whitebox mtop15">
<table width="55%" border="0" cellspacing="0" cellpadding="3" align="center" class="listing">
  <tr class="maincontentheading" height=25px> 
    <th width="5%" nowrap class="listtitle">Id # </th>
    <th width="50%" class="listtitle">Colour</th>   
    <th width='20%' class="listtitle" style="text-align:center" >Display Order</th>
    <th width="25%" style="text-align:center" class="listtitle">Actions</th>
  </tr>
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/product_images_preview_frm.php";
  $list_url="product_images.php";
  
  $qry = "select * from " . $prod_obj->cls_tbl . " where ProdId=".$_SESSION['ses_prod_id']." order by DisplayOrder desc";

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
  
  
 $prod_img = $prod_obj->attachment_path.$data->Image;
?>
  <tr <?php echo $row_bg_color; ?>  height=30px> 
    <td><?php echo stripslashes($data->Id); ?></td>
    <td><?php echo $data->EnTitle;?></td>
    <td align="center"><?php
	if($data->DisplayOrder == $cat_count_data[1]) {?><a href="#"><img border="0" onclick="order_record('submit_action=order&perform=down&order_id=<?php echo $data->DisplayOrder;?>&<?php echo $prod_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>')" align="absmiddle" src="../images/down.gif" alt="Down" title="Down"></a><?php }  
else if($data->DisplayOrder == $cat_count_data[0]) {	?>
<a href="#"><img border="0" onclick="order_record('submit_action=order&perform=up&order_id=<?php echo $data->DisplayOrder;?>&<?php echo $prod_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>')" align="absmiddle" src="../images/up.gif" alt="Up" title="Up"></a> <?php } 
else { ?>
<a href="#"><img border="0" onclick="order_record('submit_action=order&perform=down&order_id=<?php echo $data->DisplayOrder;?>&<?php echo $prod_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>')" align="absmiddle" src="../images/down.gif" alt="Down" title="Down"></a>&nbsp;&nbsp;<a href="#"><img border="0" onclick="order_record('submit_action=order&perform=up&order_id=<?php echo $data->DisplayOrder;?>&<?php echo $prod_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>')" align="absmiddle" src="../images/up.gif" alt="Up" title="Up"></a>
<?php }

	?></td>
    <td align="center"><?php if($data->Status == 1) { ?><a href="#" onclick="update_record('submit_action=status&Status=1&Id=<?php echo stripslashes($data->Id); ?>')" >De-Activate</a><?php } else {?> <a href="#"  onclick="update_record('submit_action=status&Status=0&Id=<?php echo stripslashes($data->Id); ?>')"  src="../images/icon_disapprove.gif" >Activate</a><?php }?>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="<?php echo $product_page_url; ?>?submit_action=edit&<?php echo $prod_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>"><img src="<?php echo $img_pth; ?>images/icon_edit.gif" border=0 alt="Edit"></a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="#"><img src="<?php echo $img_pth; ?>images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $prod_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>')" alt="Delete"></a></td>
  </tr>
  <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan='7' algin='center'> <font class='redfont'>No records available 
      !!.</font></td>
  </tr>
  <?php

}

?>
</table>
<br />
<table width="60%" cellspacing="0" cellpadding="4" border="0">
<tbody><tr>
	<td width="" align="left" style="font-size:12px;">
		<?php $paging_cls->print_pages_of();?>	</td>
	<td align="right">
		<div class="pagination">
                <?php $paging_cls->print_numbered_links();?>
        </div>
	</td>
</tr>
</tbody></table>


</div>