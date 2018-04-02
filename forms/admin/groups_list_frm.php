
<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to delete this frame page? (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="<?php echo $product_page_url; ?>?" + url;
 }
}
function update_record(url)
{
 	  window.location.href="groups.php?" + url;
}
function order_record(url)
{
 	  window.location.href="groups.php?" + url;
}
</script>
<style group="text/css">
.bktitle { font-weight: normal; }
</style>
<table width="80%" border="0" cellspacing="0" cellpadding="3" align="center">

<td width="70%">
</td><td width="30%"><div class="pagination"><a href="groups.php?submit_action=add" class="pagelink">Add New </a></div></td>
</table>
<div align="center" class="whitebox mtop15">
<table width="60%" border="0" cellspacing="0" cellpadding="3" class="listing">
<tbody>
  <tr class="maincontentheading" height=25px> 
    <th width="17%" nowrap class="listtitle">Id # </th>
    <th width="39%" class="listtitle" >Groups</th>
    <th width='20%' class="listtitle" align="center">Display Order</th>
    <th width="24%" style="text-align:center" class="listtitle">Actions</th>
  </tr>
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/groups_preview_frm.php";
 
  $qry = "select GroupId, EnName,GroupStatus,DisplayOrder from " . $group_obj->cls_tbl . "  order by DisplayOrder desc";

$paging_cls = new paging($qry);

unset($_SESSION['ses_temp_group_obj']);
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
    <td><?php echo stripslashes($data->GroupId); ?></td>
    <td><?php echo stripslashes($data->EnName); ?></a>    </td>
    <td align="center"><?php
	if($data->DisplayOrder == $cat_count_data[1]) {?><a href="#"><img border="0" onclick="order_record('submit_action=order&perform=down&order_id=<?php echo $data->DisplayOrder;?>&<?php echo $group_obj->primary_fld; ?>=<?php echo stripslashes($data->GroupId); ?>')" align="absmiddle" src="../images/down.gif" alt="Down" title="Down"></a><?php }  
else if($data->DisplayOrder == $cat_count_data[0]) {	?>
<a href="#"><img border="0" onclick="order_record('submit_action=order&perform=up&order_id=<?php echo $data->DisplayOrder;?>&<?php echo $group_obj->primary_fld; ?>=<?php echo stripslashes($data->GroupId); ?>')" align="absmiddle" src="../images/up.gif" alt="Up" title="Up"></a> <?php } 
else { ?>
<a href="#"><img border="0" onclick="order_record('submit_action=order&perform=down&order_id=<?php echo $data->DisplayOrder;?>&<?php echo $group_obj->primary_fld; ?>=<?php echo stripslashes($data->GroupId); ?>')" align="absmiddle" src="../images/down.gif" alt="Down" title="Down"></a>&nbsp;&nbsp;<a href="#"><img border="0" onclick="order_record('submit_action=order&perform=up&order_id=<?php echo $data->DisplayOrder;?>&<?php echo $group_obj->primary_fld; ?>=<?php echo stripslashes($data->GroupId); ?>')" align="absmiddle" src="../images/up.gif" alt="Up" title="Up"></a>
<?php }

	?></td>
    <td align="center"><?php if($data->GroupStatus == 1) { ?><a href="#"><img border="0" onclick="update_record('submit_action=status&GroupStatus=1&id=<?php echo stripslashes($data->GroupId); ?>')"  src="../images/icon_approve.gif" alt="De-Activate" title="De-Activate"></a> &nbsp;&nbsp;&nbsp;<?php } else {?> <a href="#"><img border="0" onclick="update_record('submit_action=status&GroupStatus=0&id=<?php echo stripslashes($data->GroupId); ?>')"  src="../images/icon_disapprove.gif" alt="Activate" title="Activate"></a> &nbsp;&nbsp;&nbsp; <?php }?><a href="groups.php?submit_action=edit&<?php echo $group_obj->primary_fld; ?>=<?php echo stripslashes($data->GroupId); ?>"><img src="../images/icon_edit.gif" border=0 title="Edit" alt="Edit"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $group_obj->primary_fld; ?>=<?php echo stripslashes($data->GroupId); ?>')" title="Delete" alt="Delete"></a></a></td>
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
