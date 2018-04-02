<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to Delete this group (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="related_products.php?" + url;
 }
}
</script>
<p align="right"><a href="related_products.php?submit_action=add" class="blue_link">Add 
      New Related Group</a></p>
<table width="95%" border="0" cellspacing="0" cellpadding="3" align="center" class="tableborder_new">
  <tr class="maincontentheading" height=25px> 
    <td width="10%">Group Id</td>
    <td width="15%">Related Group</td>
    <td width="15%">Number of Book</td>
    <td width="15%">Created on</td>
    <td width="15%" align="center">Actions</td>
  </tr>
  <?php
 $preview_url="../forms/admin/related_products_preview_frm.php";
 $list_url="releted_products.php";

$qry = $relprod_obj->cls_sql . " order by rp_id desc";

$paging_cls = new paging($qry);
unset($_SESSION['ses_temp_relprod_obj']);
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
  <tr <?php echo $row_bg_color; ?>  height=30px> 
    <td><a class='blue_link' href="#" onClick="popup_window('basedesign_nh.php?submit_action=preview&id=<?php echo stripslashes($data->rp_id); ?>&url=<?php echo $preview_url; ?>&list_url=<?php echo $list_url; ?>',300,500,'yes','yes');"> 
      <?php
	
	 echo stripslashes($data->rp_id);  
	 ?>
      </a></td>
    <td> 
      <?php  echo $data->rp_name; ?>
    </td>
    <td><?php
	
	$prod_lst_arr = explode(",",$data->products);
	
	echo count($prod_lst_arr);
	
	?></td>
    <td><?php echo convert_date($data->cust_create_datetime); ?></td>
    <td align="center"><a href="related_products.php?submit_action=edit&<?php echo $relprod_obj->primary_fld; ?>=<?php echo stripslashes($data->rp_id); ?>"><img src="../images/icon_edit.gif" border=0 alt="Edit"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $relprod_obj->primary_fld; ?>=<?php echo stripslashes($data->rp_id); ?>')" alt="Delete"></a></td>
  </tr>
  <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan="5" algin='center'> <font class='redfont'>No related product groups 
      were created !!</font></td>
  </tr>
  <?php

}

?>
</table>
<br>
<table cellpadding="0" cellspacing=0 border="0" width="100%"> 
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

