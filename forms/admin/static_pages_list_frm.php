
<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to delete this page?");
 if (doyou == true)
 {
 	  window.location.href="<?php echo $page_url; ?>?" + url;
 }
}

function order_record(url)
{
 	  window.location.href="<?php echo $page_url; ?>?" + url;
}

function update_record(url)
{
 	  window.location.href="<?php echo $page_url;?>?" + url;
}
</script>
<style type="text/css">
.bktitle { font-weight: normal; }
</style>
<table width="80%" border="0" cellspacing="0" cellpadding="3" align="center">

<td width="70%">
</td><td width="30%"><div class="pagination"><a href="<?php echo $page_url;?>?submit_action=add" class="pagelink">Add New Page</a></div></td>
</table>
<div align="center" class="whitebox mtop15">


<table width="80%" cellspacing="0" cellpadding="4" border="0" class="listing">
<tbody>
  <tr class="maincontentheading" height=25px> 
    <th width="5%" nowrap class="listtitle">Id # </th>
    <th width='15%' class="listtitle" align="left">Title</th>
    <th width='10%' class="listtitle" align="left">Menu Type</th>
    <th width='15%' class="listtitle" align="left">Menu Level</th>
    <th width='10%' class="listtitle" align="center" >Display Order</th>
    <th width='15%' nowrap class="listtitle" align="left">Created On</th>
    <th width="25%" style="text-align:center"class="listtitle">Actions</th>
  </tr>
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/static_pages_preview_frm.php";
  //echo $_SESSION['ses_admin_id'];
  $qry = "select * from " . $sbg_obj->cls_tbl . " where 1=1 order by display_order desc";
  


$paging_cls = new paging($qry);

unset($_SESSION['ses_temp_spg_obj']);
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
    <td><?php echo stripslashes($data->Id); ?></td>
    <td><?php echo stripslashes($data->EnTitle); ?>    </td>
    <td><?php 
	 if($data->menu_type ==3)
		echo "Main & Footer menu";
	else if($data->menu_type ==4)
		echo "Sub menu";
	else if($data->menu_type ==5)
		echo "Tab menu";
	else if($data->menu_type ==2)
		echo "Footer menu";
	else if($data->menu_type ==1)
		echo "Main Menu";
	else 
		echo "Not in Menu"; 
			?>    </td>
    <td><?php if($data->parent_id ==0)
				echo "Top Level";
			  else {
				echo $GLOBALS['db_con_obj']->fetch_field($sbg_obj->cls_tbl,'EnTitle','Id='.$data->parent_id);
			  }
			?>    </td> 
   <td align="center"><?php
	if($data->display_order == $cat_count_data[1]) {?><a href="#"><img border="0" onclick="order_record('submit_action=order&perform=down&order_id=<?php echo $data->display_order;?>&<?php echo $sbg_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>')" align="absmiddle" src="../images/down.gif" alt="Down" title="Down"></a><?php }  
else if($data->display_order == $cat_count_data[0]) {	?>
<a href="#"><img border="0" onclick="order_record('submit_action=order&perform=up&order_id=<?php echo $data->display_order;?>&<?php echo $sbg_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>')" align="absmiddle" src="../images/up.gif" alt="Up" title="Up"></a> <?php } 
else { ?>
<a href="#"><img border="0" onclick="order_record('submit_action=order&perform=down&order_id=<?php echo $data->display_order;?>&<?php echo $sbg_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>')" align="absmiddle" src="../images/down.gif" alt="Down" title="Down"></a>&nbsp;&nbsp;<a href="#"><img border="0" onclick="order_record('submit_action=order&perform=up&order_id=<?php echo $data->display_order;?>&<?php echo $sbg_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>')" align="absmiddle" src="../images/up.gif" alt="Up" title="Up"></a>
<?php }

	?></td>
    <td><?php echo convert_date($data->date_entered); ?></td>
    <td align="center"><?php if($data->display_status == 1) { ?><a href="#" onclick="update_record('submit_action=status&display_status=1&Id=<?php echo stripslashes($data->Id); ?>')">De-Activate</a> &nbsp;&nbsp;||&nbsp;&nbsp;<?php } else {?><a href="#" onclick="update_record('submit_action=status&display_status=0&Id=<?php echo stripslashes($data->Id); ?>')">Activate</a>&nbsp;&nbsp;||&nbsp;&nbsp;<?php } ?><a href="static_pages.php?submit_action=edit&<?php echo $sbg_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>">Edit</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="#" onclick="delete_record('submit_action=delete&<?php echo $sbg_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>')">Delete</a></td>
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
