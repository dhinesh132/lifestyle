<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to this record? (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="search_options.php?" + url;
 }
}
function update_record(url)
{
 	  window.location.href="search_options.php?" + url;
}
function order_record(url)
{
 	  window.location.href="search_options.php?" + url;
}
</script>
<style type="text/css">
.bktitle { font-weight: normal; }
</style>
<table width="90%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr > 
    <td align="right"><div align="right" class="pagination"><a href="search_options.php?submit_action=add" class="pagelink">Add New</a> <a href="javascript:void(0)" onclick="delete_selected_item()" class="pagelink">Delete</a></div></td></tr></table>

<div align="center" class="whitebox mtop15">
<table width="70%" cellspacing="0" cellpadding="4" border="0" class="listing">
<tbody>
  <tr class="maincontentheading" height=25px> 
    <th width="10%" nowrap class="listtitle">Id # </th>
    <th width="30%" class="listtitle">Title</th>
    <th width="30%" align="center" class="listtitle">Actions</th>
  </tr>
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/search_options_preview_frm.php";
  $list_url="search_options.php";
  
  $qry = "select * from " . $ban_obj->cls_tbl . " order by Id desc";

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
    <td ><?php echo stripslashes($data->Id); ?></td>
    <td > <?php 
			echo $data->EnTitle;?></td>
    <td ><?php if($data->Status == 1) { ?><a href="#"  onclick="update_record('submit_action=status&Status=1&Id=<?php echo stripslashes($data->Id); ?>')" >De-Activate</a> <?php } else {?> <a href="#"  onclick="update_record('submit_action=status&Status=0&Id=<?php echo stripslashes($data->Id); ?>')"  src="../images/icon_disapprove.gif" >Activate</a><?php }?>  &nbsp;&nbsp;|| &nbsp;&nbsp;<a href="<?php echo $product_page_url; ?>?submit_action=edit&<?php echo $ban_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>">Edit</a>&nbsp;&nbsp;|| &nbsp;&nbsp;<a href="#"  onclick="delete_record('submit_action=delete&<?php echo $ban_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>')" >Delete</a></td>
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

