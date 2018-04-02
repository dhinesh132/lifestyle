<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to Delete this image? (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="prod_qty_notify.php?" + url;
 }
}
function update_record(url)
{
 	  window.location.href="prod_qty_notify.php?" + url;
}
</script>
<style type="text/css">
.bktitle { font-weight: normal; }
</style>

<table width="85%" border="0" cellspacing="0" cellpadding="3" align="center" class="tableborder_new">
  <tr class="maincontentheading" height=25px> 
    <td width="10%" nowrap class="listtitle">Id# </td>
    <td width="30%" class="listtitle">Product Name</td>
    <td width="25%" class="listtitle">Product Code/Id</td>
    <td width="20%" class="listtitle">Quantity</td>
    <td width="15%" align="center" class="listtitle">Actions</td>
  </tr>
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/prod_qty_notify_preview_frm.php";
  $list_url="prod_qty_notify.php";
  
  $qry = "select * from " . $qty_notify->cls_tbl . " order by " . $qty_notify->primary_fld . " desc";

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
  
  
  $prod_res = $GLOBALS['db_con_obj']->fetch_flds("products","EnName,Id,ProdCode","Id=".$data->ProdId);
  $prod_data = mysql_fetch_object($prod_res[0]);
  
?>
  <tr <?php echo $row_bg_color; ?>  height=30px> 
    <td><?php echo stripslashes($data->QId); ?></td>
    <td><?php  echo trim_text($prod_data->EnName,30); ?></td>
    <td><?php  echo trim_text($prod_data->ProdCode,30)." / ".$prod_data->Id; ?></td>
    
    <td><?php echo ProductQuantity($prod_data->Id); ?></td>
    <td align="center"><a href="#"><img src="<?php echo $img_pth; ?>images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $qty_notify->primary_fld; ?>=<?php echo stripslashes($data->QId); ?>')" alt="Delete"></a>&nbsp;&nbsp;<a href="products.php?submit_action=update_qty&Id=<?php echo stripslashes($data->ProdId); ?>"><img src="../images/icon_config.gif" border=0 title="Update Quantity" alt="Update Quantity"></a></td>
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

