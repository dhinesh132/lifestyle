
<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to delete this news? (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="<?php echo $product_page_url; ?>?" + url;
 }
}
</script>
<style type="text/css">
.bktitle { font-weight: normal; }
</style>
<table width="90%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr > 
    <td align="right"><p align="right"><a href="news_master.php?submit_action=add" class="blue_link">Add 
New News</a></p></td></tr></table>
<table width="90%" border="0" cellspacing="0" cellpadding="3" align="center" class="tableborder_new">
  <tr class="maincontentheading" height=25px> 
    <td width="17%" nowrap class="listtitle"><em>Id # </em></td>
    <td width="29%" class="listtitle" ><em>Heading</em></td>
    <td width="30%" class="listtitle" ><em>News</em></td>
    <td width="24%" align="center" class="listtitle"><em>Actions</em></td>
  </tr>
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/news_master_preview_frm.php";
 
  $qry = "select id, heading,news from " . $news_obj->cls_tbl . "  order by id desc";

$paging_cls = new paging($qry);

unset($_SESSION['ses_temp_news_obj']);
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
    <td><?php echo stripslashes($data->id); ?></td>
    <td><?php echo stripslashes($data->heading); ?></td>
    <td><?php echo trim_text(stripslashes($data->news),50); ?></td>
    <?php if(isset($_SESSION['ses_pl_id'])) {?><?php }?>
    <td align="center"><a href="news_master.php?submit_action=edit&<?php echo $news_obj->primary_fld; ?>=<?php echo stripslashes($data->id); ?>"><img src="../images/icon_edit.gif" border=0 alt="Edit"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $news_obj->primary_fld; ?>=<?php echo stripslashes($data->id); ?>')" alt="Delete"></a></td>
  </tr>
  <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan='4' algin='center'> <font class='redfont'><em>No records available 
      !!.</em></font></td>
  </tr>
  <?php

}

?>
</table>

<table cellpadding="0" cellspacing=0 border="0" width="100%"> 
 <!-- <tr> 
    <td colspan="5" align="center"><span class="hintstyle">Note : To delete a 
      news_master it should not contain any products in it.</span></td>
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

