<?php 
  $preview_url="../forms/admin/shipping_details_preview_frm.php";
 $list_url="shipping_details.php";

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
<p align="right" style="width: 90%;"><a href="shipping_details.php?submit_action=add" class="blue_link">Add New </a></p>
<div align="center" class="whitebox mtop15">
<table width="67%" border="0" cellspacing="0" cellpadding="3" align="center" class="listing">
   <tbody>
  <tr class="maincontentheading" height=25px> 
    <th width="10%" class="listtitle">Id</th>
	<th width="25%" class="listtitle">Weight From</th>
    <th width="25%" class="listtitle">Weight To</th>
	<th width="20%" align="center" class="listtitle">Price</th>
    <th width="20%" align="center" class="listtitle">Actions</th>
  </tr>
  <?php
  

	$qry = "select * from " . $shipping_obj->cls_tbl . " order by id";

$paging_cls = new paging($qry);
unset($_SESSION['ses_shipping_details_obj']);
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
     <?php  echo $data->WeightFrom; ?>    </td>
     <td >
     <?php  echo $data->WeightTo; ?>    </td>
	 <td  ><?php  
	 echo "Zone A: $". $data->ZoneAPrice."<br>"; 
	 echo "Zone B: $". $data->ZoneBPrice."<br>";
	 echo "Zone C: $". $data->ZoneCPrice."<br>";
	 echo "Zone D: $". $data->ZoneDPrice."<br>";
	 echo "Zone E: $". $data->ZoneEPrice."<br>";
	 ?></td>
	
    <td align="center">
	<a href="shipping_details.php?submit_action=edit&<?php echo $shipping_obj->primary_fld; ?>=<?php echo stripslashes($data->id); ?>"><img src="../images/icon_edit.gif" border=0 alt="Edit"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $shipping_obj->primary_fld; ?>=<?php echo stripslashes($data->id); ?>')" alt="Delete"></a></td>
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
                <?php 
				$paging_cls->print_prev();
				$paging_cls->print_numbered_links();
				$paging_cls->print_next();?>
        </div>
	</td>
</tr>
</tbody></table>


</div>